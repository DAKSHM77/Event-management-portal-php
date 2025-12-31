<?php
require_once __DIR__ . '/../../config/db.php';

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function register($name, $email, $phone, $password, $role)
    {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Status checks
        $status = 'active';
        $is_verified = 1; // Auto verify students for now, or use 0 if needing email

        if ($role === 'organization') {
            $is_verified = 0; // Org needs approval
        }

        $sql = "INSERT INTO users (name, email, phone, password, role, is_verified, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        try {
            $stmt->execute([$name, $email, $phone, $hashed_password, $role, $is_verified, $status]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            // Handle duplicate entry or other errors
            return false;
        }
    }

    public function login($email, $password, $role)
    {
        $sql = "SELECT * FROM users WHERE email = ? AND role = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email, $role]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function createOrganizationProfile($userId, $orgName, $description, $documentPath)
    {
        $sql = "INSERT INTO organizations (user_id, org_name, description, document_path, approval_status) VALUES (?, ?, ?, ?, 'pending')";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId, $orgName, $description, $documentPath]);
    }
}
?>