<?php
require_once 'config/db.php';

echo "<h2>Seeding Database (Enhanced)...</h2>";

try {
    // 1. Categories
    $categories = ['Technology', 'Music', 'Sports', 'Education', 'Health', 'Business', 'Art', 'Food', 'Gaming', 'Science'];
    $stmt = $pdo->prepare("INSERT IGNORE INTO categories (category_name) VALUES (?)");
    foreach ($categories as $cat) {
        $stmt->execute([$cat]);
    }
    echo "Categories seeded.<br>";

    // 2. Users (Organizers & Students)
    // We update the password if user exists to ensure credentials work
    $password = password_hash('password123', PASSWORD_DEFAULT);

    // Organizers
    $organizers = [
        ['Tech Corp', 'org1@test.com', '1234567890'],
        ['Music Fest Inc', 'org2@test.com', '0987654321'],
        ['Sports World', 'org3@test.com', '1122334455'],
        ['Gamer Zone', 'org4@test.com', '5566778899']
    ];

    foreach ($organizers as $org) {
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$org[1]]);
        $user = $stmt->fetch();

        if (!$user) {
            $pdo->prepare("INSERT INTO users (name, email, phone, password, role, is_verified, status) VALUES (?, ?, ?, ?, 'organization', 1, 'active')")
                ->execute([$org[0], $org[1], $org[2], $password]);

            $userId = $pdo->lastInsertId();
            $pdo->prepare("INSERT INTO organizations (user_id, org_name, description, approval_status) VALUES (?, ?, ?, 'approved')")
                ->execute([$userId, $org[0], "Leading organizer in " . $org[0], 'approved']);
            echo "Created organizer: {$org[1]}<br>";
        } else {
            // Update password just in case
            $pdo->prepare("UPDATE users SET password = ?, role = 'organization', status='active', is_verified=1 WHERE user_id = ?")->execute([$password, $user['user_id']]);
            // Ensure Org Profile exists
            $checkOrg = $pdo->query("SELECT * FROM organizations WHERE user_id = {$user['user_id']}")->fetch();
            if (!$checkOrg) {
                $pdo->prepare("INSERT INTO organizations (user_id, org_name, description, approval_status) VALUES (?, ?, ?, 'approved')")
                    ->execute([$user['user_id'], $org[0], "Leading organizer in " . $org[0], 'approved']);
            }
            echo "Updated organizer: {$org[1]}<br>";
        }
    }

    // Students
    $students = [
        ['John Doe', 'john@test.com'],
        ['Jane Smith', 'jane@test.com'],
        ['Alice Johnson', 'alice@test.com'],
        ['Bob Brown', 'bob@test.com']
    ];

    foreach ($students as $stu) {
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$stu[1]]);
        $user = $stmt->fetch();

        if (!$user) {
            $pdo->prepare("INSERT INTO users (name, email, phone, password, role, is_verified, status) VALUES (?, ?, '5555555555', ?, 'student', 1, 'active')")
                ->execute([$stu[0], $stu[1], $password]);
            echo "Created student: {$stu[1]}<br>";
        } else {
            $pdo->prepare("UPDATE users SET password = ?, role = 'student', status='active' WHERE user_id = ?")->execute([$password, $user['user_id']]);
            echo "Updated student: {$stu[1]}<br>";
        }
    }

    // 3. Events
    $orgIds = $pdo->query("SELECT org_id FROM organizations")->fetchAll(PDO::FETCH_COLUMN);
    $catIds = $pdo->query("SELECT category_id FROM categories")->fetchAll(PDO::FETCH_COLUMN);

    if (count($orgIds) > 0 && count($catIds) > 0) {
        $events = [
            [
                'Tech Summit 2025',
                "Join us for the most anticipated technology conference of the year! Tech Summit 2025 brings together industry leaders, innovators, and enthusiasts to explore the future of AI, Blockchain, and Quantum Computing. \n\nKey Highlights:\n- Keynote speeches by CEO of TechGiant and FutureAI.\n- Hands-on workshops on Machine Learning.\n- Networking sessions with top recruiters.\n- Startup pitch competition.\n\nDon't miss this opportunity to stay ahead of the curve!",
                'Convention Center, New York',
                'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1200&q=80'
            ],
            [
                'Rock Concert Live',
                "Prepare for an electrifying night of rock and roll! The 'Thunder Struck' world tour makes a stop at City Stadium.\n\nFeaturing:\n- The Rolling Stones Tribute Band\n- Neon High\n- The Graveyard Shift\n\nExperience high-voltage performances, spectacular light shows, and an atmosphere like no other. Food and drinks available at the venue.",
                'City Stadium, London',
                'https://images.unsplash.com/photo-1459749411177-2a2f5291f4b1?auto=format&fit=crop&w=1200&q=80'
            ],
            [
                'City Marathon 2025',
                "Lace up your running shoes and be part of the annual City Marathon. Whether you're a professional athlete or a beginner, there's a category for you.\n\nCategories:\n- 5K Fun Run\n- 10K Challenge\n- Half Marathon\n- Full Marathon\n\nAll proceeds go to the 'Heart for All' charity foundation. Registration kit includes T-Shirt, Medal, and Refreshments.",
                'Central Park, NY',
                'https://images.unsplash.com/photo-1452626038306-9aae5e071dd3?auto=format&fit=crop&w=1200&q=80'
            ],
            [
                'Startup Bootcamp',
                "Turn your idea into a business in just 3 days! This intensive bootcamp is designed for early-stage entrepreneurs.\n\nCurriculum:\n- Day 1: Ideation & Validation\n- Day 2: MVP & Prototyping\n- Day 3: Pitching & Fundraising\n\nMentors include successful founders and VCs. Winner gets $10k seed funding!",
                'Innovation Hub, SF',
                'https://images.unsplash.com/photo-1515187029135-18ee286d815b?auto=format&fit=crop&w=1200&q=80'
            ],
            [
                'Modern Art Exhibition',
                "Immerse yourself in the world of contemporary art. 'Visions of Tomorrow' showcases works from 50+ emerging artists from around the globe.\n\nExhibits include:\n- Abstract Expressionism\n- Digital Art Installations\n- Sustainable Sculptures\n\nGuided tours available every hour.",
                'Downtown Gallery, Paris',
                'https://images.unsplash.com/photo-1518998053901-5348d3969105?auto=format&fit=crop&w=1200&q=80'
            ],
            [
                'Food Festival 2025',
                "A culinary journey around the world in one place! The International Food Festival brings you authentic dishes from over 50 countries.\n\nAttractions:\n- Live Cooking Demos\n- Celebrity Chef Meet & Greet\n- Street Food Alley\n- Craft Beer Garden\n\nEntry ticket covers unlimited tasting! Come hungry.",
                'Riverfront Park, Chicago',
                'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=1200&q=80'
            ],
            [
                'AI & Robotics Workshop',
                "Build your first robot! A hands-on workshop for students and hobbyists. No prior experience required.\n\nWhat you'll learn:\n- Basics of Arduino & Raspberry Pi\n- Sensor integration\n- AI logic for obstacle avoidance\n\nTake home your own robot kit!",
                'Tech University, Boston',
                'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=1200&q=80'
            ],
            [
                'Jazz Night',
                "Relax and unwind to the smooth tunes of classic Jazz and Blues. An intimate evening at the legendary Blue Note Club.\n\nFeaturing the 'Smooth Operators' jazz quartet. Enjoy fine wine and cheese while you listen to the masters at work.",
                'Blue Note Club, New Orleans',
                'https://images.unsplash.com/photo-1511192336575-5a79af67a629?auto=format&fit=crop&w=1200&q=80'
            ],
            [
                'Digital Marketing M.Class',
                "Master the art of online growth. This masterclass covers SEO, SEM, Social Media, and Content Marketing strategies for 2025.\n\nInstructor: Sarah Jenkins, CMOS of GlobalTech.\n\nIncludes access to premium tools and templates.",
                'Online Webinar',
                'https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?auto=format&fit=crop&w=1200&q=80'
            ],
            [
                'Gaming Championship',
                "The ultimate esports showdown! Watch the best teams battle it out in Dota 2, CS:GO, and Valorant for a prize pool of $1 Million.\n\nExperience the hype, meet pro players, and participate in community tournaments. Cosplay competition on Sunday!",
                'Arena 51, Nevada',
                'https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=1200&q=80'
            ]
        ];

        foreach ($events as $evt) {
            $stmt = $pdo->prepare("SELECT event_id FROM events WHERE title = ?");
            $stmt->execute([$evt[0]]);
            $existingEvent = $stmt->fetch();

            $eventId = 0;

            if (!$existingEvent) {
                $orgId = $orgIds[array_rand($orgIds)];
                $catId = $catIds[array_rand($catIds)];

                // Random dates
                $startDate = date('Y-m-d', strtotime('+' . rand(1, 60) . ' days'));
                $endDate = date('Y-m-d', strtotime($startDate . ' + ' . rand(0, 2) . ' days'));
                $price = rand(0, 1) ? rand(10, 200) : 0; // 50% chance of paid

                $pdo->prepare("INSERT INTO events (org_id, category_id, title, description, venue, start_date, end_date, start_time, end_time, seat_limit, ticket_price, registration_deadline, status)
                    VALUES (?, ?, ?, ?, ?, ?, ?, '10:00:00', '18:00:00', 100, ?, ?, 'approved')")
                    ->execute([$orgId, $catId, $evt[0], $evt[1], $evt[2], $startDate, $endDate, $price, $startDate]);

                $eventId = $pdo->lastInsertId();
                echo "Created event: {$evt[0]}<br>";
            } else {
                $eventId = $existingEvent['event_id'];
                // Update description just in case
                $pdo->prepare("UPDATE events SET description = ? WHERE event_id = ?")->execute([$evt[1], $eventId]);
            }

            // ALWAYS Update/Insert Image to ensure it's the high-res one
            $pdo->prepare("DELETE FROM event_images WHERE event_id = ?")->execute([$eventId]);
            $pdo->prepare("INSERT INTO event_images (event_id, image_path) VALUES (?, ?)")->execute([$eventId, $evt[3]]);
            echo "Updated image for: {$evt[0]}<br>";
        }
    }

    // 4. Registrations & Tickets (Dummy "My Tickets")
    $studentEmails = ['john@test.com', 'jane@test.com'];
    $eventList = $pdo->query("SELECT event_id, ticket_price FROM events LIMIT 5")->fetchAll();

    foreach ($studentEmails as $email) {
        $user = $pdo->query("SELECT user_id FROM users WHERE email = '$email'")->fetch();
        if ($user) {
            $userId = $user['user_id'];
            foreach ($eventList as $evt) {
                // Check if already registered
                $check = $pdo->query("SELECT * FROM registrations WHERE user_id = $userId AND event_id = {$evt['event_id']}")->fetch();
                if (!$check) {
                    // Register
                    $pdo->prepare("INSERT INTO registrations (event_id, user_id, registration_status) VALUES (?, ?, 'confirmed')")
                        ->execute([$evt['event_id'], $userId]);
                    $regId = $pdo->lastInsertId();

                    // Payment (if paid)
                    if ($evt['ticket_price'] > 0) {
                        $pdo->prepare("INSERT INTO payments (registration_id, amount, payment_status, transaction_id) VALUES (?, ?, 'completed', ?)")
                            ->execute([$regId, $evt['ticket_price'], 'TXN' . rand(10000, 99999)]);
                    }

                    // Ticket
                    $ticketCode = 'TKT-' . $evt['event_id'] . '-' . $userId . '-' . rand(1000, 9999);
                    $pdo->prepare("INSERT INTO tickets (registration_id, ticket_code) VALUES (?, ?)")
                        ->execute([$regId, $ticketCode]);

                    echo "Ticket generated for User ID $userId (Event ID {$evt['event_id']})<br>";
                }
            }
        }
    }

    echo "<hr><h3 style='color:green'>Database Seeded & Passwords Updated!</h3>";
    echo "<p>Please ensure you use the following EXACT credentials:</p>";
    echo "<ul>";
    echo "<li><b>Role: Student</b> | Email: <b>john@test.com</b> | Password: <b>password123</b></li>";
    echo "<li><b>Role: Organization</b> | Email: <b>org1@test.com</b> | Password: <b>password123</b></li>";
    echo "</ul>";
    echo "<p><i>If login fails, ensure you select the correct ROLE in the dropdown list on the login page.</i></p>";
    echo "<br><a href='login.php' class='btn btn-primary'>Go to Login</a>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>