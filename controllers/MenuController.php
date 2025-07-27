<?php

require_once "../models/Menu.php";
class MenuController
{
    protected $menu;

    public function __construct()
    {
        $this->menu = new Menu();
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            include __DIR__ . '/../views/menu/create.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $image = 'default.png';

            $errors = [];

            if (empty($name)) {
                $errors['name'] = "Name is required.";
            }

            if (empty($description)) {
                $errors['description'] = "Description is required.";
            }

            if (empty($price)) {
                $errors['price'] = "Price is required.";
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $upload = new Upload($_FILES['image'], __DIR__ . '/../public/uploads/');
                $result = $upload->uploadFile();
                if ($result['status']) {
                    $image = $result['file_name'];
                } else {
                    $errors['image'] = "Error uploading image: " . $result['message'];
                }
            } else {
                $errors['image'] = "Image is required.";
            }

            if (empty($errors)) {
                try {
                    $this->menu->createItem($name, $description, $price, $image);
                    header("Location: /menu");
                    exit;
                } catch (Exception $e) {
                    // Handle the error
                    $errors['general'] = $e->getMessage();
                }
            }

            include __DIR__ . '/../views/menu/create.php';
        }
    }


    public function index()
    {
        try {
            $items = $this->menu->getAllItems();
            include __DIR__ . '/../views/menu/index.php';
        } catch (Exception $e) {
            // Handle the error
            echo "Error: " . $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            $item = $this->menu->getItemById($id);
            include __DIR__ . '/../views/menu/edit.php';
        } catch (Exception $e) {
            // Handle the error
            echo "Error: " . $e->getMessage();
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $image = $_FILES['image']['name'];

            try {
                if (!empty($image)) {
                    // Save uploaded file
                    $targetDir = __DIR__ . '/../public/uploads/';
                    $targetFile = $targetDir . basename($image);
                    move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
                } else {
                    // Keep the existing image
                    $item = $this->menu->getItemById($id);
                    $image = $item['image'];
                }

                $this->menu->updateItem($id, $name, $description, $price, $image);
                header("Location: /menu");
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }


    public function delete($id)
    {
        try {
            $this->menu->deleteItem($id);
            header("Location: /menu");
        } catch (Exception $e) {
            // Handle the error
            echo "Error: " . $e->getMessage();
        }
    }
}
