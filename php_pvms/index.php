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
    
    <!-- Summary Demographics Charts -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Summary Demographics</h2>
            <p class="card-description">Visitor trends and prisoner statistics</p>
        </div>
        <div class="card-content">
            <div class="charts-grid">
                <!-- Visitor Trends Line Chart -->
                <div class="chart-container">
                    <h3 class="chart-title">Visitor Trends (Last 7 Days)</h3>
                    <div class="line-chart">
                        <?php 
                        $max_count = 0;
                        foreach ($stats['demographics']['visitor_trends'] as $trend) {
                            if ($trend['count'] > $max_count) $max_count = $trend['count'];
                        }
                        $max_count = max(1, $max_count); // Avoid division by zero
                        ?>
                        <svg viewBox="0 0 700 250" xmlns="http://www.w3.org/2000/svg">
                            <!-- X and Y axis -->
                            <line x1="50" y1="220" x2="650" y2="220" stroke="#cbd5e1" stroke-width="2"/>
                            <line x1="50" y1="30" x2="50" y2="220" stroke="#cbd5e1" stroke-width="2"/>
                            
                            <!-- X axis labels -->
                            <?php 
                            $x_interval = 600 / (count($stats['demographics']['visitor_trends']) - 1);
                            foreach ($stats['demographics']['visitor_trends'] as $index => $trend): 
                                $x = 50 + ($index * $x_interval);
                            ?>
                                <text x="<?php echo $x; ?>" y="240" text-anchor="middle" font-size="12" fill="#64748b"><?php echo $trend['day']; ?></text>
                            <?php endforeach; ?>
                            
                            <!-- Y axis labels -->
                            <?php for ($i = 0; $i <= 4; $i++): 
                                $y = 220 - ($i * 47.5);
                                $value = round(($i / 4) * $max_count);
                            ?>
                                <text x="40" y="<?php echo $y + 5; ?>" text-anchor="end" font-size="12" fill="#64748b"><?php echo $value; ?></text>
                                <line x1="48" y1="<?php echo $y; ?>" x2="650" y2="<?php echo $y; ?>" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="5,5"/>
                            <?php endfor; ?>
                            
                            <!-- Data points and line -->
                            <?php 
                            $points = [];
                            foreach ($stats['demographics']['visitor_trends'] as $index => $trend): 
                                $x = 50 + ($index * $x_interval);
                                $y = 220 - ($trend['count'] / $max_count * 190);
                                $points[] = "$x,$y";
                            ?>
                                <circle cx="<?php echo $x; ?>" cy="<?php echo $y; ?>" r="4" fill="#3b82f6"/>
                            <?php endforeach; ?>
                            
                            <polyline points="<?php echo implode(' ', $points); ?>" fill="none" stroke="#3b82f6" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Security Level Bar Chart -->
                <div class="chart-container">
                    <h3 class="chart-title">Prisoner Security Levels</h3>
                    <div class="bar-chart">
                        <?php 
                        $max_count = 0;
                        foreach ($stats['demographics']['security_levels'] as $level) {
                            if ($level['count'] > $max_count) $max_count = $level['count'];
                        }
                        $max_count = max(1, $max_count); // Avoid division by zero
                        
                        foreach ($stats['demographics']['security_levels'] as $level): 
                            $height = ($level['count'] / $max_count) * 200;
                            $color = '';
                            switch (strtolower($level['security_level'])) {
                                case 'low': $color = '#10b981'; break; // green
                                case 'medium': $color = '#f59e0b'; break; // yellow
                                case 'high': $color = '#f97316'; break; // orange
                                case 'maximum': $color = '#ef4444'; break; // red
                                default: $color = '#3b82f6'; break; // blue
                            }
                        ?>
                            <div class="bar-chart-container">
                                <div class="bar" style="height: <?php echo $height; ?>px; background-color: <?php echo $color; ?>;"></div>
                                <div class="bar-label"><?php echo $level['security_level']; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Visitor Relationship Pie Chart -->
                <div class="chart-container">
                    <h3 class="chart-title">Visitor Relationships</h3>
                    <div class="pie-chart">
                        <?php 
                        $total = 0;
                        foreach ($stats['demographics']['relationships'] as $rel) {
                            $total += $rel['count'];
                        }
                        $total = max(1, $total); // Avoid division by zero
                        
                        // Colors for pie segments
                        $colors = ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444'];
                        ?>
                        
                        <div class="pie-chart-container">
                            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="100" cy="100" r="90" fill="#f1f5f9"/>
                                <?php 
                                $start_angle = 0;
                                foreach ($stats['demographics']['relationships'] as $index => $rel): 
                                    $percentage = ($rel['count'] / $total);
                                    $angle = $percentage * 360;
                                    $end_angle = $start_angle + $angle;
                                    
                                    // Calculate SVG arc path
                                    $start_x = 100 + 90 * cos(deg2rad($start_angle));
                                    $start_y = 100 + 90 * sin(deg2rad($start_angle));
                                    $end_x = 100 + 90 * cos(deg2rad($end_angle));
                                    $end_y = 100 + 90 * sin(deg2rad($end_angle));
                                    
                                    $large_arc = $angle > 180 ? 1 : 0;
                                    
                                    $color = $colors[$index % count($colors)];
                                ?>
                                <path d="M 100 100 L <?php echo $start_x; ?> <?php echo $start_y; ?> A 90 90 0 <?php echo $large_arc; ?> 1 <?php echo $end_x; ?> <?php echo $end_y; ?> Z" fill="<?php echo $color; ?>"/>
                                <?php 
                                    $start_angle = $end_angle;
                                endforeach; 
                                ?>
                            </svg>
                        </div>
                        
                        <div class="pie-legend">
                            <?php foreach ($stats['demographics']['relationships'] as $index => $rel): 
                                $color = $colors[$index % count($colors)];
                            ?>
                                <div class="legend-item">
                                    <div class="legend-color" style="background-color: <?php echo $color; ?>"></div>
                                    <div class="legend-label"><?php echo $rel['relationship']; ?> (<?php echo $rel['count']; ?>)</div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Visit Status Bar Chart -->
                <div class="chart-container">
                    <h3 class="chart-title">Visit Status Distribution</h3>
                    <div class="bar-chart">
                        <?php 
                        $max_count = 0;
                        foreach ($stats['demographics']['visit_status'] as $status) {
                            if ($status['count'] > $max_count) $max_count = $status['count'];
                        }
                        $max_count = max(1, $max_count); // Avoid division by zero
                        
                        foreach ($stats['demographics']['visit_status'] as $status): 
                            $height = ($status['count'] / $max_count) * 200;
                            $color = '';
                            switch ($status['status']) {
                                case 'Scheduled': $color = '#3b82f6'; break; // blue
                                case 'In Progress': $color = '#f59e0b'; break; // yellow
                                case 'Completed': $color = '#10b981'; break; // green
                                case 'Cancelled': $color = '#ef4444'; break; // red
                                default: $color = '#64748b'; break; // gray
                            }
                        ?>
                            <div class="bar-chart-container">
                                <div class="bar" style="height: <?php echo $height; ?>px; background-color: <?php echo $color; ?>;"></div>
                                <div class="bar-label"><?php echo $status['status']; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
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