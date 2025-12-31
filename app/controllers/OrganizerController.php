<?php
require_once __DIR__ . '/../../config/db.php';

class OrganizerController
{
    private $pdo;
    private $userId;
    private $orgId;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
        $this->userId = $_SESSION['user_id'];

        // Get Org ID
        $stmt = $this->pdo->prepare("SELECT org_id, approval_status FROM organizations WHERE user_id = ?");
        $stmt->execute([$this->userId]);
        $org = $stmt->fetch();
        $this->orgId = $org['org_id'] ?? null;
        $this->approvalStatus = $org['approval_status'] ?? 'pending';
    }

    public function getOrgId()
    {
        return $this->orgId;
    }
    public function getApprovalStatus()
    {
        return $this->approvalStatus;
    }

    public function getDashboardStats()
    {
        if (!$this->orgId)
            return [];
        $stats = [];
        $stats['total_events'] = $this->pdo->query("SELECT COUNT(*) FROM events WHERE org_id = {$this->orgId}")->fetchColumn();
        $stats['active_events'] = $this->pdo->query("SELECT COUNT(*) FROM events WHERE org_id = {$this->orgId} AND status = 'approved'")->fetchColumn();
        // Calculate earnings from payments joined with registrations joined with events
        $sql = "SELECT SUM(p.amount) FROM payments p 
                JOIN registrations r ON p.registration_id = r.registration_id 
                JOIN events e ON r.event_id = e.event_id 
                WHERE e.org_id = ? AND p.payment_status = 'completed'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->orgId]);
        $stats['earnings'] = $stmt->fetchColumn() ?: 0;
        return $stats;
    }

    public function createEvent($data, $files)
    {
        if ($this->approvalStatus != 'approved')
            return false;

        $bannerPath = '';
        if (isset($files['banner']) && $files['banner']['error'] == 0) {
            $uploadDir = __DIR__ . '/../../uploads/banners/';
            if (!is_dir($uploadDir))
                mkdir($uploadDir, 0777, true);
            $fileName = time() . '_' . basename($files['banner']['name']);
            $bannerPath = 'uploads/banners/' . $fileName;
            move_uploaded_file($files['banner']['tmp_name'], $uploadDir . $fileName);
        }

        $sql = "INSERT INTO events (org_id, category_id, title, description, venue, start_date, end_date, start_time, end_time, seat_limit, ticket_price, registration_deadline, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
        $stmt = $this->pdo->prepare($sql);
        try {
            $stmt->execute([
                $this->orgId,
                $data['category_id'],
                $data['title'],
                $data['description'],
                $data['venue'],
                $data['start_date'],
                $data['end_date'],
                $data['start_time'],
                $data['end_time'],
                $data['seat_limit'],
                $data['ticket_price'],
                $data['registration_deadline']
            ]);
            $eventId = $this->pdo->lastInsertId();

            if ($bannerPath) {
                $this->pdo->prepare("INSERT INTO event_images (event_id, image_path) VALUES (?, ?)")->execute([$eventId, $bannerPath]);
            }
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getMyEvents()
    {
        if (!$this->orgId)
            return [];
        return $this->pdo->query("SELECT * FROM events WHERE org_id = {$this->orgId} ORDER BY created_at DESC")->fetchAll();
    }

    public function getCategories()
    {
        return $this->pdo->query("SELECT * FROM categories")->fetchAll();
    }
}
?>