<?php

require_once __DIR__ . '/../config/Database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function register(string $fullName, string $email, string $password, string $phone, string $profilePhoto): bool
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $role = 'customer';  
        try {
            $stmt = $this->db->prepare("INSERT INTO users (full_name, email, password, phone, role, profile_photo) 
                                    VALUES (:fullName, :email, :password, :phone, :role, :profilePhoto)");

            $stmt->bindParam(':fullName', $fullName, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);  
            $stmt->bindParam(':profilePhoto', $profilePhoto, PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new Exception("Email already exists.");
            }

            throw new Exception("Database error: " . $e->getMessage());
        }
    }



    public function login(string $email, string $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->execute();

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }


    public function get($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");

        $stmt->execute([$id]);

        return $stmt->fetch();
    }



    public function update($id, $name, $email, $phone, $course, $photo)
    {
        $stmt = $this->db->prepare("UPDATE users SET full_name = ?, email = ?, phone = ?, course = ?, profile_photo = ? WHERE id = ?");

        return $stmt->execute([$name, $email, $phone, $course, $photo, $id]);
    }


    public function delete($id)
    {
        $user = $this->get($id);

        if ($user['role'] === 'admin') {
            throw new Exception("Cannot delete admin user.");
        }

        if ($user && $user['profile_photo'] !== 'default.png') {
            $file = __DIR__ . '/../../public/uploads/' . $user['profile_photo'];
            if (file_exists($file)) unlink($file);
        }

        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
