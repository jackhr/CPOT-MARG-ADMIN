<?php

namespace App\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\UniqueCeramic;
use Exception;

class UniqueCeramicController extends Controller
{
    private $ceramicModel;
    private $helper;

    public function __construct(GeneralHelper $helper)
    {
        $this->ceramicModel = new UniqueCeramic();
        $this->helper = $helper;
    }

    public function listCeramics()
    {
        $logged_in_user = $_SESSION['user'];
        $override_query = "SELECT unique_ceramics.*, users_c.email AS created_by_email, users_u.email AS updated_by_email 
            FROM unique_ceramics
            LEFT JOIN users users_c ON unique_ceramics.created_by = users_c.user_id
            LEFT JOIN users users_u ON unique_ceramics.updated_by = users_u.user_id";
        $ceramics = $this->ceramicModel->readAll($override_query);
        if ($logged_in_user['role_id'] > 1) {
            $ceramics = array_filter($ceramics, function ($ceramic) {
                return !isset($ceramic['deleted_at']);
            });
        }
        $this->view("admin/ceramics/list.php", [
            "user" => $logged_in_user,
            "ceramics" => $ceramics,
            "title" => "ceramics"
        ]);
    }

    public function create()
    {
        $name = $_POST['name'];
        $uploadedFile = null;
        $new_ceramic = [];
        $status = 200;
        $message = "";

        if (isset($_FILES['ceramic-img'])) {
            $uploadedFile = $_FILES['ceramic-img'];
            $fileType = $uploadedFile['type'];
            $extension = $this->helper->getFileExtension($fileType);

            $public_directory = "/assets/images/ceramics/";
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

        if ($this->ceramicModel->findByName($name)) {
            $status = 409;
            $message = "There is already a ceramic with that name.";
        }

        if ($status !== 200) {
            $this->helper->respondToClient($new_ceramic, $status, $message);
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
            "status" => $ceramic_status,
            "description" => $description,
        ] = $_POST;

        $dimensions = "$width{$dim_units} x $height{$dim_units} x $breadth{$dim_units}";
        $weight = "$weight{$weight_units}";

        $this->ceramicModel->name = $name;
        $this->ceramicModel->dimensions = $dimensions;
        $this->ceramicModel->material = $material;
        $this->ceramicModel->color = $color;
        $this->ceramicModel->weight = $weight;
        $this->ceramicModel->price = $base_price;
        $this->ceramicModel->stock_quantity = $stock_quantity;
        $this->ceramicModel->status = $ceramic_status;
        $this->ceramicModel->description = $description;
        $this->ceramicModel->image_url = $image_url;
        $this->ceramicModel->created_by = $_SESSION['user']['user_id'];

        if ($this->ceramicModel->create()) {
            $message = "Unique ceramic created successfully.";
            $new_ceramic = $this->ceramicModel->findByName($name);
            $tmpName = $uploadedFile['tmp_name'];

            $uploadDirectory = __DIR__ . '/../../public' . $public_directory;
            $destination = $uploadDirectory . $newFileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($tmpName, $destination)) {
                $message = "File uploaded successfully.";
            } else {
                $status = 500;
                $message = "Unique ceramic was created but the file upload failed.";
            }
        } else {
            $status = 409;
            $message = "Error creating unique ceramic.";
        }

        $this->helper->respondToClient($new_ceramic, $status, $message);
    }

    public function update($ceramic_id)
    {
        $name = $_POST['name'];
        $uploadedFile = null;
        $new_ceramic = [];
        $status = 200;
        $message = "";
        $changing_image = isset($_FILES['ceramic-img']);

        $ceramic = $this->ceramicModel->findById($ceramic_id);
        $ceramic_with_same_name = $this->ceramicModel->findByName($name);

        // Check if the ceramic with the given ID exists
        if (!$ceramic) {
            $status = 409;
            $message = "There is no unique ceramic with this id.";
        } else if ($ceramic_with_same_name !== false) {
            if (
                ($ceramic_with_same_name['ceramic_id'] !== $ceramic['ceramic_id']) &&
                ($ceramic_with_same_name['name'] === $name)
            ) {
                $status = 409;
                $message = "There is already a unique ceramic with that name.";
            }
        }

        try {
            if ($changing_image) {
                $uploadedFile = $_FILES['ceramic-img'];
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
                $relative_directory = "/assets/images/ceramics/";
                $newFileName = $name . $extension;
                $new_image_url = $relative_directory . $newFileName;
                $uploadDirectory = $public_directory . $relative_directory;
                $destination = $uploadDirectory . $newFileName;

                $tmpName = $uploadedFile['tmp_name'];
                $old_image_path = $public_directory . $ceramic['image_url'];

                // Handle existing file replacement or renaming
                if (file_exists($old_image_path)) {
                    if ($ceramic['name'] === $name) {
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
            } else if ($ceramic['name'] !== $name) {
                // not changing image, but changing name
                $fileInfo = pathinfo($ceramic['image_url']);
                $extension = $fileInfo['extension'];

                $public_directory = __DIR__ . '/../../public';
                $relative_directory = "/assets/images/ceramics/";
                $newFileName = "$name.$extension";
                $new_image_url = $relative_directory . $newFileName;
                $uploadDirectory = $public_directory . $relative_directory;
                $destination = $uploadDirectory . $newFileName;

                $old_image_path = $public_directory . $ceramic['image_url'];

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
            $this->helper->respondToClient($new_ceramic, $status, $message);
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
            "status" => $ceramic_status,
            "description" => $description,
        ] = $_POST;

        $dimensions = "$width{$dim_units} x $height{$dim_units} x $breadth{$dim_units}";
        $weight = "$weight{$weight_units}";

        $this->ceramicModel->ceramic_id = $ceramic_id;
        $this->ceramicModel->name = $name;
        $this->ceramicModel->dimensions = $dimensions;
        $this->ceramicModel->material = $material;
        $this->ceramicModel->color = $color;
        $this->ceramicModel->weight = $weight;
        $this->ceramicModel->price = $base_price;
        $this->ceramicModel->stock_quantity = $stock_quantity;
        $this->ceramicModel->status = $ceramic_status;
        $this->ceramicModel->description = $description;
        $this->ceramicModel->image_url = isset($new_image_url) ? $new_image_url : $ceramic['image_url'];
        $this->ceramicModel->updated_by = $_SESSION['user']['user_id'];

        if ($this->ceramicModel->update()) {
            $message = "Unique ceramic updated successfully.";
            $updated_ceramic = $this->ceramicModel->findByName($name);
        } else {
            $status = 409;
            $message = "Error updating unique ceramic.";
        }

        $this->helper->respondToClient($updated_ceramic, $status, $message);
    }

    public function delete($ceramic_id)
    {
        $ceramic_to_delete = $this->ceramicModel->findById($ceramic_id);
        $status = 200;
        $message = "";

        $this->ceramicModel->ceramic_id = $ceramic_id;

        if ($this->ceramicModel->delete()) {
            $message = "Unique ceramic deleted successfully.";
            $ceramic_to_delete = $this->ceramicModel->findById($ceramic_id);
        } else {
            $status = 500;
            $message = "Error deleting unique ceramic.";
        }

        $this->helper->respondToClient($ceramic_to_delete, $status, $message);
    }
}
