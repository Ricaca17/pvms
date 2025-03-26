<?php
require_once 'config.php';

// User authentication functions
function authenticateUser($username, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        return true;
    }
    
    return false;
}

function logoutUser() {
    // Unset all session variables
    $_SESSION = [];
    
    // Destroy the session
    session_destroy();
}

// Visitor management functions
function getAllVisitors() {
    global $pdo;
    
    $stmt = $pdo->query("SELECT * FROM visitors ORDER BY last_name ASC");
    return $stmt->fetchAll();
}

function getVisitorById($id) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM visitors WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function addVisitor($data) {
    global $pdo;
    
    $stmt = $pdo->prepare("INSERT INTO visitors (first_name, last_name, id_type, id_number, relationship, phone, email, address, created_at) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    
    return $stmt->execute([
        $data['first_name'],
        $data['last_name'],
        $data['id_type'],
        $data['id_number'],
        $data['relationship'],
        $data['phone'],
        $data['email'],
        $data['address']
    ]);
}

function updateVisitor($id, $data) {
    global $pdo;
    
    $stmt = $pdo->prepare("UPDATE visitors SET 
                          first_name = ?, 
                          last_name = ?, 
                          id_type = ?, 
                          id_number = ?, 
                          relationship = ?, 
                          phone = ?, 
                          email = ?, 
                          address = ?, 
                          updated_at = NOW() 
                          WHERE id = ?");
    
    return $stmt->execute([
        $data['first_name'],
        $data['last_name'],
        $data['id_type'],
        $data['id_number'],
        $data['relationship'],
        $data['phone'],
        $data['email'],
        $data['address'],
        $id
    ]);
}

function deleteVisitor($id) {
    global $pdo;
    
    $stmt = $pdo->prepare("DELETE FROM visitors WHERE id = ?");
    return $stmt->execute([$id]);
}

// Prisoner management functions
function getAllPrisoners() {
    global $pdo;
    
    $stmt = $pdo->query("SELECT * FROM prisoners ORDER BY last_name ASC");
    return $stmt->fetchAll();
}

function getPrisonerById($id) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM prisoners WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function addPrisoner($data) {
    global $pdo;
    
    $stmt = $pdo->prepare("INSERT INTO prisoners 
                          (first_name, last_name, age, gender, id_number, crime, sentence, 
                          admission_date, release_date, cell, security_level, health_status, 
                          emergency_contact_name, emergency_contact_relation, emergency_contact_phone, created_at) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    
    return $stmt->execute([
        $data['first_name'],
        $data['last_name'],
        $data['age'],
        $data['gender'],
        $data['id_number'],
        $data['crime'],
        $data['sentence'],
        $data['admission_date'],
        $data['release_date'],
        $data['cell'],
        $data['security_level'],
        $data['health_status'],
        $data['emergency_contact_name'],
        $data['emergency_contact_relation'],
        $data['emergency_contact_phone']
    ]);
}

function updatePrisoner($id, $data) {
    global $pdo;
    
    $stmt = $pdo->prepare("UPDATE prisoners SET 
                          first_name = ?, 
                          last_name = ?, 
                          age = ?, 
                          gender = ?, 
                          id_number = ?, 
                          crime = ?, 
                          sentence = ?, 
                          admission_date = ?, 
                          release_date = ?, 
                          cell = ?, 
                          security_level = ?, 
                          health_status = ?, 
                          emergency_contact_name = ?, 
                          emergency_contact_relation = ?, 
                          emergency_contact_phone = ?, 
                          updated_at = NOW() 
                          WHERE id = ?");
    
    return $stmt->execute([
        $data['first_name'],
        $data['last_name'],
        $data['age'],
        $data['gender'],
        $data['id_number'],
        $data['crime'],
        $data['sentence'],
        $data['admission_date'],
        $data['release_date'],
        $data['cell'],
        $data['security_level'],
        $data['health_status'],
        $data['emergency_contact_name'],
        $data['emergency_contact_relation'],
        $data['emergency_contact_phone'],
        $id
    ]);
}

function deletePrisoner($id) {
    global $pdo;
    
    $stmt = $pdo->prepare("DELETE FROM prisoners WHERE id = ?");
    return $stmt->execute([$id]);
}

// Visit management functions
function getAllVisits() {
    global $pdo;
    
    $stmt = $pdo->query("SELECT v.*, 
                         CONCAT(vis.first_name, ' ', vis.last_name) as visitor_name, 
                         CONCAT(p.first_name, ' ', p.last_name) as prisoner_name 
                         FROM visits v 
                         JOIN visitors vis ON v.visitor_id = vis.id 
                         JOIN prisoners p ON v.prisoner_id = p.id 
                         ORDER BY v.visit_date DESC, v.visit_time DESC");
    return $stmt->fetchAll();
}

function getVisitById($id) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT v.*, 
                          CONCAT(vis.first_name, ' ', vis.last_name) as visitor_name, 
                          CONCAT(p.first_name, ' ', p.last_name) as prisoner_name 
                          FROM visits v 
                          JOIN visitors vis ON v.visitor_id = vis.id 
                          JOIN prisoners p ON v.prisoner_id = p.id 
                          WHERE v.id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function addVisit($data) {
    global $pdo;
    
    // Generate activation code
    $activation_code = generateActivationCode();
    
    $stmt = $pdo->prepare("INSERT INTO visits 
                          (visitor_id, prisoner_id, visit_purpose, visit_date, visit_time, 
                          status, activation_code, created_at) 
                          VALUES (?, ?, ?, ?, ?, 'Scheduled', ?, NOW())");
    
    return $stmt->execute([
        $data['visitor_id'],
        $data['prisoner_id'],
        $data['visit_purpose'],
        $data['visit_date'],
        $data['visit_time'],
        $activation_code
    ]);
}

function updateVisitStatus($id, $status) {
    global $pdo;
    
    $stmt = $pdo->prepare("UPDATE visits SET status = ?, updated_at = NOW() WHERE id = ?");
    return $stmt->execute([$status, $id]);
}

function activateVisit($activation_code) {
    global $pdo;
    
    // Check if activation code exists and visit is scheduled for today
    $stmt = $pdo->prepare("SELECT * FROM visits 
                          WHERE activation_code = ? 
                          AND status = 'Scheduled' 
                          AND visit_date = CURDATE()");
    $stmt->execute([$activation_code]);
    $visit = $stmt->fetch();
    
    if ($visit) {
        // Update visit status to In Progress
        $update = $pdo->prepare("UPDATE visits SET 
                               status = 'In Progress', 
                               entry_time = NOW(), 
                               updated_at = NOW() 
                               WHERE id = ?");
        return $update->execute([$visit['id']]);
    }
    
    return false;
}

function completeVisit($id) {
    global $pdo;
    
    $stmt = $pdo->prepare("UPDATE visits SET 
                          status = 'Completed', 
                          exit_time = NOW(), 
                          updated_at = NOW() 
                          WHERE id = ?");
    return $stmt->execute([$id]);
}

function cancelVisit($id) {
    global $pdo;
    
    $stmt = $pdo->prepare("UPDATE visits SET 
                          status = 'Cancelled', 
                          updated_at = NOW() 
                          WHERE id = ?");
    return $stmt->execute([$id]);
}

// Dashboard statistics functions
function getDashboardStats() {
    global $pdo;
    
    $stats = [];
    
    // Total visitors
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM visitors");
    $stats['total_visitors'] = $stmt->fetch()['total'];
    
    // Total prisoners
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM prisoners");
    $stats['total_prisoners'] = $stmt->fetch()['total'];
    
    // Active visits (in progress)
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM visits WHERE status = 'In Progress'");
    $stats['active_visits'] = $stmt->fetch()['total'];
    
    // Recent activities (last 5 visits)
    $stmt = $pdo->query("SELECT v.*, 
                         CONCAT(vis.first_name, ' ', vis.last_name) as visitor_name, 
                         CONCAT(p.first_name, ' ', p.last_name) as prisoner_name,
                         DATEDIFF(CURDATE(), v.visit_date) as days_ago
                         FROM visits v 
                         JOIN visitors vis ON v.visitor_id = vis.id 
                         JOIN prisoners p ON v.prisoner_id = p.id 
                         ORDER BY v.visit_date DESC, v.visit_time DESC 
                         LIMIT 5");
    $stats['recent_activities'] = $stmt->fetchAll();
    
    // Get demographics data for charts
    $stats['demographics'] = getDemographicsData();
    
    return $stats;
}

// Get demographics data for charts
function getDemographicsData() {
    global $pdo;
    $data = [];
    
    // Visitor trends (last 7 days)
    $stmt = $pdo->query("SELECT DATE_FORMAT(visit_date, '%a') as day, COUNT(*) as count 
                         FROM visits 
                         WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
                         GROUP BY DATE_FORMAT(visit_date, '%a'), visit_date 
                         ORDER BY visit_date ASC");
    $data['visitor_trends'] = $stmt->fetchAll();
    
    // Fill in missing days with zero counts
    $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $visitor_trends_complete = [];
    $existing_days = array_column($data['visitor_trends'], 'day');
    
    foreach ($days as $day) {
        if (in_array($day, $existing_days)) {
            foreach ($data['visitor_trends'] as $trend) {
                if ($trend['day'] === $day) {
                    $visitor_trends_complete[] = $trend;
                    break;
                }
            }
        } else {
            $visitor_trends_complete[] = ['day' => $day, 'count' => 0];
        }
    }
    $data['visitor_trends'] = $visitor_trends_complete;
    
    // Prisoner demographics by security level
    $stmt = $pdo->query("SELECT security_level, COUNT(*) as count 
                         FROM prisoners 
                         GROUP BY security_level 
                         ORDER BY FIELD(security_level, 'Low', 'Medium', 'High', 'Maximum')");
    $data['security_levels'] = $stmt->fetchAll();
    
    // Visitor relationship types
    $stmt = $pdo->query("SELECT relationship, COUNT(*) as count 
                         FROM visitors 
                         GROUP BY relationship 
                         ORDER BY count DESC 
                         LIMIT 5");
    $data['relationships'] = $stmt->fetchAll();
    
    // Visit status distribution
    $stmt = $pdo->query("SELECT status, COUNT(*) as count 
                         FROM visits 
                         GROUP BY status");
    $data['visit_status'] = $stmt->fetchAll();
    
    return $data;
}

// Helper functions
function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

function formatTime($time) {
    return date('h:i A', strtotime($time));
}

function calculateDuration($entry_time, $exit_time) {
    if (!$entry_time || !$exit_time) {
        return 'N/A';
    }
    
    $entry = new DateTime($entry_time);
    $exit = new DateTime($exit_time);
    $diff = $entry->diff($exit);
    
    $hours = $diff->h;
    $minutes = $diff->i;
    
    if ($hours > 0) {
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ' . $minutes . ' min';
    } else {
        return $minutes . ' minutes';
    }
}

function getStatusBadgeClass($status) {
    switch ($status) {
        case 'Scheduled':
            return 'badge-blue';
        case 'In Progress':
            return 'badge-yellow';
        case 'Completed':
            return 'badge-green';
        case 'Cancelled':
            return 'badge-red';
        default:
            return 'badge-blue';
    }
}

function getSecurityLevelBadgeClass($level) {
    switch (strtolower($level)) {
        case 'low':
            return 'badge-green';
        case 'medium':
            return 'badge-yellow';
        case 'high':
            return 'badge-orange';
        case 'maximum':
            return 'badge-red';
        default:
            return 'badge-blue';
    }
}
?>