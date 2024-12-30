<?php

namespace App\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\OneOfAKind;
use App\Models\OneOfAKindImage;
use Exception;

class OneOfAKindController extends Controller
{
    private $oneOfAKindModel;
    private $oneOfAKindImageModel;
    private $helper;

    public function __construct(GeneralHelper $helper)
    {
        $this->oneOfAKindModel = new OneOfAKind();
        $this->oneOfAKindImageModel = new OneOfAKindImage();
        $this->helper = $helper;
    }

    public function listOneOfAKinds()
    {
        $logged_in_user = $_SESSION['user'];
        $this->view("admin/one-of-a-kind/list.php", [
            "user" => $logged_in_user,
            "title" => "One of a Kind"
        ]);
    }

    public function getAll()
    {
        $logged_in_user = $_SESSION['user'];
        $override_query = "SELECT one_of_a_kind.*, one_of_a_kind_images.image_url, users_c.email AS created_by_email, users_u.email AS updated_by_email 
            FROM one_of_a_kind
            LEFT JOIN one_of_a_kind_images ON one_of_a_kind.primary_image_id = one_of_a_kind_images.image_id
            LEFT JOIN users users_c ON one_of_a_kind.created_by = users_c.user_id
            LEFT JOIN users users_u ON one_of_a_kind.updated_by = users_u.user_id";
        $one_of_a_kinds = $this->oneOfAKindModel->readAll($override_query, "one_of_a_kind_id");
        if ($logged_in_user['role_id'] > 1) {
            $one_of_a_kinds = array_filter($one_of_a_kinds, function ($one_of_a_kind) {
                return !isset($one_of_a_kind['deleted_at']);
            });
        }

        $oak_images = $this->oneOfAKindModel->DBRaw("SELECT * FROM one_of_a_kind_images");

        foreach ($oak_images as $oak_image) {
            $oak_id = $oak_image['one_of_a_kind_id'];
            $one_of_a_kinds[$oak_id]['images'][$oak_image['image_id']] = $oak_image;
        }

        $this->helper->respondToClient($one_of_a_kinds);
    }

    public function updateImages($one_of_a_kind_id)
    {
        $one_of_a_kind = $this->oneOfAKindModel->findById($one_of_a_kind_id);
        $name = $one_of_a_kind['name'];
        $primary_image_idx = trim($_POST['primary_image_idx']);
        $primary_image_type = trim($_POST['primary_image_type']);
        $new_one_of_a_kind = [];
        $status = 200;
        $message = "Images updated successfully.";
        $public_directory = __DIR__ . '/../../public';
        $relative_directory = "/assets/images/gallery/one-of-a-kind/";

        if (!$one_of_a_kind) {
            $status = 409;
            $message = "There is no one of a kind with this id.";
        }

        if ($status !== 200) {
            $this->helper->respondToClient(null, $status, $message);
        }

        if (isset($_POST['deletedImages'])) {
            try {
                foreach ($_POST['deletedImages'] as $image_id) {
                    $image = $this->oneOfAKindImageModel->findById($image_id);
                    $delete_image_path = $public_directory . $image['image_url'];
                    if (!unlink($delete_image_path)) {
                        $status = 500;
                        throw new Exception("Failed to delete the old image.");
                    } else {
                        $this->oneOfAKindImageModel->image_id = $image_id;
                        $this->oneOfAKindImageModel->delete();
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
                    $this->oneOfAKindImageModel->one_of_a_kind_id = $one_of_a_kind_id;
                    $image_id = $this->oneOfAKindImageModel->create();
                    $extension = $this->helper->getFileExtension($fileType);

                    if (!strlen($extension)) {
                        $status = 415;
                        throw new Exception("The file type was not recognized. Please use jpeg, png, webp, avif, or tiff.");
                    } else if (!$this->helper->checkIfFileTypeIsAcceptable($fileType)) {
                        $status = 409;
                        throw new Exception("The file type is not acceptable. Please use jpeg, png, webp, avif, or tiff.");
                    }

                    if ($primary_image_type === "newImages" && (int)$index == (int)$primary_image_idx) {
                        $this->oneOfAKindModel->one_of_a_kind_id = $one_of_a_kind_id;
                        $this->oneOfAKindModel->primary_image_id = $image_id;
                        $this->oneOfAKindModel->updatePrimaryImg();
                    }

                    $tmpName = $_FILES['newImages']['tmp_name'][$index];
                    $newFileName = sprintf("%s_%d_%d%s", $name, $one_of_a_kind_id, $image_id, $extension);
                    $image_url = $relative_directory . $newFileName;
                    $destination = $public_directory . $image_url;

                    $this->oneOfAKindImageModel->image_id = $image_id;
                    $this->oneOfAKindImageModel->image_url = $image_url;
                    $this->oneOfAKindImageModel->update();

                    // Move the uploaded file to the target directory
                    if (!move_uploaded_file($tmpName, $destination)) {
                        $status = 500;
                        $message = "One of a kind was created but the file upload failed.";
                    }
                }
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }

        if ($status !== 200) {
            $this->helper->respondToClient($new_one_of_a_kind, $status, $message);
        }

        if ($primary_image_type === "existingImages") {
            $this->oneOfAKindModel->one_of_a_kind_id = $one_of_a_kind_id;
            $this->oneOfAKindModel->primary_image_id = $primary_image_idx;
            $this->oneOfAKindModel->updatePrimaryImg();
        }

        $this->helper->respondToClient($one_of_a_kind, $status, $message);
    }

    public function create()
    {
        $name = trim($_POST['name']);
        $new_one_of_a_kind = [];
        $status = 200;
        $message = "";
        $file_data = [];
        $public_directory = __DIR__ . '/../../public';
        $relative_directory = "/assets/images/gallery/one-of-a-kind/";

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

        if ($this->oneOfAKindModel->findByName($name)) {
            $status = 409;
            $message = "There is already a one of a kind with that name.";
        }

        if ($status !== 200) {
            $this->helper->respondToClient($new_one_of_a_kind, $status, $message);
        }

        [
            "dimension-units" => $dim_units,
            "width" => $width,
            "height" => $height,
            "depth" => $depth,
            "material" => $material,
            "color" => $color,
            "weight" => $weight,
            "weight-units" => $weight_units,
            "base_price" => $base_price,
            "stock_quantity" => $stock_quantity,
            "status" => $one_of_a_kind_status,
            "description" => $description,
            "primary_image_idx" => $primary_image_idx,
        ] = $_POST;

        $width = $this->helper->truncateToThreeDecimals($width);
        $height = $this->helper->truncateToThreeDecimals($height);
        $depth = $this->helper->truncateToThreeDecimals($depth);
        $weight = $this->helper->truncateToThreeDecimals($weight);

        $dimensions = "$width{$dim_units} x $height{$dim_units} x $depth{$dim_units}";
        $weight = "$weight{$weight_units}";

        $this->oneOfAKindModel->name = $name;
        $this->oneOfAKindModel->dimensions = $dimensions;
        $this->oneOfAKindModel->material = $material;
        $this->oneOfAKindModel->color = $color;
        $this->oneOfAKindModel->weight = $weight;
        $this->oneOfAKindModel->price = $this->helper->truncateToThreeDecimals($base_price);
        $this->oneOfAKindModel->stock_quantity = $this->helper->truncateToThreeDecimals($stock_quantity);
        $this->oneOfAKindModel->status = $one_of_a_kind_status;
        $this->oneOfAKindModel->description = $description;
        $this->oneOfAKindModel->created_by = $_SESSION['user']['user_id'];

        if ($this->oneOfAKindModel->create()) {
            $message = "One of a kind created successfully.";
            $new_one_of_a_kind = $this->oneOfAKindModel->findByName($name);

            foreach ($_FILES['newImages']['tmp_name'] as $index => $tmpName) {
                $one_of_a_kind_id = $new_one_of_a_kind['one_of_a_kind_id'];
                $this->oneOfAKindImageModel->one_of_a_kind_id = $one_of_a_kind_id;
                $image_id = $this->oneOfAKindImageModel->create();

                if ((int)$index == (int)$primary_image_idx) {
                    $this->oneOfAKindModel->one_of_a_kind_id = $one_of_a_kind_id;
                    $this->oneOfAKindModel->primary_image_id = $image_id;
                    $this->oneOfAKindModel->updatePrimaryImg();
                }

                $extension = $file_data['extension'][$index];
                $newFileName = sprintf("%s_%d_%d%s", $name, $one_of_a_kind_id, $image_id, $extension);
                $image_url = $relative_directory . $newFileName;
                $destination = $public_directory . $image_url;

                $this->oneOfAKindImageModel->image_id = $image_id;
                $this->oneOfAKindImageModel->image_url = $image_url;
                $this->oneOfAKindImageModel->update();

                // Move the uploaded file to the target directory
                if (move_uploaded_file($tmpName, $destination)) {
                    $message = "File uploaded successfully.";
                } else {
                    $status = 500;
                    $message = "One of a kind was created but the file upload failed.";
                }
            }
        } else {
            $status = 409;
            $message = "Error creating one of a kind.";
        }

        $this->helper->respondToClient($new_one_of_a_kind, $status, $message);
    }

    public function update($one_of_a_kind_id)
    {
        $inputData = file_get_contents('php://input');
        $data = json_decode($inputData, true);

        $name = trim($data['name']);
        $status = 200;
        $message = "";
        $one_of_a_kind = $this->oneOfAKindModel->findById($one_of_a_kind_id);
        $one_of_a_kind_with_same_name = $this->oneOfAKindModel->findByName($name);

        // Check if the one of a kind with the given ID exists
        if (!$one_of_a_kind) {
            $status = 409;
            $message = "There is no one of a kind with this id.";
        } else if ($one_of_a_kind_with_same_name !== false) {
            if (
                ($one_of_a_kind_with_same_name['one_of_a_kind_id'] !== $one_of_a_kind['one_of_a_kind_id']) &&
                ($one_of_a_kind_with_same_name['name'] === $name)
            ) {
                $status = 409;
                $message = "There is already a one of a kind with the name: \"$name\"";
            }
        }

        if ($status !== 200) {
            $this->helper->respondToClient(null, $status, $message);
        }

        if ($name !== $one_of_a_kind['name']) {
            /**
             * Means that we are updating the resource name
             * and so we must update the image urls
             */
            try {
                $images = $this->oneOfAKindImageModel->findByOneOfAKindId($one_of_a_kind_id);
                $public_directory = __DIR__ . '/../../public';
                $relative_directory = "/assets/images/gallery/one-of-a-kind/";
                foreach ($images as $image) {
                    $fileInfo = pathinfo($image['image_url']);
                    $extension = $fileInfo['extension'];
                    $image_id = $image['image_id'];

                    $newFileName = sprintf("%s_%d_%d.%s", $name, $one_of_a_kind_id, $image_id, $extension);
                    $uploadDirectory = $public_directory . $relative_directory;
                    $destination = $uploadDirectory . $newFileName;
                    $old_image_path = $public_directory . $image['image_url'];

                    if (file_exists($old_image_path)) {
                        if (rename($old_image_path, $destination)) {
                            $newImageUrl = $relative_directory . $newFileName;
                            $this->oneOfAKindImageModel->one_of_a_kind_id = $one_of_a_kind_id;
                            $this->oneOfAKindImageModel->image_url = $newImageUrl;
                            $this->oneOfAKindImageModel->image_id = $image_id;
                            $this->oneOfAKindImageModel->update();
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
            "dimension-units" => $dim_units,
            "width" => $width,
            "height" => $height,
            "depth" => $depth,
            "material" => $material,
            "color" => $color,
            "weight" => $weight,
            "weight-units" => $weight_units,
            "base_price" => $base_price,
            "stock_quantity" => $stock_quantity,
            "status" => $one_of_a_kind_status,
            "description" => $description,
        ] = $data;

        $width = $this->helper->truncateToThreeDecimals($width);
        $height = $this->helper->truncateToThreeDecimals($height);
        $depth = $this->helper->truncateToThreeDecimals($depth);
        $weight = $this->helper->truncateToThreeDecimals($weight);

        $dimensions = "$width{$dim_units} x $height{$dim_units} x $depth{$dim_units}";
        $weight = "$weight{$weight_units}";

        $this->oneOfAKindModel->one_of_a_kind_id = $one_of_a_kind_id;
        $this->oneOfAKindModel->name = $name;
        $this->oneOfAKindModel->dimensions = $dimensions;
        $this->oneOfAKindModel->material = $material;
        $this->oneOfAKindModel->color = $color;
        $this->oneOfAKindModel->weight = $weight;
        $this->oneOfAKindModel->price = $this->helper->truncateToThreeDecimals($base_price);
        $this->oneOfAKindModel->stock_quantity = $this->helper->truncateToThreeDecimals($stock_quantity);
        $this->oneOfAKindModel->status = $one_of_a_kind_status;
        $this->oneOfAKindModel->description = $description;
        $this->oneOfAKindModel->updated_by = $_SESSION['user']['user_id'];

        if ($this->oneOfAKindModel->update()) {
            $message = "One of a kind updated successfully.";
            $updated_one_of_a_kind = $this->oneOfAKindModel->findByName($name);
        } else {
            $status = 409;
            $message = "Error updating one of a kind.";
        }

        $this->helper->respondToClient($updated_one_of_a_kind, $status, $message);
    }

    public function restore($one_of_a_kind_id)
    {
        $one_of_a_kind_to_restore = null;
        $status = 200;
        $message = "";

        $this->oneOfAKindModel->one_of_a_kind_id = $one_of_a_kind_id;

        if ($this->oneOfAKindModel->restore()) {
            $message = "One of a kind restored successfully.";
            $one_of_a_kind_to_restore = $this->oneOfAKindModel->findById($one_of_a_kind_id);
        } else {
            $status = 500;
            $message = "Error deleting one of a kind.";
        }

        $this->helper->respondToClient($one_of_a_kind_to_restore, $status, $message);
    }

    public function delete($one_of_a_kind_id)
    {
        $one_of_a_kind_to_delete = $this->oneOfAKindModel->findById($one_of_a_kind_id);
        $status = 200;
        $message = "";

        $this->oneOfAKindModel->one_of_a_kind_id = $one_of_a_kind_id;

        if ($this->oneOfAKindModel->delete()) {
            $message = "One of a kind deleted successfully.";
            $one_of_a_kind_to_delete = $this->oneOfAKindModel->findById($one_of_a_kind_id);
        } else {
            $status = 500;
            $message = "Error deleting one of a kind.";
        }

        $this->helper->respondToClient($one_of_a_kind_to_delete, $status, $message);
    }
}
