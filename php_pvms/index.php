<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
requireLogin();

// Get dashboard statistics
$stats = getDashboardStats();

require_once 'includes/header.php';
?>

<div class="page-header">
    <div class="page-header-icon bg-blue-100">
        <i class="fas fa-home text-blue-600"></i>
    </div>
    <h1>Dashboard</h1>
</div>

<div class="space-y-6">
    <!-- Stats Cards Row -->
    <div class="stats-grid">
        <div class="card stat-card stat-card-blue">
            <div class="stat-card-content">
                <div class="stat-card-info">
                    <p>Total Visitors</p>
                    <h3><?php echo $stats['total_visitors']; ?></h3>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-user-plus text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="card stat-card stat-card-yellow">
            <div class="stat-card-content">
                <div class="stat-card-info">
                    <p>Total Prisoners</p>
                    <h3><?php echo $stats['total_prisoners']; ?></h3>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-users text-yellow-600"></i>
                </div>
            </div>
        </div>
        
        <div class="card stat-card stat-card-purple">
            <div class="stat-card-content">
                <div class="stat-card-info">
                    <p>Active Visitors</p>
                    <h3><?php echo $stats['active_visits']; ?></h3>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-clock text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity Section -->
    <div class="card">
        <div class="card-header">
            <div class="flex justify-between items-center">
                <h2 class="card-title">Recent Activity</h2>
            </div>
        </div>
        <div class="card-content">
            <div class="activity-list">
                <?php if (empty($stats['recent_activities'])): ?>
                    <p class="text-center text-gray-500">No recent activities</p>
                <?php else: ?>
                    <?php foreach ($stats['recent_activities'] as $activity): ?>
                        <div class="activity-item">
                            <div class="activity-item-info">
                                <p><?php echo htmlspecialchars($activity['visitor_name']); ?> visited <?php echo htmlspecialchars($activity['prisoner_name']); ?></p>
                                <p><?php echo $activity['days_ago']; ?> days ago at <?php echo formatTime($activity['visit_time']); ?></p>
                            </div>
                            <span class="badge badge-outline <?php echo getStatusBadgeClass($activity['status']); ?>">
                                <?php echo $activity['status']; ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Visitor Management Tabs -->
    <div class="card">
        <div class="card-header">
            <div class="tabs-header">
                <h2 class="card-title">Visitor Management</h2>
                <div class="tabs-list">
                    <div class="tab-trigger active" data-tab="upcoming-tab">Upcoming</div>
                    <div class="tab-trigger" data-tab="past-tab">Past</div>
                </div>
            </div>
        </div>
        <div class="card-content">
            <!-- Upcoming Visits Tab -->
            <div id="upcoming-tab" class="tab-content active">
                <div class="flex justify-between items-center mb-4">
                    <div class="relative w-64">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-500"></i>
                        </span>
                        <input type="text" placeholder="Search visitors..." class="form-control pl-10">
                    </div>
                    <div class="flex gap-2">
                        <a href="visits.php" class="btn btn-outline btn-sm">
                            <i class="fas fa-filter mr-2"></i>
                            Filter
                        </a>
                        <a href="add_visitor.php" class="btn btn-primary btn-sm">
                            <i class="fas fa-user-plus mr-2"></i>
                            Add Visitor
                        </a>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Visitor</th>
                                <th>Prisoner</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Get upcoming visits
                            $stmt = $pdo->query("SELECT v.*, 
                                                CONCAT(vis.first_name, ' ', vis.last_name) as visitor_name, 
                                                CONCAT(p.first_name, ' ', p.last_name) as prisoner_name 
                                                FROM visits v 
                                                JOIN visitors vis ON v.visitor_id = vis.id 
                                                JOIN prisoners p ON v.prisoner_id = p.id 
                                                WHERE v.visit_date >= CURDATE() AND v.status = 'Scheduled' 
                                                ORDER BY v.visit_date ASC, v.visit_time ASC 
                                                LIMIT 5");
                            $upcomingVisits = $stmt->fetchAll();
                            
                            if (empty($upcomingVisits)): 
                            ?>
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-gray-500">
                                        No upcoming visits scheduled
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($upcomingVisits as $visit): ?>
                                    <tr>
                                        <td class="font-medium"><?php echo htmlspecialchars($visit['visitor_name']); ?></td>
                                        <td><?php echo htmlspecialchars($visit['prisoner_name']); ?></td>
                                        <td>
                                            <?php 
                                            $visitDate = new DateTime($visit['visit_date']);
                                            $today = new DateTime();
                                            $tomorrow = new DateTime('tomorrow');
                                            
                                            if ($visitDate->format('Y-m-d') === $today->format('Y-m-d')) {
                                                echo 'Today';
                                            } elseif ($visitDate->format('Y-m-d') === $tomorrow->format('Y-m-d')) {
                                                echo 'Tomorrow';
                                            } else {
                                                echo formatDate($visit['visit_date']);
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo formatTime($visit['visit_time']); ?></td>
                                        <td>
                                            <span class="badge badge-outline <?php echo getStatusBadgeClass($visit['status']); ?>">
                                                <?php echo $visit['status']; ?>
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <div class="table-actions">
                                                <a href="visits.php?view=<?php echo $visit['id']; ?>" class="btn btn-ghost btn-icon">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="visits.php?edit=<?php echo $visit['id']; ?>" class="btn btn-ghost btn-icon">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="visits.php?delete=<?php echo $visit['id']; ?>" class="btn btn-ghost btn-icon" onclick="return confirm('Are you sure you want to delete this visit?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Past Visits Tab -->
            <div id="past-tab" class="tab-content">
                <div class="flex justify-between items-center mb-4">
                    <div class="relative w-64">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-500"></i>
                        </span>
                        <input type="text" placeholder="Search visitors..." class="form-control pl-10">
                    </div>
                    <div class="flex gap-2">
                        <a href="visits.php" class="btn btn-outline btn-sm">
                            <i class="fas fa-filter mr-2"></i>
                            Filter
                        </a>
                        <a href="visits.php" class="btn btn-outline btn-sm">
                            <i class="fas fa-calendar mr-2"></i>
                            Date Range
                        </a>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Visitor</th>
                                <th>Prisoner</th>
                                <th>Date</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Get past visits
                            $stmt = $pdo->query("SELECT v.*, 
                                                CONCAT(vis.first_name, ' ', vis.last_name) as visitor_name, 
                                                CONCAT(p.first_name, ' ', p.last_name) as prisoner_name,
                                                DATEDIFF(CURDATE(), v.visit_date) as days_ago
                                                FROM visits v 
                                                JOIN visitors vis ON v.visitor_id = vis.id 
                                                JOIN prisoners p ON v.prisoner_id = p.id 
                                                WHERE v.visit_date < CURDATE() OR v.status = 'Completed' 
                                                ORDER BY v.visit_date DESC, v.visit_time DESC 
                                                LIMIT 5");
                            $pastVisits = $stmt->fetchAll();
                            
                            if (empty($pastVisits)): 
                            ?>
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-gray-500">
                                        No past visits found
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($pastVisits as $visit): ?>
                                    <tr>
                                        <td class="font-medium"><?php echo htmlspecialchars($visit['visitor_name']); ?></td>
                                        <td><?php echo htmlspecialchars($visit['prisoner_name']); ?></td>
                                        <td><?php echo $visit['days_ago']; ?> days ago</td>
                                        <td><?php echo calculateDuration($visit['entry_time'], $visit['exit_time']); ?></td>
                                        <td>
                                            <span class="badge badge-outline <?php echo getStatusBadgeClass($visit['status']); ?>">
                                                <?php echo $visit['status']; ?>
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <div class="table-actions">
                                                <a href="visits.php?view=<?php echo $visit['id']; ?>" class="btn btn-ghost btn-icon">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Quick Actions</h2>
        </div>
        <div class="card-content">
            <div class="flex flex-wrap gap-4">
                <a href="add_visitor.php" class="btn btn-primary">
                    <i class="fas fa-user-plus mr-2"></i>
                    Register New Visitor
                </a>
                <a href="visits.php" class="btn btn-outline">
                    <i class="fas fa-clock mr-2"></i>
                    View Visitor Log
                </a>
                <a href="prisoners.php" class="btn btn-outline">
                    <i class="fas fa-users mr-2"></i>
                    Manage Prisoners
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>