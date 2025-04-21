<?php

namespace App\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Sconce;
use App\Models\SconceImage;
use Exception;

class SconceController extends Controller
{
    private $sconceModel;
    private $sconceImageModel;
    private $helper;

    public function __construct(GeneralHelper $helper)
    {
        $this->sconceModel = new Sconce();
        $this->sconceImageModel = new SconceImage();
        $this->helper = $helper;
    }

    public function listSconces()
    {
        $logged_in_user = $_SESSION['user'];
        $this->view("admin/sconces/list.php", [
            "user" => $logged_in_user,
            "title" => "Sconces"
        ]);
    }

    public function getAll()
    {
        $override_query = "SELECT sconces.*, sconce_images.image_url, users_c.email AS created_by_email, users_u.email AS updated_by_email 
            FROM sconces
            LEFT JOIN sconce_images ON sconces.primary_image_id = sconce_images.image_id
            LEFT JOIN users users_c ON sconces.created_by = users_c.user_id
            LEFT JOIN users users_u ON sconces.updated_by = users_u.user_id";
        $sconces = $this->sconceModel->readAll($override_query, "sconce_id");
        if (isset($_GET['only_active'])) {
            $sconces = array_filter($sconces, function ($sconces) {
                return !isset($sconces['deleted_at']);
            });
        }

        $sconce_images = $this->sconceImageModel->DBRaw("SELECT * FROM sconce_images");

        foreach ($sconce_images as $sconce_image) {
            $sconce_id = $sconce_image['sconce_id'];
            if (isset($sconces[$sconce_id])) {
                $sconces[$sconce_id]['images'][$sconce_image['image_id']] = $sconce_image;
            }
        }

        // Fetch related cutout IDs only if requested
        if (isset($_GET['include_cutout_relations']) && $_GET['include_cutout_relations'] === "true") {
            $cutoutRelations = $this->sconceModel->DBRaw("SELECT cutout_id, sconce_id FROM rel_sconces_cutouts");

            // Initialize each sconce with an empty array of cutouts
            foreach ($sconces as &$sconce) $sconce['cutout_ids'] = [];

            // Map cutout IDs to their respective sconces
            foreach ($cutoutRelations as $relation) {
                $sconces[$relation['sconce_id']]['cutout_ids'][] = $relation['cutout_id'];
            }
        }

        $this->helper->respondToClient($sconces);
    }

    public function updateImages($sconce_id)
    {
        $sconce = $this->sconceModel->findById($sconce_id);
        $name = $sconce['name'];
        $primary_image_idx = trim($_POST['primary_image_idx']);
        $primary_image_type = trim($_POST['primary_image_type']);
        $new_sconce = [];
        $status = 200;
        $message = "Images updated successfully.";
        $public_directory = __DIR__ . '/../../public';
        $relative_directory = "/assets/images/gallery/sconces/";

        if (!$sconce) {
            $status = 409;
            $message = "There is no sconce with this id.";
        }

        if ($status !== 200) {
            $this->helper->respondToClient(null, $status, $message);
        }

        if (isset($_POST['deletedImages'])) {
            try {
                foreach ($_POST['deletedImages'] as $image_id) {
                    $image = $this->sconceImageModel->findById($image_id);
                    $delete_image_path = $public_directory . $image['image_url'];
                    if (unlink($delete_image_path)) {
                        $this->sconceImageModel->destroy($image_id);
                    } else {
                        $status = 500;
                        throw new Exception("Failed to delete the old image.");
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
                    $this->sconceImageModel->sconce_id = $sconce_id;
                    $image_id = $this->sconceImageModel->create();
                    $extension = $this->helper->getFileExtension($fileType);

                    if (!strlen($extension)) {
                        $status = 415;
                        throw new Exception("The file type was not recognized. Please use jpeg, png, webp, avif, or tiff.");
                    } else if (!$this->helper->checkIfFileTypeIsAcceptable($fileType)) {
                        $status = 409;
                        throw new Exception("The file type is not acceptable. Please use jpeg, png, webp, avif, or tiff.");
                    }

                    if ($primary_image_type === "newImages" && (int)$index == (int)$primary_image_idx) {
                        $this->sconceModel->sconce_id = $sconce_id;
                        $this->sconceModel->primary_image_id = $image_id;
                        $this->sconceModel->updatePrimaryImg();
                    }

                    $tmpName = $_FILES['newImages']['tmp_name'][$index];
                    $newFileName = sprintf("%s_%d_%d%s", $name, $sconce_id, $image_id, $extension);
                    $image_url = $relative_directory . $newFileName;
                    $destination = $public_directory . $image_url;

                    $this->sconceImageModel->image_id = $image_id;
                    $this->sconceImageModel->image_url = $image_url;
                    $this->sconceImageModel->update();

                    // Move the uploaded file to the target directory
                    if (!move_uploaded_file($tmpName, $destination)) {
                        $status = 500;
                        $message = "Sconce was created but the file upload failed.";
                    }
                }
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }

        if ($status !== 200) {
            $this->helper->respondToClient($new_sconce, $status, $message);
        }

        if ($primary_image_type === "existingImages") {
            $this->sconceModel->sconce_id = $sconce_id;
            $this->sconceModel->primary_image_id = $primary_image_idx;
            $this->sconceModel->updatePrimaryImg();
        }

        $this->helper->respondToClient($sconce, $status, $message);
    }

    public function create()
    {
        $name = trim($_POST['name']);
        $new_sconce = [];
        $status = 200;
        $message = "";
        $file_data = [];
        $public_directory = __DIR__ . '/../../public';
        $relative_directory = "/assets/images/gallery/sconces/";

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

        if ($this->sconceModel->findByName($name)) {
            $status = 409;
            $message = "There is already a sconce with that name.";
        }

        if ($status !== 200) {
            $this->helper->respondToClient($new_sconce, $status, $message);
        }

        [
            // "dimension-units" => $dim_units,
            "width" => $width,
            "height" => $height,
            "depth" => $depth,
            "material" => $material,
            "color" => $color,
            "base_price" => $base_price,
            "status" => $sconce_status,
            "description" => $description,
            "primary_image_idx" => $primary_image_idx,
        ] = $_POST;

        $depth = $this->helper->truncateToThreeDecimals($depth);
        $width = $this->helper->truncateToThreeDecimals($width);
        $height = $this->helper->truncateToThreeDecimals($height);

        $dim_units = "in"; // defaulting to inches for the time being
        $dimensions = "$depth{$dim_units} x $width{$dim_units} x $height{$dim_units}";

        $this->sconceModel->name = $name;
        $this->sconceModel->dimensions = $dimensions;
        $this->sconceModel->material = $material;
        $this->sconceModel->color = $color;
        $this->sconceModel->base_price = $this->helper->truncateToThreeDecimals($base_price);
        $this->sconceModel->status = $sconce_status;
        $this->sconceModel->description = $description;
        $this->sconceModel->created_by = $_SESSION['user']['user_id'];

        if ($this->sconceModel->create()) {
            $message = "Sconce created successfully.";
            $new_sconce = $this->sconceModel->findByName($name);

            foreach ($_FILES['newImages']['tmp_name'] as $index => $tmpName) {
                $sconce_id = $new_sconce['sconce_id'];
                $this->sconceImageModel->sconce_id = $sconce_id;
                $image_id = $this->sconceImageModel->create();

                if ((int)$index == (int)$primary_image_idx) {
                    $this->sconceModel->sconce_id = $sconce_id;
                    $this->sconceModel->primary_image_id = $image_id;
                    $this->sconceModel->updatePrimaryImg();
                }

                $extension = $file_data['extension'][$index];
                $newFileName = sprintf("%s_%d_%d%s", $name, $sconce_id, $image_id, $extension);
                $image_url = $relative_directory . $newFileName;
                $destination = $public_directory . $image_url;

                $this->sconceImageModel->image_id = $image_id;
                $this->sconceImageModel->image_url = $image_url;
                $this->sconceImageModel->update();

                // Move the uploaded file to the target directory
                if (move_uploaded_file($tmpName, $destination)) {
                    $message = "File uploaded successfully.";
                } else {
                    $status = 500;
                    $message = "Sconce was created but the file upload failed.";
                }
            }
        } else {
            $status = 409;
            $message = "Error creating sconce.";
        }

        // Loop through the array and extract only the cutout_ids
        $filtered_cutout_ids = array_filter($_POST["cutout_ids"], function ($x) {
            return $x;
        });

        $this->sconceImageModel->sconce_id = $new_sconce['sconce_id'];
        $this->sconceModel->updateCutouts(array_keys($filtered_cutout_ids));

        $this->helper->respondToClient($new_sconce, $status, $message);
    }

    public function update($sconce_id)
    {
        $inputData = file_get_contents('php://input');
        $data = json_decode($inputData, true);

        $name = trim($data['name']);
        $status = 200;
        $message = "";
        $sconce = $this->sconceModel->findById($sconce_id);
        $sconce_with_same_name = $this->sconceModel->findByName($name);

        // Check if the sconce with the given ID exists
        if (!$sconce) {
            $status = 409;
            $message = "There is no sconce with this id.";
        } else if ($sconce_with_same_name !== false) {
            if (
                ($sconce_with_same_name['sconce_id'] !== $sconce['sconce_id']) &&
                ($sconce_with_same_name['name'] === $name)
            ) {
                $status = 409;
                $message = "There is already a sconce with the name: \"$name\"";
            }
        }

        if ($status !== 200) {
            $this->helper->respondToClient(null, $status, $message);
        }

        if ($name !== $sconce['name']) {
            /**
             * Means that we are updating the resource name
             * and so we must update the image urls
             */
            try {
                $images = $this->sconceImageModel->findBysconceId($sconce_id);
                $public_directory = __DIR__ . '/../../public';
                $relative_directory = "/assets/images/gallery/sconces/";
                foreach ($images as $image) {
                    $fileInfo = pathinfo($image['image_url']);
                    $extension = $fileInfo['extension'];
                    $image_id = $image['image_id'];

                    $newFileName = sprintf("%s_%d_%d.%s", $name, $sconce_id, $image_id, $extension);
                    $uploadDirectory = $public_directory . $relative_directory;
                    $destination = $uploadDirectory . $newFileName;
                    $old_image_path = $public_directory . $image['image_url'];

                    if (file_exists($old_image_path)) {
                        if (rename($old_image_path, $destination)) {
                            $newImageUrl = $relative_directory . $newFileName;
                            $this->sconceImageModel->sconce_id = $sconce_id;
                            $this->sconceImageModel->image_url = $newImageUrl;
                            $this->sconceImageModel->image_id = $image_id;
                            $this->sconceImageModel->update();
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
            // "dimension-units" => $dim_units,
            "width" => $width,
            "height" => $height,
            "depth" => $depth,
            "material" => $material,
            "color" => $color,
            "weight" => $weight,
            "weight-units" => $weight_units,
            "base_price" => $base_price,
            "status" => $sconce_status,
            "description" => $description,
        ] = $data;

        $depth = $this->helper->truncateToThreeDecimals($depth);
        $width = $this->helper->truncateToThreeDecimals($width);
        $height = $this->helper->truncateToThreeDecimals($height);
        $weight = $this->helper->truncateToThreeDecimals($weight);

        $dim_units = "in"; // defaulting to inches for the time being
        $dimensions = "$depth{$dim_units} x $width{$dim_units} x $height{$dim_units}";
        $weight = "$weight{$weight_units}";

        $this->sconceModel->sconce_id = $sconce_id;
        $this->sconceModel->name = $name;
        $this->sconceModel->dimensions = $dimensions;
        $this->sconceModel->material = $material;
        $this->sconceModel->color = $color;
        $this->sconceModel->weight = $weight;
        $this->sconceModel->base_price = $this->helper->truncateToThreeDecimals($base_price);
        $this->sconceModel->status = $sconce_status;
        $this->sconceModel->description = $description;
        $this->sconceModel->updated_by = $_SESSION['user']['user_id'];

        if ($this->sconceModel->update()) {
            $message = "sconce updated successfully.";
            $updated_sconce = $this->sconceModel->findByName($name);
        } else {
            $status = 409;
            $message = "Error updating sconce.";
        }

        $cutout_ids_arr = [];

        // Loop through the array and extract only the cutout_ids
        foreach ($data as $key => $value) {
            if (preg_match('/cutout_ids\[(\d+)\]/', $key, $matches)) {
                $cutout_ids_arr[$matches[1]] = $value;
            }
        }

        $filtered_cutout_ids = array_filter($cutout_ids_arr, function ($x) {
            return $x;
        });

        $this->sconceModel->updateCutouts(array_keys($filtered_cutout_ids));

        $this->helper->respondToClient($updated_sconce, $status, $message);
    }

    public function restore($sconce_id)
    {
        $sconce_to_restore = null;
        $status = 200;
        $message = "";

        $this->sconceModel->sconce_id = $sconce_id;

        if ($this->sconceModel->restore()) {
            $message = "Sconce restored successfully.";
            $sconce_to_restore = $this->sconceModel->findById($sconce_id);
        } else {
            $status = 500;
            $message = "Error restoring sconce.";
        }

        $this->helper->respondToClient($sconce_to_restore, $status, $message);
    }

    public function delete($sconce_id)
    {
        $sconce_to_delete = $this->sconceModel->findById($sconce_id);
        $sconce_images = $this->sconceImageModel->findBySconceId($sconce_id);
        $status = 200;
        $message = "";
        $public_directory = __DIR__ . '/../../public';

        // first, delete the images, and the rows
        foreach ($sconce_images as $image) {
            $delete_image_path = $public_directory . $image['image_url'];
            if (unlink($delete_image_path)) {
                $this->sconceImageModel->destroy($image['image_id']);
            } else {
                $status = 500;
                throw new Exception("Failed to delete the old image.");
            }
        }

        if ($this->sconceModel->destroy($sconce_id)) {
            $message = "Sconce deleted successfully.";
        } else {
            $status = 500;
            $message = "Error deleting sconce.";
        }

        $this->helper->respondToClient($sconce_to_delete, $status, $message);
    }
}
