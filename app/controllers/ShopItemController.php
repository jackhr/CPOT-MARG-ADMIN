<?php

namespace App\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\ShopItem;
use App\Models\ShopItemImage;
use Exception;

class ShopItemController extends Controller
{
    private $shopItemModel;
    private $shopItemImageModel;
    private $helper;

    public function __construct(GeneralHelper $helper)
    {
        $this->shopItemModel = new ShopItem();
        $this->shopItemImageModel = new ShopItemImage();
        $this->helper = $helper;
    }

    public function listShopItems()
    {
        $logged_in_user = $_SESSION['user'];
        $this->view("admin/shop-items/list.php", [
            "user" => $logged_in_user,
            "title" => "Shop Items"
        ]);
    }

    public function getAll()
    {
        $override_query = "SELECT shop_items.*, shop_item_images.image_url, users_c.email AS created_by_email, users_u.email AS updated_by_email 
            FROM shop_items
            LEFT JOIN shop_item_images ON shop_items.primary_image_id = shop_item_images.image_id
            LEFT JOIN users users_c ON shop_items.created_by = users_c.user_id
            LEFT JOIN users users_u ON shop_items.updated_by = users_u.user_id";
        $shop_items = $this->shopItemModel->readAll($override_query, "shop_item_id");
        if (isset($_GET['only_active'])) {
            $shop_items = array_filter($shop_items, function ($shop_item) {
                return !isset($shop_item['deleted_at']);
            });
        }

        $shop_item_images = $this->shopItemImageModel->DBRaw("SELECT * FROM shop_item_images");

        foreach ($shop_item_images as $shop_item_image) {
            $shop_item_id = $shop_item_image['shop_item_id'];
            if (isset($shop_items[$shop_item_id])) {
                $shop_items[$shop_item_id]['images'][$shop_item_image['image_id']] = $shop_item_image;
            }
        }

        $this->helper->respondToClient($shop_items);
    }

    public function updateImages($shop_item_id)
    {
        $shop_item = $this->shopItemModel->findById($shop_item_id);
        $name = $shop_item['name'];
        $primary_image_idx = trim($_POST['primary_image_idx']);
        $primary_image_type = trim($_POST['primary_image_type']);
        $new_shop_item = [];
        $status = 200;
        $message = "Images updated successfully.";
        $public_directory = __DIR__ . '/../../public';
        $relative_directory = "/assets/images/gallery/shop-items/";

        if (!$shop_item) {
            $status = 409;
            $message = "There is no shop item with this id.";
        }

        if ($status !== 200) {
            $this->helper->respondToClient(null, $status, $message);
        }

        if (isset($_POST['deletedImages'])) {
            try {
                foreach ($_POST['deletedImages'] as $image_id) {
                    $image = $this->shopItemImageModel->findById($image_id);
                    $delete_image_path = $public_directory . $image['image_url'];
                    if (unlink($delete_image_path)) {
                        $this->shopItemImageModel->destroy($image_id);
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
                    $this->shopItemImageModel->shop_item_id = $shop_item_id;
                    $image_id = $this->shopItemImageModel->create();
                    $extension = $this->helper->getFileExtension($fileType);

                    if (!strlen($extension)) {
                        $status = 415;
                        throw new Exception("The file type was not recognized. Please use jpeg, png, webp, avif, or tiff.");
                    } else if (!$this->helper->checkIfFileTypeIsAcceptable($fileType)) {
                        $status = 409;
                        throw new Exception("The file type is not acceptable. Please use jpeg, png, webp, avif, or tiff.");
                    }

                    if ($primary_image_type === "newImages" && (int)$index == (int)$primary_image_idx) {
                        $this->shopItemModel->shop_item_id = $shop_item_id;
                        $this->shopItemModel->primary_image_id = $image_id;
                        $this->shopItemModel->updatePrimaryImg();
                    }

                    $tmpName = $_FILES['newImages']['tmp_name'][$index];
                    $newFileName = sprintf("%s_%d_%d%s", $name, $shop_item_id, $image_id, $extension);
                    $image_url = $relative_directory . $newFileName;
                    $destination = $public_directory . $image_url;

                    $this->shopItemImageModel->image_id = $image_id;
                    $this->shopItemImageModel->image_url = $image_url;
                    $this->shopItemImageModel->update();

                    // Move the uploaded file to the target directory
                    if (!move_uploaded_file($tmpName, $destination)) {
                        $status = 500;
                        $message = "Shop Item was created but the file upload failed.";
                    }
                }
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }

        if ($status !== 200) {
            $this->helper->respondToClient($new_shop_item, $status, $message);
        }

        if ($primary_image_type === "existingImages") {
            $this->shopItemModel->shop_item_id = $shop_item_id;
            $this->shopItemModel->primary_image_id = $primary_image_idx;
            $this->shopItemModel->updatePrimaryImg();
        }

        $this->helper->respondToClient($shop_item, $status, $message);
    }

    public function create()
    {
        $name = trim($_POST['name']);
        $new_shop_item = [];
        $status = 200;
        $message = "";
        $file_data = [];
        $public_directory = __DIR__ . '/../../public';
        $relative_directory = "/assets/images/gallery/shop-items/";

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

        if ($this->shopItemModel->findByName($name)) {
            $status = 409;
            $message = "There is already a shop item with that name.";
        }

        if ($status !== 200) {
            $this->helper->respondToClient($new_shop_item, $status, $message);
        }

        [
            "artist" => $artist,
            // "dimension-units" => $dim_units,
            "width" => $width,
            "height" => $height,
            "depth" => $depth,
            "material" => $material,
            "color" => $color,
            "price" => $price,
            "status" => $shop_item_status,
            "description" => $description,
            "showing_on_site" => $showing_on_site,
            "primary_image_idx" => $primary_image_idx,
        ] = $_POST;

        $depth = $this->helper->truncateToThreeDecimals($depth);
        $width = $this->helper->truncateToThreeDecimals($width);
        $height = $this->helper->truncateToThreeDecimals($height);

        $dim_units = "in"; // defaulting to inches for the time being
        $dimensions = "$depth{$dim_units} x $width{$dim_units} x $height{$dim_units}";

        $this->shopItemModel->name = $name;
        $this->shopItemModel->artist = $artist;
        $this->shopItemModel->dimensions = $dimensions;
        $this->shopItemModel->material = $material;
        $this->shopItemModel->color = $color;
        $this->shopItemModel->price = $this->helper->truncateToThreeDecimals($price);
        $this->shopItemModel->status = $shop_item_status;
        $this->shopItemModel->description = $description;
        $this->shopItemModel->showing_on_site = $showing_on_site;
        $this->shopItemModel->created_by = $_SESSION['user']['user_id'];

        if ($this->shopItemModel->create()) {
            $message = "Shop Item created successfully.";
            $new_shop_item = $this->shopItemModel->findByName($name);

            foreach ($_FILES['newImages']['tmp_name'] as $index => $tmpName) {
                $shop_item_id = $new_shop_item['shop_item_id'];
                $this->shopItemImageModel->shop_item_id = $shop_item_id;
                $image_id = $this->shopItemImageModel->create();

                if ((int)$index == (int)$primary_image_idx) {
                    $this->shopItemModel->shop_item_id = $shop_item_id;
                    $this->shopItemModel->primary_image_id = $image_id;
                    $this->shopItemModel->updatePrimaryImg();
                }

                $extension = $file_data['extension'][$index];
                $newFileName = sprintf("%s_%d_%d%s", $name, $shop_item_id, $image_id, $extension);
                $image_url = $relative_directory . $newFileName;
                $destination = $public_directory . $image_url;

                $this->shopItemImageModel->image_id = $image_id;
                $this->shopItemImageModel->image_url = $image_url;
                $this->shopItemImageModel->update();

                // Move the uploaded file to the target directory
                if (move_uploaded_file($tmpName, $destination)) {
                    $message = "File uploaded successfully.";
                } else {
                    $status = 500;
                    $message = "Shop Item was created but the file upload failed.";
                }
            }
        } else {
            $status = 409;
            $message = "Error creating shop item.";
        }

        $this->helper->respondToClient($new_shop_item, $status, $message);
    }

    public function update($shop_item_id)
    {
        $inputData = file_get_contents('php://input');
        $data = json_decode($inputData, true);

        $name = trim($data['name']);
        $status = 200;
        $message = "";
        $shop_item = $this->shopItemModel->findById($shop_item_id);
        $shop_item_with_same_name = $this->shopItemModel->findByName($name);

        // Check if the shop item with the given ID exists
        if (!$shop_item) {
            $status = 409;
            $message = "There is no shop_item with this id.";
        } else if ($shop_item_with_same_name !== false) {
            if (
                ($shop_item_with_same_name['shop_item_id'] !== $shop_item['shop_item_id']) &&
                ($shop_item_with_same_name['name'] === $name)
            ) {
                $status = 409;
                $message = "There is already an item with the name: \"$name\"";
            }
        }

        if ($status !== 200) {
            $this->helper->respondToClient(null, $status, $message);
        }

        if ($name !== $shop_item['name']) {
            /**
             * Means that we are updating the resource name
             * and so we must update the image urls
             */
            try {
                $images = $this->shopItemImageModel->findByShopItemId($shop_item_id);
                $public_directory = __DIR__ . '/../../public';
                $relative_directory = "/assets/images/gallery/shop-items/";
                foreach ($images as $image) {
                    $fileInfo = pathinfo($image['image_url']);
                    $extension = $fileInfo['extension'];
                    $image_id = $image['image_id'];

                    $newFileName = sprintf("%s_%d_%d.%s", $name, $shop_item_id, $image_id, $extension);
                    $uploadDirectory = $public_directory . $relative_directory;
                    $destination = $uploadDirectory . $newFileName;
                    $old_image_path = $public_directory . $image['image_url'];

                    if (file_exists($old_image_path)) {
                        if (rename($old_image_path, $destination)) {
                            $newImageUrl = $relative_directory . $newFileName;
                            $this->shopItemImageModel->shop_item_id = $shop_item_id;
                            $this->shopItemImageModel->image_url = $newImageUrl;
                            $this->shopItemImageModel->image_id = $image_id;
                            $this->shopItemImageModel->update();
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
            "artist" => $artist,
            // "dimension-units" => $dim_units,
            "width" => $width,
            "height" => $height,
            "depth" => $depth,
            "material" => $material,
            "color" => $color,
            "price" => $price,
            "status" => $shop_item_status,
            "description" => $description,
            "showing_on_site" => $showing_on_site,
        ] = $data;

        $depth = $this->helper->truncateToThreeDecimals($depth);
        $width = $this->helper->truncateToThreeDecimals($width);
        $height = $this->helper->truncateToThreeDecimals($height);

        $dim_units = "in"; // defaulting to inches for the time being
        $dimensions = "$depth{$dim_units} x $width{$dim_units} x $height{$dim_units}";

        $this->shopItemModel->shop_item_id = $shop_item_id;
        $this->shopItemModel->name = $name;
        $this->shopItemModel->artist = $artist;
        $this->shopItemModel->dimensions = $dimensions;
        $this->shopItemModel->material = $material;
        $this->shopItemModel->color = $color;
        $this->shopItemModel->price = $this->helper->truncateToThreeDecimals($price);
        $this->shopItemModel->status = $shop_item_status;
        $this->shopItemModel->description = $description;
        $this->shopItemModel->showing_on_site = $showing_on_site;
        $this->shopItemModel->updated_by = $_SESSION['user']['user_id'];

        if ($this->shopItemModel->update()) {
            $message = "shop item updated successfully.";
            $updated_shop_item = $this->shopItemModel->findByName($name);
        } else {
            $status = 409;
            $message = "Error updating shop item.";
        }

        $this->helper->respondToClient($updated_shop_item, $status, $message);
    }

    public function restore($shop_item_id)
    {
        $shop_item_to_restore = null;
        $status = 200;
        $message = "";

        $this->shopItemModel->shop_item_id = $shop_item_id;

        if ($this->shopItemModel->restore()) {
            $message = "Shop Item restored successfully.";
            $shop_item_to_restore = $this->shopItemModel->findById($shop_item_id);
        } else {
            $status = 500;
            $message = "Error restoring shop item.";
        }

        $this->helper->respondToClient($shop_item_to_restore, $status, $message);
    }

    public function delete($shop_item_id)
    {
        $shop_item_to_delete = $this->shopItemModel->findById($shop_item_id);
        $shop_item_images = $this->shopItemImageModel->findByShopItemId($shop_item_id);
        $status = 200;
        $message = "";
        $public_directory = __DIR__ . '/../../public';

        // first, delete the images, and the rows
        foreach ($shop_item_images as $image) {
            $delete_image_path = $public_directory . $image['image_url'];
            if (unlink($delete_image_path)) {
                $this->shopItemImageModel->destroy($image['image_id']);
            } else {
                $status = 500;
                throw new Exception("Failed to delete the old image.");
            }
        }

        if ($this->shopItemModel->destroy($shop_item_id)) {
            $message = "Shop Item deleted successfully.";
        } else {
            $status = 500;
            $message = "Error deleting shop item.";
        }

        $this->helper->respondToClient($shop_item_to_delete, $status, $message);
    }
}
