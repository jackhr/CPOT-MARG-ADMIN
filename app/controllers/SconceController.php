<?php

namespace App\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Sconce;

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
        $this->view("admin/sconces/list.php", [
            "user" => $_SESSION['user'],
            "sconces" => $this->sconceModel->readAll(),
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

            $public_directory = "/assets/images/";
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
}
