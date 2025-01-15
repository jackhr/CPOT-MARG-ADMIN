<?php

namespace App\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Cutout;
use App\Models\CutoutImage;
use Exception;

class CutoutController extends Controller
{
    private $cutoutModel;
    private $cutoutImageModal;
    private $helper;

    public function __construct()
    {
        $this->cutoutModel = new Cutout();
        $this->cutoutImageModal = new CutoutImage();
        $this->helper = new GeneralHelper();
    }

    public function listCutouts()
    {
        $logged_in_user = $_SESSION['user'];
        $this->view("admin/cutouts/list.php", [
            "user" => $logged_in_user,
            "title" => "Cutouts"
        ]);
    }

    public function getAll()
    {
        $logged_in_user = $_SESSION['user'];
        $override_query = "SELECT cutouts.*, cutout_images.image_url, users_c.email AS created_by_email, users_u.email AS updated_by_email 
            FROM cutouts
            LEFT JOIN cutout_images ON cutouts.primary_image_id = cutout_images.image_id
            LEFT JOIN users users_c ON cutouts.created_by = users_c.user_id
            LEFT JOIN users users_u ON cutouts.updated_by = users_u.user_id";
        $cutouts = $this->cutoutModel->readAll($override_query, "cutout_id");
        if ($logged_in_user['role_id'] > 1) {
            $cutouts = array_filter($cutouts, function ($cutout) {
                return !isset($cutout['deleted_at']);
            });
        }

        $images = $this->cutoutModel->DBRaw("SELECT * FROM cutout_images");

        foreach ($images as $image) {
            $id = $image['cutout_id'];
            $cutouts[$id]['images'][$image['image_id']] = $image;
        }

        $this->helper->respondToClient($cutouts);
    }

    public function updateImages($cutout_id)
    {
        $cutout = $this->cutoutModel->findById($cutout_id);
        $name = $cutout['name'];
        $primary_image_idx = trim($_POST['primary_image_idx']);
        $primary_image_type = trim($_POST['primary_image_type']);
        $new_cutout = [];
        $status = 200;
        $message = "Images updated successfully.";
        $public_directory = __DIR__ . '/../../public';
        $relative_directory = "/assets/images/gallery/cutouts/";

        if (!$cutout) {
            $status = 409;
            $message = "There is no cutout with this id.";
        }

        if ($status !== 200) {
            $this->helper->respondToClient(null, $status, $message);
        }

        if (isset($_POST['deletedImages'])) {
            try {
                foreach ($_POST['deletedImages'] as $image_id) {
                    $image = $this->cutoutImageModal->findById($image_id);
                    $delete_image_path = $public_directory . $image['image_url'];
                    if (!unlink($delete_image_path)) {
                        $status = 500;
                        throw new Exception("Failed to delete the old image.");
                    } else {
                        $this->cutoutImageModal->image_id = $image_id;
                        $this->cutoutImageModal->delete();
                    }
                }
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }

        if ($status !== 200) {
            $this->helper->respondToClient(null, $status, $message);
        }

        if (isset($_FILES['newImages'])) {
            try {
                foreach ($_FILES['newImages']['type'] as $index => $fileType) {
                    $this->cutoutImageModal->cutout_id = $cutout_id;
                    $image_id = $this->cutoutImageModal->create();
                    $extension = $this->helper->getFileExtension($fileType);

                    if (!strlen($extension)) {
                        $status = 415;
                        throw new Exception("The file type was not recognized. Please use jpeg, png, webp, avif, or tiff.");
                    } else if (!$this->helper->checkIfFileTypeIsAcceptable($fileType)) {
                        $status = 409;
                        throw new Exception("The file type is not acceptable. Please use jpeg, png, webp, avif, or tiff.");
                    }

                    if ($primary_image_type === "newImages" && (int)$index == (int)$primary_image_idx) {
                        $this->cutoutModel->cutout_id = $cutout_id;
                        $this->cutoutModel->primary_image_id = $image_id;
                        $this->cutoutModel->updatePrimaryImg();
                    }

                    $tmpName = $_FILES['newImages']['tmp_name'][$index];
                    $newFileName = sprintf("%s_%d_%d%s", $name, $cutout_id, $image_id, $extension);
                    $image_url = $relative_directory . $newFileName;
                    $destination = $public_directory . $image_url;

                    $this->cutoutImageModal->image_id = $image_id;
                    $this->cutoutImageModal->image_url = $image_url;
                    $this->cutoutImageModal->update();

                    // Move the uploaded file to the target directory
                    if (!move_uploaded_file($tmpName, $destination)) {
                        $status = 500;
                        $message = "cutout was created but the file upload failed.";
                    }
                }
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }

        if ($status !== 200) {
            $this->helper->respondToClient($new_cutout, $status, $message);
        }

        if ($primary_image_type === "existingImages") {
            $this->cutoutModel->cutout_id = $cutout_id;
            $this->cutoutModel->primary_image_id = $primary_image_idx;
            $this->cutoutModel->updatePrimaryImg();
        }

        $this->helper->respondToClient($cutout, $status, $message);
    }

    public function create()
    {
        $name = trim($_POST['name']);
        $new_cutout = [];
        $status = 200;
        $message = "";
        $file_data = [];
        $public_directory = __DIR__ . '/../../public';
        $relative_directory = "/assets/images/gallery/cutouts/";

        if (isset($_FILES['newImages'])) {
            foreach ($_FILES['newImages']['type'] as $index => $fileType) {
                $extension = $this->helper->getFileExtension($fileType);
                $file_data['extension'][$index] = $extension;

                if (!strlen($extension)) {
                    $status = 415;
                    $message = "The file type was not recognized. Please use jpeg, png, webp, avif, or tiff.";
                } else if (!$this->helper->checkIfFileTypeIsAcceptable($fileType)) {
                    $status = 409;
                    $message = "The file type is not acceptable. Please use jpeg, png, webp, avif, or tiff.";
                }
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
            "code" => $code,
            "description" => $description,
            "cutout_type" => $cutout_type,
            "primary_image_idx" => $primary_image_idx
        ] = $_POST;

        $this->cutoutModel->name = $name;
        $this->cutoutModel->code = $code;
        $this->cutoutModel->description = $description;
        $this->cutoutModel->cutout_type = $cutout_type;
        $this->cutoutModel->created_by = $_SESSION['user']['user_id'];

        if ($this->cutoutModel->create()) {
            $message = "Cutout created successfully.";
            $new_cutout = $this->cutoutModel->findByName($name);
            foreach ($_FILES['newImages']['tmp_name'] as $index => $tmpName) {
                $cutout_id = $new_cutout['cutout_id'];
                $this->cutoutImageModal->cutout_id = $cutout_id;
                $image_id = $this->cutoutImageModal->create();

                if ((int)$index == (int)$primary_image_idx) {
                    $this->cutoutModel->cutout_id = $cutout_id;
                    $this->cutoutModel->primary_image_id = $image_id;
                    $this->cutoutModel->updatePrimaryImg();
                }

                $extension = $file_data['extension'][$index];
                $newFileName = sprintf("%s_%d_%d%s", $name, $cutout_id, $image_id, $extension);
                $image_url = $relative_directory . $newFileName;
                $destination = $public_directory . $image_url;

                $this->cutoutImageModal->image_id = $image_id;
                $this->cutoutImageModal->image_url = $image_url;
                $this->cutoutImageModal->update();

                // Move the uploaded file to the target directory
                if (move_uploaded_file($tmpName, $destination)) {
                    $message = "File uploaded successfully.";
                } else {
                    $status = 500;
                    $message = "Cutout was created but the file upload failed.";
                }
            }
        } else {
            $status = 409;
            $message = "Error creating cutout.";
        }

        $this->helper->respondToClient($new_cutout, $status, $message);
    }

    public function update($cutout_id)
    {
        $inputData = file_get_contents('php://input');
        $data = json_decode($inputData, true);

        $name = trim($data['name']);
        $status = 200;
        $message = "";
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
                $message = "There is already a unique cutout with with the name: \"$name\".";
            }
        }

        if ($status !== 200) {
            $this->helper->respondToClient(null, $status, $message);
        }

        if ($name !== $cutout['name']) {
            /**
             * Means that we are updating the resource name
             * and so we must update the image urls
             */
            try {
                $images = $this->cutoutImageModal->findByCutoutId($cutout_id);
                $public_directory = __DIR__ . '/../../public';
                $relative_directory = "/assets/images/gallery/cutouts/";
                foreach ($images as $image) {
                    $fileInfo = pathinfo($image['image_url']);
                    $extension = $fileInfo['extension'];
                    $image_id = $image['image_id'];

                    $newFileName = sprintf("%s_%d_%d.%s", $name, $cutout_id, $image_id, $extension);
                    $uploadDirectory = $public_directory . $relative_directory;
                    $destination = $uploadDirectory . $newFileName;
                    $old_image_path = $public_directory . $image['image_url'];

                    if (file_exists($old_image_path)) {
                        if (rename($old_image_path, $destination)) {
                            $newImageUrl = $relative_directory . $newFileName;
                            $this->cutoutImageModal->cutout_id = $cutout_id;
                            $this->cutoutImageModal->image_url = $newImageUrl;
                            $this->cutoutImageModal->image_id = $image_id;
                            $this->cutoutImageModal->update();
                        } else {
                            $status = 500;
                            throw new Exception("Failed to rename the image.");
                        }
                    } else {
                        $this->helper->dd([$image, $old_image_path, $destination]);
                        $status = 500;
                        throw new Exception("File does not exist.");
                    }
                }
            } catch (Exception $e) {
                $status = 500;
                $message = $e->getMessage();
            }
        }

        if ($status !== 200) {
            $this->helper->respondToClient(null, $status, $message);
        }

        [
            "name" => $name,
            "code" => $code,
            "description" => $description,
            "cutout_type" => $cutout_type,
        ] = $data;

        $this->cutoutModel->cutout_id = $cutout_id;
        $this->cutoutModel->name = $name;
        $this->cutoutModel->code = $code;
        $this->cutoutModel->description = $description;
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

    public function restore($cutout_id)
    {
        $cutout_to_restore = null;
        $status = 200;
        $message = "";

        $this->cutoutModel->cutout_id = $cutout_id;

        if ($this->cutoutModel->restore()) {
            $message = "Cutout restored successfully.";
            $cutout_to_restore = $this->cutoutModel->findById($cutout_id);
        } else {
            $status = 500;
            $message = "Error deleting cutout.";
        }

        $this->helper->respondToClient($cutout_to_restore, $status, $message);
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
