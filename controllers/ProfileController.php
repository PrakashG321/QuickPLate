<?php
require_once '../models/User.php';
require_once '../Upload/upload.php';

class ProfileController
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }
    }

    public function viewProfile()
    {
        $user = $this->user->get($_SESSION['user']);
        include __DIR__ . '/../views/profile.php';
    }

    public function update()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $course = $_POST['course'] ?? '';
            $current = $_POST['current_photo'] ?? '';
            $photo = $current;

            if (empty($name)) {
                $errors['name'] = "Full name is required.";
            }

            if (empty($email)) {
                $errors['email'] = "Email is required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email format.";
            }

            if (empty($phone)) {
                $errors['phone'] = "Phone number is required.";
            }

            if (empty($course)) {
                $errors['course'] = "Course selection is required.";
            }

            if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === 0) {
                $upload = new Upload($_FILES['profile_photo'], __DIR__ . '/../public/uploads/');
                $result = $upload->uploadFile();
                if ($result['status']) {
                    $photo = $result['file_name'];
                } else {
                    $errors['photo'] = "Error uploading photo: " . $result['message'];
                }
            }

            if (empty($errors)) {
                $this->user->update($_SESSION['user'], $name, $email, $phone, $course, $photo);
                header("Location: /dashboard");
                exit;
            }
        } else {
            $user = $this->user->get($_SESSION['user']);
            include __DIR__ . '/../views/update-profile.php';
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
            $this->user->delete($_SESSION['user']);
            session_destroy();
            header("Location: /");
            exit();
        } else {
            echo "Unauthorized action.";
        }
    }
}
