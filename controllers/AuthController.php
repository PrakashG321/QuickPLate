<?php
require_once '../models/User.php';
require_once '../Upload/upload.php';

class AuthController
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function register()
    {

        if (isset($_SESSION['user'])) {
            header("Location: /menu"); 
            exit;
        }
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            include __DIR__ . '/../views/register.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $photo = 'default.png';  

            if (empty($name)) {
                $errors['name'] = "Full name is required.";
            }

            if (empty($email)) {
                $errors['ecmail'] = "Email is required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email format.";
            }

            if (empty($password)) {
                $errors['password'] = "Password is required.";
            } elseif (strlen($password) < 6) {
                $errors['password'] = "Password must be at least 6 characters long.";
            }

            if (empty($phone)) {
                $errors['phone'] = "Phone number is required.";
            }

            if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === 0) {
                $upload = new Upload($_FILES['profile_photo'], __DIR__ . '/../public/uploads/');
                $result = $upload->uploadFile();
                if ($result['status']) {
                    $photo = $result['file_name'];  
                } else {
                    $errors['photo'] = "Error uploading photo: " . $result['message'];
                }
            } else {
                $errors['photo'] = "Profile photo is required.";
            }

            if (empty($errors)) {
                try {
                    $this->user->register($name, $email, $password, $phone, $photo);  
                    header("Location: /login");
                    exit;
                } catch (Exception $e) {
                    $errors['general'] = $e->getMessage();
                }
            }
        }
        include __DIR__ . '/../views/register.php';
    }



    public function login()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Form validation
            if (empty($email)) {
                $errors['email'] = "Email is required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email format.";
            }

            if (empty($password)) {
                $errors['password'] = "Password is required.";
            }

            
            if (empty($errors)) {
                $user = $this->user->login($email, $password);

                if ($user) {
                    // Store user info in session
                    $_SESSION['user'] = $user['id'];
                    $_SESSION['role'] = $user['role']; 

                    header("Location: /menu"); 
                } else {
                    $errors['general'] = "Invalid credentials.";
                }
            }
        }

        include __DIR__ . '/../views/login.php';
    }




    public function logout()
    {
        session_destroy();
        header("Location: /");
    }
}
