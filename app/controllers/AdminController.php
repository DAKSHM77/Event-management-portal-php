<?php
require_once __DIR__ . '/../../config/db.php';

class AdminController
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function getDashboardStats()
    {
        $stats = [];
        $stats['users'] = $this->pdo->query("SELECT COUNT(*) FROM users WHERE role != 'admin'")->fetchColumn();
        $stats['organizations'] = $this->pdo->query("SELECT COUNT(*) FROM organizations")->fetchColumn();
        $stats['events'] = $this->pdo->query("SELECT COUNT(*) FROM events")->fetchColumn();
        $stats['revenue'] = $this->pdo->query("SELECT SUM(amount) FROM payments WHERE payment_status = 'completed'")->fetchColumn() ?: 0;
        return $stats;
    }

    public function getAllUsers()
    {
        return $this->pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
    }

    public function toggleUserStatus($userId, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET status = ? WHERE user_id = ?");
        return $stmt->execute([$status, $userId]);
    }

    public function getPendingOrganizations()
    {
        return $this->pdo->query("SELECT o.*, u.name, u.email FROM organizations o JOIN users u ON o.user_id = u.user_id WHERE o.approval_status = 'pending'")->fetchAll();
    }

    public function getAllOrganizations()
    {
        return $this->pdo->query("SELECT o.*, u.name, u.email FROM organizations o JOIN users u ON o.user_id = u.user_id ORDER BY o.created_at DESC")->fetchAll();
    }

    public function approveOrganization($orgId)
    {
        $stmt = $this->pdo->prepare("UPDATE organizations SET approval_status = 'approved' WHERE org_id = ?");
        $stmt->execute([$orgId]);

        // Also verify user
        $org = $this->pdo->query("SELECT user_id FROM organizations WHERE org_id = $orgId")->fetch();
        if ($org) {
            $this->pdo->prepare("UPDATE users SET is_verified = 1 WHERE user_id = ?")->execute([$org['user_id']]);
        }
    }

    public function rejectOrganization($orgId)
    {
        $stmt = $this->pdo->prepare("UPDATE organizations SET approval_status = 'rejected' WHERE org_id = ?");
        $stmt->execute([$orgId]);
    }

    public function getPendingEvents()
    {
        return $this->pdo->query("SELECT e.*, c.category_name, o.org_name FROM events e JOIN categories c ON e.category_id = c.category_id JOIN organizations o ON e.org_id = o.org_id WHERE e.status = 'pending'")->fetchAll();
    }

    public function getAllEvents()
    {
        return $this->pdo->query("SELECT e.*, c.category_name, o.org_name FROM events e JOIN categories c ON e.category_id = c.category_id JOIN organizations o ON e.org_id = o.org_id ORDER BY e.created_at DESC")->fetchAll();
    }

    public function approveEvent($eventId)
    {
        $stmt = $this->pdo->prepare("UPDATE events SET status = 'approved' WHERE event_id = ?");
        return $stmt->execute([$eventId]);
    }

    public function rejectEvent($eventId, $reason)
    {
        $stmt = $this->pdo->prepare("UPDATE events SET status = 'rejected', rejection_reason = ? WHERE event_id = ?");
        return $stmt->execute([$reason, $eventId]);
    }

    public function getCategories()
    {
        return $this->pdo->query("SELECT * FROM categories")->fetchAll();
    }

    public function addCategory($name)
    {
        $stmt = $this->pdo->prepare("INSERT INTO categories (category_name) VALUES (?)");
        try {
            return $stmt->execute([$name]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteCategory($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM categories WHERE category_id = ?");
        return $stmt->execute([$id]);
    }
}
?>