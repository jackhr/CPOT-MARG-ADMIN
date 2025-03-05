<?php

namespace App\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\GalleryItem;
use App\Models\GalleryItemImage;
use Exception;

class GalleryItemController extends Controller
{
    private $galleryItemModel;
    private $galleryItemImageModel;
    private $helper;

    public function __construct(GeneralHelper $helper)
    {
        $this->galleryItemModel = new GalleryItem();
        $this->galleryItemImageModel = new GalleryItemImage();
        $this->helper = $helper;
    }

    public function listGalleryItems()
    {
        $logged_in_user = $_SESSION['user'];
        $this->view("admin/gallery-items/list.php", [
            "user" => $logged_in_user,
            "title" => "Gallery Items"
        ]);
    }

    public function getAll()
    {
        $logged_in_user = $_SESSION['user'];
        $override_query = "SELECT gallery_items.*, gallery_item_images.image_url, users_c.email AS created_by_email, users_u.email AS updated_by_email 
            FROM gallery_items
            LEFT JOIN gallery_item_images ON gallery_items.primary_image_id = gallery_item_images.image_id
            LEFT JOIN users users_c ON gallery_items.created_by = users_c.user_id
            LEFT JOIN users users_u ON gallery_items.updated_by = users_u.user_id";
        $gallery_items = $this->galleryItemModel->readAll($override_query, "item_id");
        if ($logged_in_user['role_id'] > 1 || isset($_GET['only_active'])) {
            $gallery_items = array_filter($gallery_items, function ($gallery_item) {
                return !isset($gallery_item['deleted_at']);
            });
        }


        $gallery_item_images = $this->galleryItemImageModel->DBRaw("SELECT * FROM gallery_item_images");

        foreach ($gallery_item_images as $gallery_item_image) {
            $gallery_item_id = $gallery_item_image['gallery_item_id'];
            if (isset($gallery_items[$gallery_item_id])) {
                $gallery_items[$gallery_item_id]['images'][$gallery_item_image['image_id']] = $gallery_item_image;
            }
        }

        $this->helper->respondToClient($gallery_items);
    }

    public function updateImages($gallery_item_id)
    {
        $gallery_item = $this->galleryItemModel->findById($gallery_item_id);
        $name = $gallery_item['name'];
        $primary_image_idx = trim($_POST['primary_image_idx']);
        $primary_image_type = trim($_POST['primary_image_type']);
        $new_gallery_item = [];
        $status = 200;
        $message = "Images updated successfully.";
        $public_directory = __DIR__ . '/../../public';
        $relative_directory = "/assets/images/gallery/gallery_items/";

        if (!$gallery_item) {
            $status = 409;
            $message = "There is no gallery item with this id.";
        }

        if ($status !== 200) {
            $this->helper->respondToClient(null, $status, $message);
        }

        if (isset($_POST['deletedImages'])) {
            try {
                foreach ($_POST['deletedImages'] as $image_id) {
                    $image = $this->galleryItemImageModel->findById($image_id);
                    $delete_image_path = $public_directory . $image['image_url'];
                    if (!unlink($delete_image_path)) {
                        $status = 500;
                        throw new Exception("Failed to delete the old image.");
                    } else {
                        $this->galleryItemImageModel->image_id = $image_id;
                        $this->galleryItemImageModel->delete();
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
                    $this->galleryItemImageModel->gallery_item_id = $gallery_item_id;
                    $image_id = $this->galleryItemImageModel->create();
                    $extension = $this->helper->getFileExtension($fileType);

                    if (!strlen($extension)) {
                        $status = 415;
                        throw new Exception("The file type was not recognized. Please use jpeg, png, webp, avif, or tiff.");
                    } else if (!$this->helper->checkIfFileTypeIsAcceptable($fileType)) {
                        $status = 409;
                        throw new Exception("The file type is not acceptable. Please use jpeg, png, webp, avif, or tiff.");
                    }

                    if ($primary_image_type === "newImages" && (int)$index == (int)$primary_image_idx) {
                        $this->galleryItemModel->item_id = $gallery_item_id;
                        $this->galleryItemModel->primary_image_id = $image_id;
                        $this->galleryItemModel->updatePrimaryImg();
                    }

                    $tmpName = $_FILES['newImages']['tmp_name'][$index];
                    $newFileName = sprintf("%s_%d_%d%s", $name, $gallery_item_id, $image_id, $extension);
                    $image_url = $relative_directory . $newFileName;
                    $destination = $public_directory . $image_url;

                    $this->galleryItemImageModel->image_id = $image_id;
                    $this->galleryItemImageModel->image_url = $image_url;
                    $this->galleryItemImageModel->update();

                    // Move the uploaded file to the target directory
                    if (!move_uploaded_file($tmpName, $destination)) {
                        $status = 500;
                        $message = "Gallery Item was created but the file upload failed.";
                    }
                }
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }

        if ($status !== 200) {
            $this->helper->respondToClient($new_gallery_item, $status, $message);
        }

        if ($primary_image_type === "existingImages") {
            $this->galleryItemModel->item_id = $gallery_item_id;
            $this->galleryItemModel->primary_image_id = $primary_image_idx;
            $this->galleryItemModel->updatePrimaryImg();
        }

        $this->helper->respondToClient($gallery_item, $status, $message);
    }

    public function create()
    {
        $name = trim($_POST['name']);
        $new_gallery_item = [];
        $status = 200;
        $message = "";
        $file_data = [];
        $public_directory = __DIR__ . '/../../public';
        $relative_directory = "/assets/images/gallery/gallery_items/";

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

        if ($this->galleryItemModel->findByName($name)) {
            $status = 409;
            $message = "There is already a gallery item with that name.";
        }

        if ($status !== 200) {
            $this->helper->respondToClient($new_gallery_item, $status, $message);
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
            "price" => $price,
            "status" => $gallery_item_status,
            "description" => $description,
            "showing_on_site" => $showing_on_site,
            "primary_image_idx" => $primary_image_idx,
        ] = $_POST;

        $depth = $this->helper->truncateToThreeDecimals($depth);
        $width = $this->helper->truncateToThreeDecimals($width);
        $height = $this->helper->truncateToThreeDecimals($height);
        $weight = $this->helper->truncateToThreeDecimals($weight);

        $dimensions = "$depth{$dim_units} x $width{$dim_units} x $height{$dim_units}";
        $weight = "$weight{$weight_units}";

        $this->galleryItemModel->name = $name;
        $this->galleryItemModel->dimensions = $dimensions;
        $this->galleryItemModel->material = $material;
        $this->galleryItemModel->color = $color;
        $this->galleryItemModel->weight = $weight;
        $this->galleryItemModel->price = $this->helper->truncateToThreeDecimals($price);
        $this->galleryItemModel->status = $gallery_item_status;
        $this->galleryItemModel->description = $description;
        $this->galleryItemModel->showing_on_site = $showing_on_site;
        $this->galleryItemModel->created_by = $_SESSION['user']['user_id'];

        if ($this->galleryItemModel->create()) {
            $message = "Gallery Item created successfully.";
            $new_gallery_item = $this->galleryItemModel->findByName($name);

            foreach ($_FILES['newImages']['tmp_name'] as $index => $tmpName) {
                $gallery_item_id = $new_gallery_item['item_id'];
                $this->galleryItemImageModel->gallery_item_id = $gallery_item_id;
                $image_id = $this->galleryItemImageModel->create();

                if ((int)$index == (int)$primary_image_idx) {
                    $this->galleryItemModel->item_id = $gallery_item_id;
                    $this->galleryItemModel->primary_image_id = $image_id;
                    $this->galleryItemModel->updatePrimaryImg();
                }

                $extension = $file_data['extension'][$index];
                $newFileName = sprintf("%s_%d_%d%s", $name, $gallery_item_id, $image_id, $extension);
                $image_url = $relative_directory . $newFileName;
                $destination = $public_directory . $image_url;

                $this->galleryItemImageModel->image_id = $image_id;
                $this->galleryItemImageModel->image_url = $image_url;
                $this->galleryItemImageModel->update();

                // Move the uploaded file to the target directory
                if (move_uploaded_file($tmpName, $destination)) {
                    $message = "File uploaded successfully.";
                } else {
                    $status = 500;
                    $message = "Gallery Item was created but the file upload failed.";
                }
            }
        } else {
            $status = 409;
            $message = "Error creating gallery item.";
        }

        $this->helper->respondToClient($new_gallery_item, $status, $message);
    }

    public function update($gallery_item_id)
    {
        $inputData = file_get_contents('php://input');
        $data = json_decode($inputData, true);

        $name = trim($data['name']);
        $status = 200;
        $message = "";
        $gallery_item = $this->galleryItemModel->findById($gallery_item_id);
        $gallery_item_with_same_name = $this->galleryItemModel->findByName($name);

        // Check if the gallery item with the given ID exists
        if (!$gallery_item) {
            $status = 409;
            $message = "There is no gallery_item with this id.";
        } else if ($gallery_item_with_same_name !== false) {
            if (
                ($gallery_item_with_same_name['gallery_item_id'] !== $gallery_item['gallery_item_id']) &&
                ($gallery_item_with_same_name['name'] === $name)
            ) {
                $status = 409;
                $message = "There is already an item with the name: \"$name\"";
            }
        }

        if ($status !== 200) {
            $this->helper->respondToClient(null, $status, $message);
        }

        if ($name !== $gallery_item['name']) {
            /**
             * Means that we are updating the resource name
             * and so we must update the image urls
             */
            try {
                $images = $this->galleryItemImageModel->findByGalleryItemId($gallery_item_id);
                $public_directory = __DIR__ . '/../../public';
                $relative_directory = "/assets/images/gallery/gallery_items/";
                foreach ($images as $image) {
                    $fileInfo = pathinfo($image['image_url']);
                    $extension = $fileInfo['extension'];
                    $image_id = $image['image_id'];

                    $newFileName = sprintf("%s_%d_%d.%s", $name, $gallery_item_id, $image_id, $extension);
                    $uploadDirectory = $public_directory . $relative_directory;
                    $destination = $uploadDirectory . $newFileName;
                    $old_image_path = $public_directory . $image['image_url'];

                    if (file_exists($old_image_path)) {
                        if (rename($old_image_path, $destination)) {
                            $newImageUrl = $relative_directory . $newFileName;
                            $this->galleryItemImageModel->gallery_item_id = $gallery_item_id;
                            $this->galleryItemImageModel->image_url = $newImageUrl;
                            $this->galleryItemImageModel->image_id = $image_id;
                            $this->galleryItemImageModel->update();
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
            "price" => $price,
            "status" => $gallery_item_status,
            "description" => $description,
            "showing_on_site" => $showing_on_site,
        ] = $data;

        $depth = $this->helper->truncateToThreeDecimals($depth);
        $width = $this->helper->truncateToThreeDecimals($width);
        $height = $this->helper->truncateToThreeDecimals($height);
        $weight = $this->helper->truncateToThreeDecimals($weight);

        $dimensions = "$depth{$dim_units} x $width{$dim_units} x $height{$dim_units}";
        $weight = "$weight{$weight_units}";

        $this->galleryItemModel->item_id = $gallery_item_id;
        $this->galleryItemModel->name = $name;
        $this->galleryItemModel->dimensions = $dimensions;
        $this->galleryItemModel->material = $material;
        $this->galleryItemModel->color = $color;
        $this->galleryItemModel->weight = $weight;
        $this->galleryItemModel->price = $this->helper->truncateToThreeDecimals($price);
        $this->galleryItemModel->status = $gallery_item_status;
        $this->galleryItemModel->description = $description;
        $this->galleryItemModel->showing_on_site = $showing_on_site;
        $this->galleryItemModel->updated_by = $_SESSION['user']['user_id'];

        if ($this->galleryItemModel->update()) {
            $message = "gallery item updated successfully.";
            $updated_gallery_item = $this->galleryItemModel->findByName($name);
        } else {
            $status = 409;
            $message = "Error updating gallery item.";
        }

        $this->helper->respondToClient($updated_gallery_item, $status, $message);
    }

    public function restore($gallery_item_id)
    {
        $gallery_item_to_restore = null;
        $status = 200;
        $message = "";

        $this->galleryItemModel->item_id = $gallery_item_id;

        if ($this->galleryItemModel->restore()) {
            $message = "Gallery Item restored successfully.";
            $gallery_item_to_restore = $this->galleryItemModel->findById($gallery_item_id);
        } else {
            $status = 500;
            $message = "Error restoring gallery item.";
        }

        $this->helper->respondToClient($gallery_item_to_restore, $status, $message);
    }

    public function delete($gallery_item_id)
    {
        $gallery_item_to_delete = $this->galleryItemModel->findById($gallery_item_id);
        $status = 200;
        $message = "";

        $this->galleryItemModel->item_id = $gallery_item_id;

        if ($this->galleryItemModel->delete()) {
            $message = "Gallery Item deleted successfully.";
            $gallery_item_to_delete = $this->galleryItemModel->findById($gallery_item_id);
        } else {
            $status = 500;
            $message = "Error deleting gallery item.";
        }

        $this->helper->respondToClient($gallery_item_to_delete, $status, $message);
    }
}
