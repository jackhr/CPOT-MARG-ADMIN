<?php

namespace App\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\OneOfAKind;
use Exception;

class OneOfAKindController extends Controller
{
    private $oneOfAKindModel;
    private $helper;

    public function __construct(GeneralHelper $helper)
    {
        $this->oneOfAKindModel = new OneOfAKind();
        $this->helper = $helper;
    }

    public function listOneOfAKinds()
    {
        $logged_in_user = $_SESSION['user'];
        $override_query = "SELECT one_of_a_kind.*, users_c.email AS created_by_email, users_u.email AS updated_by_email 
            FROM one_of_a_kind
            LEFT JOIN users users_c ON one_of_a_kind.created_by = users_c.user_id
            LEFT JOIN users users_u ON one_of_a_kind.updated_by = users_u.user_id";
        $one_of_a_kinds = $this->oneOfAKindModel->readAll($override_query);
        if ($logged_in_user['role_id'] > 1) {
            $one_of_a_kinds = array_filter($one_of_a_kinds, function ($one_of_a_kind) {
                return !isset($one_of_a_kind['deleted_at']);
            });
        }
        $this->view("admin/one-of-a-kind/list.php", [
            "user" => $logged_in_user,
            "one_of_a_kinds" => $one_of_a_kinds,
            "title" => "One of a Kind"
        ]);
    }

    public function create()
    {
        $name = $_POST['name'];
        $uploadedFile = null;
        $new_one_of_a_kind = [];
        $status = 200;
        $message = "";

        if (isset($_FILES['one-of-a-kind-img'])) {
            $uploadedFile = $_FILES['one-of-a-kind-img'];
            $fileType = $uploadedFile['type'];
            $extension = $this->helper->getFileExtension($fileType);

            $public_directory = "/assets/images/gallery/one-of-a-kind/";
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
            "breadth" => $breadth,
            "material" => $material,
            "color" => $color,
            "weight" => $weight,
            "weight-units" => $weight_units,
            "base_price" => $base_price,
            "stock_quantity" => $stock_quantity,
            "status" => $one_of_a_kind_status,
            "description" => $description,
        ] = $_POST;

        $width = $this->helper->truncateToThreeDecimals($width);
        $height = $this->helper->truncateToThreeDecimals($height);
        $breadth = $this->helper->truncateToThreeDecimals($breadth);
        $weight = $this->helper->truncateToThreeDecimals($weight);

        $dimensions = "$width{$dim_units} x $height{$dim_units} x $breadth{$dim_units}";
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
        $this->oneOfAKindModel->image_url = $image_url;
        $this->oneOfAKindModel->created_by = $_SESSION['user']['user_id'];

        if ($this->oneOfAKindModel->create()) {
            $message = "One of a kind created successfully.";
            $new_one_of_a_kind = $this->oneOfAKindModel->findByName($name);
            $tmpName = $uploadedFile['tmp_name'];

            $uploadDirectory = __DIR__ . '/../../public' . $public_directory;
            $destination = $uploadDirectory . $newFileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($tmpName, $destination)) {
                $message = "File uploaded successfully.";
            } else {
                $status = 500;
                $message = "One of a kind was created but the file upload failed.";
            }
        } else {
            $status = 409;
            $message = "Error creating one of a kind.";
        }

        $this->helper->respondToClient($new_one_of_a_kind, $status, $message);
    }

    public function update($one_of_a_kind_id)
    {
        $name = $_POST['name'];
        $uploadedFile = null;
        $new_one_of_a_kind = [];
        $status = 200;
        $message = "";
        $changing_image = isset($_FILES['one-of-a-kind-img']);

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
                $message = "There is already a one of a kind with that name.";
            }
        }

        try {
            if ($changing_image) {
                $uploadedFile = $_FILES['one-of-a-kind-img'];
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
                $relative_directory = "/assets/images/gallery/one-of-a-kind/";
                $newFileName = $name . $extension;
                $new_image_url = $relative_directory . $newFileName;
                $uploadDirectory = $public_directory . $relative_directory;
                $destination = $uploadDirectory . $newFileName;

                $tmpName = $uploadedFile['tmp_name'];
                $old_image_path = $public_directory . $one_of_a_kind['image_url'];

                // Handle existing file replacement or renaming
                if (file_exists($old_image_path)) {
                    if ($one_of_a_kind['name'] === $name) {
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
            } else if ($one_of_a_kind['name'] !== $name) {
                // not changing image, but changing name
                $fileInfo = pathinfo($one_of_a_kind['image_url']);
                $extension = $fileInfo['extension'];

                $public_directory = __DIR__ . '/../../public';
                $relative_directory = "/assets/images/gallery/one-of-a-kind/";
                $newFileName = "$name.$extension";
                $new_image_url = $relative_directory . $newFileName;
                $uploadDirectory = $public_directory . $relative_directory;
                $destination = $uploadDirectory . $newFileName;

                $old_image_path = $public_directory . $one_of_a_kind['image_url'];

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
            $this->helper->respondToClient($new_one_of_a_kind, $status, $message);
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
            "status" => $one_of_a_kind_status,
            "description" => $description,
        ] = $_POST;

        $width = $this->helper->truncateToThreeDecimals($width);
        $height = $this->helper->truncateToThreeDecimals($height);
        $breadth = $this->helper->truncateToThreeDecimals($breadth);
        $weight = $this->helper->truncateToThreeDecimals($weight);

        $dimensions = "$width{$dim_units} x $height{$dim_units} x $breadth{$dim_units}";
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
        $this->oneOfAKindModel->image_url = isset($new_image_url) ? $new_image_url : $one_of_a_kind['image_url'];
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
