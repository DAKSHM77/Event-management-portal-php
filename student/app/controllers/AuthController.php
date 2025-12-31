<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        global $pdo;
        $this->userModel = new User($pdo);
    }

    public function registerStudent()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];

            $userId = $this->userModel->register($name, $email, $phone, $password, 'student');

            if ($userId) {
                redirect('login.php?success=registered');
            } else {
                redirect('register.php?error=failed');
            }
        }
    }

    public function registerOrganization()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $orgName = $_POST['org_name'];
            $description = $_POST['description'];

            // Handle file upload
            $documentPath = '';
            if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
                $uploadDir = __DIR__ . '/../../uploads/documents/';
                if (!is_dir($uploadDir))
                    mkdir($uploadDir, 0777, true);
                $fileName = time() . '_' . basename($_FILES['document']['name']);
                $documentPath = 'uploads/documents/' . $fileName;
                move_uploaded_file($_FILES['document']['tmp_name'], $uploadDir . $fileName);
            }

            $userId = $this->userModel->register($name, $email, $phone, $password, 'organization');

            if ($userId) {
                $this->userModel->createOrganizationProfile($userId, $orgName, $description, $documentPath);
                redirect('login.php?success=org_pending');
            } else {
                redirect('register.php?type=org&error=failed');
            }
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];

            $user = $this->userModel->login($email, $password, $role);

            if ($user) {
                if ($user['status'] == 'blocked') {
                    redirect('login.php?error=blocked');
                }

                // Set Session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                // Redirect based on role
                if ($role == 'admin') {
                    redirect('admin/dashboard.php');
                } elseif ($role == 'organization') {
                    // Check approval
                    // Ideally query org status needed. But for now redirect to dash.
                    // The dashboard should show "Pending" message.
                    redirect('organizer/dashboard.php');
                } else {
                    redirect('student/dashboard.php');
                }
            } else {
                redirect('login.php?error=invalid_credentials');
            }
        }
    }

    public function logout()
    {
        session_destroy();
        redirect('login.php');
    }
}
?>