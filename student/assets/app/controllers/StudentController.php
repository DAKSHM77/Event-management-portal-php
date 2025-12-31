<?php
require_once __DIR__ . '/../../config/db.php';

class StudentController
{
    private $pdo;
    private $userId;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
        $this->userId = $_SESSION['user_id'] ?? 0;
    }

    public function getUpcomingEvents($filter = [])
    {
        $sql = "SELECT e.*, c.category_name, o.org_name, i.image_path 
                FROM events e 
                JOIN categories c ON e.category_id = c.category_id 
                JOIN organizations o ON e.org_id = o.org_id 
                LEFT JOIN event_images i ON e.event_id = i.event_id 
                WHERE e.status = 'approved' AND e.start_date >= CURDATE()
                GROUP BY e.event_id";

        if (!empty($filter['category'])) {
            $catId = (int) $filter['category'];
            $sql .= " AND e.category_id = $catId";
        }

        if (!empty($filter['search'])) {
            $search = $filter['search'];
            $sql .= " AND (e.title LIKE '%$search%' 
                        OR e.description LIKE '%$search%' 
                        OR e.venue LIKE '%$search%' 
                        OR o.org_name LIKE '%$search%' 
                        OR c.category_name LIKE '%$search%')";
        }

        $sql .= " ORDER BY e.start_date ASC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function getEventDetails($eventId)
    {
        $stmt = $this->pdo->prepare("SELECT e.*, c.category_name, o.org_name, i.image_path 
                                    FROM events e 
                                    JOIN categories c ON e.category_id = c.category_id 
                                    JOIN organizations o ON e.org_id = o.org_id 
                                    LEFT JOIN event_images i ON e.event_id = i.event_id 
                                    WHERE e.event_id = ? 
                                    GROUP BY e.event_id");
        $stmt->execute([$eventId]);
        return $stmt->fetch();
    }

    public function isRegistered($eventId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM registrations WHERE event_id = ? AND user_id = ?");
        $stmt->execute([$eventId, $this->userId]);
        return $stmt->fetch();
    }

    public function registerForEvent($eventId, $paymentData = null)
    {
        // Check seats
        $event = $this->getEventDetails($eventId);
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM registrations WHERE event_id = ? AND registration_status = 'confirmed'");
        $stmt->execute([$eventId]);
        $booked = $stmt->fetchColumn();

        if ($booked >= $event['seat_limit']) {
            return ['status' => false, 'message' => 'Seats full'];
        }

        // Register
        $status = 'confirmed'; // Auto confirm for now, usually pending payment
        $sql = "INSERT INTO registrations (event_id, user_id, registration_status) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute([$eventId, $this->userId, $status]);
            $regId = $this->pdo->lastInsertId();

            // Process Payment (Mock)
            $amount = $event['ticket_price'];
            if ($amount > 0) {
                $paySql = "INSERT INTO payments (registration_id, amount, payment_method, payment_status, transaction_id) VALUES (?, ?, 'card', 'completed', ?)";
                $txnId = 'TXN' . time() . rand(100, 999);
                $this->pdo->prepare($paySql)->execute([$regId, $amount, $txnId]);
            }

            // Generate Ticket
            $ticketCode = 'TKT-' . $eventId . '-' . $this->userId . '-' . rand(1000, 9999);
            $this->pdo->prepare("INSERT INTO tickets (registration_id, ticket_code) VALUES (?, ?)")->execute([$regId, $ticketCode]);

            return ['status' => true, 'message' => 'Registered successfully!'];
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Registration failed: ' . $e->getMessage()];
        }
    }

    public function getMyRegistrations()
    {
        $sql = "SELECT r.*, e.title, e.start_date, e.start_time, e.venue, t.ticket_code, t.ticket_id 
                FROM registrations r 
                JOIN events e ON r.event_id = e.event_id 
                LEFT JOIN tickets t ON r.registration_id = t.registration_id
                WHERE r.user_id = ? 
                ORDER BY r.registered_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->userId]);
        return $stmt->fetchAll();
    }

    public function getCategories()
    {
        return $this->pdo->query("SELECT * FROM categories")->fetchAll();
    }

    public function getTicketDetails($regId)
    {
        $sql = "SELECT r.*, e.title, e.start_date, e.start_time, e.venue, e.ticket_price, u.name as user_name, t.ticket_code 
                FROM registrations r 
                JOIN events e ON r.event_id = e.event_id 
                JOIN users u ON r.user_id = u.user_id 
                LEFT JOIN tickets t ON r.registration_id = t.registration_id
                WHERE r.registration_id = ? AND r.user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$regId, $this->userId]);
        return $stmt->fetch();
    }
}
?>