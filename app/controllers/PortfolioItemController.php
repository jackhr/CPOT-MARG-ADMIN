<?php

namespace App\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\PortfolioItem;
use App\Models\PortfolioItemImage;
use Exception;

class PortfolioItemController extends Controller
{
    private $portfolioItemModel;
    private $portfolioItemImageModel;
    private $helper;

    public function __construct(GeneralHelper $helper)
    {
        $this->portfolioItemModel = new PortfolioItem();
        $this->portfolioItemImageModel = new PortfolioItemImage();
        $this->helper = $helper;
    }

    public function listPortfolioItems()
    {
        $logged_in_user = $_SESSION['user'];
        $this->view("admin/portfolios/list.php", [
            "user" => $logged_in_user,
            "title" => "Portfolio"
        ]);
    }

    public function getAll()
    {
        $override_query = "SELECT portfolio_item.*, portfolio_item_images.image_url, users_c.email AS created_by_email, users_u.email AS updated_by_email 
            FROM portfolio_items
            LEFT JOIN portfolio_item_images ON portfolio_item.primary_image_id = portfolio_item_images.image_id
            LEFT JOIN users users_c ON portfolio_items.created_by = users_c.user_id
            LEFT JOIN users users_u ON portfolio_items.updated_by = users_u.user_id";
        $portfolio_items = $this->portfolioItemModel->readAll($override_query, "portfolio_item_id");
        $portfolio_item_images = $this->portfolioItemModel->DBRaw("SELECT * FROM portfolio_item_images");

        foreach ($portfolio_item_images as $portfolio_item_image) {
            $portfolio_item_id = $portfolio_item_image['portfolio_item_id'];
            $portfolio_items[$portfolio_item_id]['images'][$portfolio_item_image['image_id']] = $portfolio_item_image;
        }

        $this->helper->respondToClient($portfolio_items);
    }

    public function updateImages($portfolio_item_id)
    {
        $portfolio_item = $this->portfolioItemModel->findById($portfolio_item_id);
        $name = $portfolio_item['name'];
        $primary_image_idx = trim($_POST['primary_image_idx']);
        $primary_image_type = trim($_POST['primary_image_type']);
        $new_portfolio_item = [];
        $status = 200;
        $message = "Images updated successfully.";
        $public_directory = __DIR__ . '/../../public';
        $relative_directory = "/assets/images/gallery/portfolio-items/";

        if (!$portfolio_item) {
            $status = 409;
            $message = "There is no portfolio item with this id.";
        }

        if ($status !== 200) {
            $this->helper->respondToClient(null, $status, $message);
        }

        if (isset($_POST['deletedImages'])) {
            try {
                foreach ($_POST['deletedImages'] as $image_id) {
                    $image = $this->portfolioItemImageModel->findById($image_id);
                    $delete_image_path = $public_directory . $image['image_url'];
                    if (unlink($delete_image_path)) {
                        $this->portfolioItemImageModel->destroy($image_id);
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
                    $this->portfolioItemImageModel->portfolio_item_id = $portfolio_item_id;
                    $image_id = $this->portfolioItemImageModel->create();
                    $extension = $this->helper->getFileExtension($fileType);

                    if (!strlen($extension)) {
                        $status = 415;
                        throw new Exception("The file type was not recognized. Please use jpeg, png, webp, avif, or tiff.");
                    } else if (!$this->helper->checkIfFileTypeIsAcceptable($fileType)) {
                        $status = 409;
                        throw new Exception("The file type is not acceptable. Please use jpeg, png, webp, avif, or tiff.");
                    }

                    if ($primary_image_type === "newImages" && (int)$index == (int)$primary_image_idx) {
                        $this->portfolioItemModel->portfolio_item_id = $portfolio_item_id;
                        $this->portfolioItemModel->primary_image_id = $image_id;
                        $this->portfolioItemModel->updatePrimaryImg();
                    }

                    $tmpName = $_FILES['newImages']['tmp_name'][$index];
                    $newFileName = sprintf("%s_%d_%d%s", $name, $portfolio_item_id, $image_id, $extension);
                    $image_url = $relative_directory . $newFileName;
                    $destination = $public_directory . $image_url;

                    $this->portfolioItemImageModel->image_id = $image_id;
                    $this->portfolioItemImageModel->image_url = $image_url;
                    $this->portfolioItemImageModel->update();

                    // Move the uploaded file to the target directory
                    if (!move_uploaded_file($tmpName, $destination)) {
                        $status = 500;
                        $message = "Portfolio item was created but the file upload failed.";
                    }
                }
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }

        if ($status !== 200) {
            $this->helper->respondToClient($new_portfolio_item, $status, $message);
        }

        if ($primary_image_type === "existingImages") {
            $this->portfolioItemModel->portfolio_item_id = $portfolio_item_id;
            $this->portfolioItemModel->primary_image_id = $primary_image_idx;
            $this->portfolioItemModel->updatePrimaryImg();
        }

        $this->helper->respondToClient($portfolio_item, $status, $message);
    }

    public function create()
    {
        $name = trim($_POST['name']);
        $new_portfolio_item = [];
        $status = 200;
        $message = "";
        $file_data = [];
        $public_directory = __DIR__ . '/../../public';
        $relative_directory = "/assets/images/gallery/portfolio-items/";

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

        if ($this->portfolioItemModel->findByName($name)) {
            $status = 409;
            $message = "There is already a portfolio item with that name.";
        }

        if ($status !== 200) {
            $this->helper->respondToClient($new_portfolio_item, $status, $message);
        }

        [
            "dimension-units" => $dim_units,
            "width" => $width,
            "height" => $height,
            "depth" => $depth,
            "material" => $material,
            "artist" => $artist,
            "base_price" => $base_price,
            "status" => $portfolio_item_status,
            "description" => $description,
            "primary_image_idx" => $primary_image_idx,
        ] = $_POST;

        $width = $this->helper->truncateToThreeDecimals($width);
        $height = $this->helper->truncateToThreeDecimals($height);
        $depth = $this->helper->truncateToThreeDecimals($depth);

        $dimensions = "$width{$dim_units} x $height{$dim_units} x $depth{$dim_units}";

        $this->portfolioItemModel->name = $name;
        $this->portfolioItemModel->dimensions = $dimensions;
        $this->portfolioItemModel->material = $material;
        $this->portfolioItemModel->artist = $artist;
        $this->portfolioItemModel->price = $this->helper->truncateToThreeDecimals($base_price);
        $this->portfolioItemModel->status = $portfolio_item_status;
        $this->portfolioItemModel->description = $description;
        $this->portfolioItemModel->created_by = $_SESSION['user']['user_id'];

        try {
            $this->portfolioItemModel->create();
            $message = "Portfolio item created successfully.";
            $new_portfolio_item = $this->portfolioItemModel->findByName($name);

            foreach ($_FILES['newImages']['tmp_name'] as $index => $tmpName) {
                $portfolio_item_id = $new_portfolio_item['portfolio_item_id'];
                $this->portfolioItemImageModel->portfolio_item_id = $portfolio_item_id;
                $image_id = $this->portfolioItemImageModel->create();

                if ((int)$index == (int)$primary_image_idx) {
                    $this->portfolioItemModel->portfolio_item_id = $portfolio_item_id;
                    $this->portfolioItemModel->primary_image_id = $image_id;
                    $this->portfolioItemModel->updatePrimaryImg();
                }

                $extension = $file_data['extension'][$index];
                $newFileName = sprintf("%s_%d_%d%s", $name, $portfolio_item_id, $image_id, $extension);
                $image_url = $relative_directory . $newFileName;
                $destination = $public_directory . $image_url;

                $this->portfolioItemImageModel->image_id = $image_id;
                $this->portfolioItemImageModel->image_url = $image_url;
                $this->portfolioItemImageModel->update();

                // Move the uploaded file to the target directory
                if (move_uploaded_file($tmpName, $destination)) {
                    $message = "File uploaded successfully.";
                } else {
                    $status = 500;
                    $message = "Portfolio item was created but the file upload failed.";
                }
            }
        } catch (Exception $e) {
            $status = 409;
            $message = "Error creating portfolio item. {$e->getMessage()}";
        }

        $this->helper->respondToClient($new_portfolio_item, $status, $message);
    }

    public function update($portfolio_item_id)
    {
        $inputData = file_get_contents('php://input');
        $data = json_decode($inputData, true);

        $name = trim($data['name']);
        $status = 200;
        $message = "";
        $portfolio_item = $this->portfolioItemModel->findById($portfolio_item_id);
        $portfolio_item_with_same_name = $this->portfolioItemModel->findByName($name);

        // Check if the portfolio item with the given ID exists
        if (!$portfolio_item) {
            $status = 409;
            $message = "There is no portfolio item with this id.";
        } else if ($portfolio_item_with_same_name !== false) {
            if (
                ($portfolio_item_with_same_name['portfolio_item_id'] !== $portfolio_item['portfolio_item_id']) &&
                ($portfolio_item_with_same_name['name'] === $name)
            ) {
                $status = 409;
                $message = "There is already a portfolio item with the name: \"$name\"";
            }
        }

        if ($status !== 200) {
            $this->helper->respondToClient(null, $status, $message);
        }

        if ($name !== $portfolio_item['name']) {
            /**
             * Means that we are updating the resource name
             * and so we must update the image urls
             */
            try {
                $images = $this->portfolioItemImageModel->findByPortfolioItemId($portfolio_item_id);
                $public_directory = __DIR__ . '/../../public';
                $relative_directory = "/assets/images/gallery/portfolio-items/";
                foreach ($images as $image) {
                    $fileInfo = pathinfo($image['image_url']);
                    $extension = $fileInfo['extension'];
                    $image_id = $image['image_id'];

                    $newFileName = sprintf("%s_%d_%d.%s", $name, $portfolio_item_id, $image_id, $extension);
                    $uploadDirectory = $public_directory . $relative_directory;
                    $destination = $uploadDirectory . $newFileName;
                    $old_image_path = $public_directory . $image['image_url'];

                    if (file_exists($old_image_path)) {
                        if (rename($old_image_path, $destination)) {
                            $newImageUrl = $relative_directory . $newFileName;
                            $this->portfolioItemImageModel->portfolio_item_id = $portfolio_item_id;
                            $this->portfolioItemImageModel->image_url = $newImageUrl;
                            $this->portfolioItemImageModel->image_id = $image_id;
                            $this->portfolioItemImageModel->update();
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
            "artist" => $artist,
            "base_price" => $base_price,
            "status" => $portfolio_item_status,
            "description" => $description,
        ] = $data;

        $width = $this->helper->truncateToThreeDecimals($width);
        $height = $this->helper->truncateToThreeDecimals($height);
        $depth = $this->helper->truncateToThreeDecimals($depth);

        $dimensions = "$width{$dim_units} x $height{$dim_units} x $depth{$dim_units}";

        $this->portfolioItemModel->portfolio_item_id = $portfolio_item_id;
        $this->portfolioItemModel->name = $name;
        $this->portfolioItemModel->dimensions = $dimensions;
        $this->portfolioItemModel->material = $material;
        $this->portfolioItemModel->artist = $artist;
        $this->portfolioItemModel->price = $this->helper->truncateToThreeDecimals($base_price);
        $this->portfolioItemModel->status = $portfolio_item_status;
        $this->portfolioItemModel->description = $description;
        $this->portfolioItemModel->updated_by = $_SESSION['user']['user_id'];

        try {
            $this->portfolioItemModel->update();
            $message = "Portfolio item updated successfully.";
            $updated_portfolio_item = $this->portfolioItemModel->findByName($name);
        } catch (Exception $e) {
            $status = 409;
            $message = "Error updating portfolio item. {$e->getMessage()}";
        }

        $this->helper->respondToClient($updated_portfolio_item, $status, $message);
    }

    public function restore($portfolio_item_id)
    {
        $portfolio_item_to_restore = null;
        $status = 200;
        $message = "";

        $this->portfolioItemModel->portfolio_item_id = $portfolio_item_id;

        try {
            $this->portfolioItemModel->restore();
            $message = "Portfolio item restored successfully.";
            $portfolio_item_to_restore = $this->portfolioItemModel->findById($portfolio_item_id);
        } catch (Exception $e) {
            $status = 500;
            $message = "Error restoring this portfolio item. {$e->getMessage()}";
        }

        $this->helper->respondToClient($portfolio_item_to_restore, $status, $message);
    }

    public function delete($portfolio_item_id)
    {
        $portfolio_item_images_to_delete = $this->portfolioItemImageModel->findByPortfolioItemId($portfolio_item_id);
        $portfolio_item_to_delete = $this->portfolioItemModel->findById($portfolio_item_id);
        $status = 200;
        $message = "";
        $public_directory = __DIR__ . '/../../public';

        // first, delete the images, and the rows
        foreach ($portfolio_item_images_to_delete as $image) {
            $delete_image_path = $public_directory . $image['image_url'];
            if (unlink($delete_image_path)) {
                $this->portfolioItemImageModel->destroy($image['image_id']);
            } else {
                $status = 500;
                throw new Exception("Failed to delete the old image.");
            }
        }

        try {
            $this->portfolioItemModel->destroy($portfolio_item_id);
            $message = "Portfolio item deleted successfully.";
        } catch (Exception $e) {
            $status = 500;
            $message = "Error deleting portfolio item. {$e->getMessage()}";
        }

        $this->helper->respondToClient($portfolio_item_to_delete, $status, $message);
    }
}
