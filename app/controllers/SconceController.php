<?php

namespace App\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Sconce;
use Exception;

class SconceController extends Controller
{
    private $sconceModel;
    private $helper;

    public function __construct(GeneralHelper $helper)
    {
        $this->sconceModel = new Sconce();
        $this->helper = $helper;
    }

    public function listSconces()
    {
        $logged_in_user = $_SESSION['user'];
        $override_query = "SELECT sconces.*, users_c.email AS created_by_email, users_u.email AS updated_by_email 
            FROM sconces
            LEFT JOIN users users_c ON sconces.created_by = users_c.user_id
            LEFT JOIN users users_u ON sconces.updated_by = users_u.user_id";
        $sconces = $this->sconceModel->readAll($override_query);
        if ($logged_in_user['role_id'] > 1) {
            $sconces = array_filter($sconces, function ($sconce) {
                return !isset($sconce['deleted_at']);
            });
        }
        $this->view("admin/sconces/list.php", [
            "user" => $logged_in_user,
            "sconces" => $sconces,
            "title" => "Sconces"
        ]);
    }

    public function create()
    {
        $name = $_POST['name'];
        $uploadedFile = null;
        $new_sconce = [];
        $status = 200;
        $message = "";

        if (isset($_FILES['sconce-img'])) {
            $uploadedFile = $_FILES['sconce-img'];
            $fileType = $uploadedFile['type'];
            $extension = $this->helper->getFileExtension($fileType);

            $public_directory = "/assets/images/sconces/";
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

        if ($this->sconceModel->findByName($name)) {
            $status = 409;
            $message = "There is already a sconce with that name.";
        }

        if ($status !== 200) {
            $this->helper->respondToClient($new_sconce, $status, $message);
        }

        [
            "dimension-units" => $dim_units,
            "width" => $width,
            "height" => $height,
            "breadth" => $breadth,
            "material" => $material,
            "color" => $color,
            "weight" => $weight,
            "weight-units" => $weight_units,
            "base_price" => $base_price,
            "stock_quantity" => $stock_quantity,
            "status" => $sconce_status,
            "description" => $description,
        ] = $_POST;

        $dimensions = "$width{$dim_units} x $height{$dim_units} x $breadth{$dim_units}";
        $weight = "$weight{$weight_units}";

        $this->sconceModel->name = $name;
        $this->sconceModel->dimensions = $dimensions;
        $this->sconceModel->material = $material;
        $this->sconceModel->color = $color;
        $this->sconceModel->weight = $weight;
        $this->sconceModel->base_price = $base_price;
        $this->sconceModel->stock_quantity = $stock_quantity;
        $this->sconceModel->status = $sconce_status;
        $this->sconceModel->description = $description;
        $this->sconceModel->image_url = $image_url;
        $this->sconceModel->created_by = $_SESSION['user']['user_id'];

        if ($this->sconceModel->create()) {
            $message = "sconce created successfully.";
            $new_sconce = $this->sconceModel->findByName($name);
            $tmpName = $uploadedFile['tmp_name'];

            $uploadDirectory = __DIR__ . '/../../public' . $public_directory;
            $destination = $uploadDirectory . $newFileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($tmpName, $destination)) {
                $message = "File uploaded successfully.";
            } else {
                $status = 500;
                $message = "Sconce was created but the file upload failed.";
            }
        } else {
            $status = 409;
            $message = "Error creating sconce.";
        }

        $this->helper->respondToClient($new_sconce, $status, $message);
    }

    public function update($sconce_id)
    {
        $name = $_POST['name'];
        $uploadedFile = null;
        $new_sconce = [];
        $status = 200;
        $message = "";
        $changing_image = isset($_FILES['sconce-img']);

        $sconce = $this->sconceModel->findById($sconce_id);
        $sconce_with_same_name = $this->sconceModel->findByName($name);

        // Check if the sconce with the given ID exists
        if (!$sconce) {
            $status = 409;
            $message = "There is no sconce with this id.";
        } else if (
            ($sconce_with_same_name !== false) &&
            ($sconce_with_same_name['sconce_id'] !== $sconce['sconce_id']) &&
            ($sconce_with_same_name['name'] === $name)
        ) {
            $status = 409;
            $message = "There is already a sconce with that name.";
        }

        if ($changing_image) {
            $uploadedFile = $_FILES['sconce-img'];
            $fileType = $uploadedFile['type'];
            $extension = $this->helper->getFileExtension($fileType);

            if (!strlen($extension)) {
                $status = 415;
                $message = "The file type was not recognized. Please use jpeg, png, webp, avif, or tiff.";
            } else if (!$this->helper->checkIfFileTypeIsAcceptable($fileType)) {
                $status = 409;
                $message = "The file type is not acceptable. Please use jpeg, png, webp, avif, or tiff.";
            }

            // Prepare file paths
            $public_directory = __DIR__ . '/../../public';
            $relative_directory = "/assets/images/sconces/";
            $newFileName = $name . $extension;
            $new_image_url = $relative_directory . $newFileName;
            $uploadDirectory = $public_directory . $relative_directory;
            $destination = $uploadDirectory . $newFileName;

            $tmpName = $uploadedFile['tmp_name'];
            $old_image_path = $public_directory . $sconce['image_url'];

            // Handle existing file replacement or renaming
            try {
                if (file_exists($old_image_path)) {
                    if ($sconce['name'] === $name) {
                        // If the name hasn't changed, just overwrite the old image
                        if (!move_uploaded_file($tmpName, $old_image_path)) {
                            throw new Exception("Failed to overwrite the existing image.");
                        }
                    } else {
                        // If the name has changed, delete the old image
                        if (!unlink($old_image_path)) {
                            throw new Exception("Failed to delete the old image.");
                        }

                        // Upload the new image to the new file path
                        if (!move_uploaded_file($tmpName, $destination)) {
                            throw new Exception("Failed to upload the new image.");
                        }
                    }
                } else {
                    // If the old image doesn't exist, just upload the new one
                    if (!move_uploaded_file($tmpName, $destination)) {
                        throw new Exception("Failed to upload the new image.");
                    }
                }
            } catch (Exception $e) {
                $status = 500;
                $message = $e->getMessage();
            }
        } else if ($sconce['name'] !== $name) {
            // not changing image, but changing name
            $fileInfo = pathinfo($sconce['image_url']);
            $extension = $fileInfo['extension'];

            $public_directory = __DIR__ . '/../../public';
            $relative_directory = "/assets/images/sconces/";
            $newFileName = "$name.$extension";
            $new_image_url = $relative_directory . $newFileName;
            $uploadDirectory = $public_directory . $relative_directory;
            $destination = $uploadDirectory . $newFileName;

            $old_image_path = $public_directory . $sconce['image_url'];

            try {
                if (file_exists($old_image_path)) {
                    if (!rename($old_image_path, $destination)) {
                        throw new Exception("Failed to rename the image.");
                    }
                } else {
                    throw new Exception("File does not exist.");
                }
            } catch (Exception $e) {
                $status = 500;
                $message = $e->getMessage();
            }
        }

        if ($status !== 200) {
            $this->helper->respondToClient($new_sconce, $status, $message);
        }

        [
            "dimension-units" => $dim_units,
            "width" => $width,
            "height" => $height,
            "breadth" => $breadth,
            "material" => $material,
            "color" => $color,
            "weight" => $weight,
            "weight-units" => $weight_units,
            "base_price" => $base_price,
            "stock_quantity" => $stock_quantity,
            "status" => $sconce_status,
            "description" => $description,
        ] = $_POST;

        $dimensions = "$width{$dim_units} x $height{$dim_units} x $breadth{$dim_units}";
        $weight = "$weight{$weight_units}";

        $this->sconceModel->sconce_id = $sconce_id;
        $this->sconceModel->name = $name;
        $this->sconceModel->dimensions = $dimensions;
        $this->sconceModel->material = $material;
        $this->sconceModel->color = $color;
        $this->sconceModel->weight = $weight;
        $this->sconceModel->base_price = $base_price;
        $this->sconceModel->stock_quantity = $stock_quantity;
        $this->sconceModel->status = $sconce_status;
        $this->sconceModel->description = $description;
        $this->sconceModel->image_url = isset($new_image_url) ? $new_image_url : $sconce['image_url'];
        $this->sconceModel->updated_by = $_SESSION['user']['user_id'];

        if ($this->sconceModel->update()) {
            $message = "sconce updated successfully.";
            $updated_sconce = $this->sconceModel->findByName($name);
        } else {
            $status = 409;
            $message = "Error updating sconce.";
        }

        $this->helper->respondToClient($updated_sconce, $status, $message);
    }

    public function delete($sconce_id)
    {
        $sconce_to_delete = $this->sconceModel->findById($sconce_id);
        $status = 200;
        $message = "";

        $this->sconceModel->sconce_id = $sconce_id;

        if ($this->sconceModel->delete()) {
            $message = "Sconce deleted successfully.";
            $sconce_to_delete = $this->sconceModel->findById($sconce_id);
        } else {
            $status = 500;
            $message = "Error deleting sconce.";
        }

        $this->helper->respondToClient($sconce_to_delete, $status, $message);
    }
}
