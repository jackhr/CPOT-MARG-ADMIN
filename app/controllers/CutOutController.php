<?php

namespace App\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Cutout;
use Exception;

class CutoutController extends Controller
{
    private $cutoutModel;
    private $helper;

    public function __construct()
    {
        $this->cutoutModel = new Cutout();
        $this->helper = new GeneralHelper();
    }

    public function listCutouts()
    {
        $logged_in_user = $_SESSION['user'];
        $table = "cutouts";
        $override_query = "SELECT $table.*, users_c.email AS created_by_email, users_u.email AS updated_by_email 
            FROM $table
            LEFT JOIN users users_c ON $table.created_by = users_c.user_id
            LEFT JOIN users users_u ON $table.updated_by = users_u.user_id";
        $cutouts = $this->cutoutModel->readAll($override_query);
        if ($logged_in_user['role_id'] > 1) {
            $cutouts = array_filter($cutouts, function ($cutout) {
                return !isset($cutout['deleted_at']);
            });
        }
        $this->view("admin/cutouts/list.php", [
            "user" => $logged_in_user,
            "cutouts" => $cutouts,
            "title" => "Cutouts"
        ]);
    }

    public function create()
    {
        $name = $_POST['name'];
        $uploadedFile = null;
        $new_cutout = [];
        $status = 200;
        $message = "";

        if (isset($_FILES['cutout-img'])) {
            $uploadedFile = $_FILES['cutout-img'];
            $fileType = $uploadedFile['type'];
            $extension = $this->helper->getFileExtension($fileType);

            $public_directory = "/assets/images/gallery/cutouts/";
            $newFileName = $name . $extension;
            $image_url = $public_directory . $newFileName;

            if (!strlen($extension)) {
                $status = 415;
                $message = "The file type was not recognized. Please use jpeg, png, webp, avif, or tiff.";
            } else if (!$this->helper->checkIfFileTypeIsAcceptable($fileType)) {
                $status = 409;
                $message = "The file type is not acceptable. Please use jpeg, png, webp, avif, or tiff.";
            }
        } else {
            $status = 409;
            $message = "No file uploaded.";
        }

        if ($this->cutoutModel->findByName($name)) {
            $status = 409;
            $message = "There is already a cutout with that name.";
        }

        if ($status !== 200) {
            $this->helper->respondToClient($new_cutout, $status, $message);
        }

        [
            "name" => $name,
            "description" => $description,
            "cutout_type" => $cutout_type,
        ] = $_POST;

        $this->cutoutModel->name = $name;
        $this->cutoutModel->description = $description;
        $this->cutoutModel->image_url = $image_url;
        $this->cutoutModel->cutout_type = $cutout_type;
        $this->cutoutModel->created_by = $_SESSION['user']['user_id'];

        if ($this->cutoutModel->create()) {
            $message = "Cutout created successfully.";
            $new_cutout = $this->cutoutModel->findByName($name);
            $tmpName = $uploadedFile['tmp_name'];

            $uploadDirectory = __DIR__ . '/../../public' . $public_directory;
            $destination = $uploadDirectory . $newFileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($tmpName, $destination)) {
                $message = "File uploaded successfully.";
            } else {
                $status = 500;
                $message = "Cutout was created but the file upload failed.";
            }
        } else {
            $status = 409;
            $message = "Error creating cutout.";
        }

        $this->helper->respondToClient($new_cutout, $status, $message);
    }

    public function update($cutout_id)
    {
        $name = $_POST['name'];
        $uploadedFile = null;
        $new_cutout = [];
        $status = 200;
        $message = "";
        $changing_image = isset($_FILES['cutout-img']);

        $cutout = $this->cutoutModel->findById($cutout_id);
        $cutout_with_same_name = $this->cutoutModel->findByName($name);

        // Check if the cutout with the given ID exists
        if (!$cutout) {
            $status = 409;
            $message = "There is no cutout with this id.";
        } else if ($cutout_with_same_name !== false) {
            if (
                ($cutout_with_same_name['cutout_id'] !== $cutout['cutout_id']) &&
                ($cutout_with_same_name['name'] === $name)
            ) {
                $status = 409;
                $message = "There is already a unique cutout with that name.";
            }
        }

        try {
            if ($changing_image) {
                $uploadedFile = $_FILES['cutout-img'];
                $fileType = $uploadedFile['type'];
                $extension = $this->helper->getFileExtension($fileType);

                if (!strlen($extension)) {
                    $status = 415;
                    throw new Exception("The file type was not recognized. Please use jpeg, png, webp, avif, or tiff.");
                } else if (!$this->helper->checkIfFileTypeIsAcceptable($fileType)) {
                    $status = 409;
                    throw new Exception("The file type is not acceptable. Please use jpeg, png, webp, avif, or tiff.");
                }

                // Prepare file paths
                $public_directory = __DIR__ . '/../../public';
                $relative_directory = "/assets/images/gallery/cutouts/";
                $newFileName = $name . $extension;
                $new_image_url = $relative_directory . $newFileName;
                $uploadDirectory = $public_directory . $relative_directory;
                $destination = $uploadDirectory . $newFileName;

                $tmpName = $uploadedFile['tmp_name'];
                $old_image_path = $public_directory . $cutout['image_url'];

                // Handle existing file replacement or renaming
                if (file_exists($old_image_path)) {
                    if ($cutout['name'] === $name) {
                        // If the name hasn't changed, just overwrite the old image
                        if (!move_uploaded_file($tmpName, $old_image_path)) {
                            $status = 500;
                            throw new Exception("Failed to overwrite the existing image.");
                        }

                        if (!rename($old_image_path, $public_directory . $new_image_url)) {
                            $status = 500;
                            throw new Exception("Failed to rename the updated image.");
                        }
                    } else {
                        // If the name has changed, delete the old image
                        if (!unlink($old_image_path)) {
                            $status = 500;
                            throw new Exception("Failed to delete the old image.");
                        }

                        // Upload the new image to the new file path
                        if (!move_uploaded_file($tmpName, $destination)) {
                            $status = 500;
                            throw new Exception("Failed to upload the new image.");
                        }
                    }
                } else {
                    // If the old image doesn't exist, just upload the new one
                    if (!move_uploaded_file($tmpName, $destination)) {
                        $status = 500;
                        throw new Exception("Failed to upload the new image.");
                    }
                }
            } else if ($cutout['name'] !== $name) {
                // not changing image, but changing name
                $fileInfo = pathinfo($cutout['image_url']);
                $extension = $fileInfo['extension'];

                $public_directory = __DIR__ . '/../../public';
                $relative_directory = "/assets/images/gallery/cutouts/";
                $newFileName = "$name.$extension";
                $new_image_url = $relative_directory . $newFileName;
                $uploadDirectory = $public_directory . $relative_directory;
                $destination = $uploadDirectory . $newFileName;

                $old_image_path = $public_directory . $cutout['image_url'];

                if (file_exists($old_image_path)) {
                    if (!rename($old_image_path, $destination)) {
                        $status = 500;
                        throw new Exception("Failed to rename the image.");
                    }
                } else {
                    $status = 500;
                    throw new Exception("File does not exist.");
                }
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        if ($status !== 200) {
            $this->helper->respondToClient($new_cutout, $status, $message);
        }

        [
            "name" => $name,
            "description" => $description,
            "cutout_type" => $cutout_type,
        ] = $_POST;


        $this->cutoutModel->cutout_id = $cutout_id;
        $this->cutoutModel->name = $name;
        $this->cutoutModel->description = $description;
        $this->cutoutModel->image_url = isset($new_image_url) ? $new_image_url : $cutout['image_url'];
        $this->cutoutModel->cutout_type = $cutout_type;
        $this->cutoutModel->updated_by = $_SESSION['user']['user_id'];

        if ($this->cutoutModel->update()) {
            $message = "cutout updated successfully.";
            $updated_cutout = $this->cutoutModel->findById($cutout_id);
        } else {
            $status = 409;
            $message = "Error updating cutout.";
        }

        $this->helper->respondToClient($updated_cutout, $status, $message);
    }

    public function delete($cutout_id)
    {
        $cutout_to_delete = $this->cutoutModel->findById($cutout_id);
        $status = 200;
        $message = "";

        $this->cutoutModel->cutout_id = $cutout_id;

        if ($this->cutoutModel->delete()) {
            $message = "Cutout deleted successfully.";
            $cutout_to_delete = $this->cutoutModel->findById($cutout_id);
        } else {
            $status = 500;
            $message = "Error deleting cutout.";
        }

        $this->helper->respondToClient($cutout_to_delete, $status, $message);
    }
}
