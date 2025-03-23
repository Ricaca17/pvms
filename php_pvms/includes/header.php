<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check if dark mode is set in cookie
$darkMode = isset($_COOKIE['dark_mode']) && $_COOKIE['dark_mode'] === 'true';
$darkClass = $darkMode ? 'dark' : '';

// Don't require login for login page and activation page
$current_page = basename($_SERVER['PHP_SELF']);
$public_pages = ['login.php', 'activate.php'];

if (!in_array($current_page, $public_pages)) {
    requireLogin();
}
?>
<!DOCTYPE html>
<html lang="en" class="<?php echo $darkClass; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $app_name; ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php if (!in_array($current_page, $public_pages)): ?>
    <div class="layout">
        <!-- Sidebar Navigation -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-logo">
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=prison" alt="PVMS Logo">
                <h1>PVMS</h1>
            </div>
            
            <div class="sidebar-user">
                <p>Logged in as:</p>
                <p><?php echo $_SESSION['username']; ?></p>
            </div>
            
            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="index.php" class="<?php echo $current_page === 'index.php' ? 'active' : ''; ?>">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="visits.php" class="<?php echo $current_page === 'visits.php' ? 'active' : ''; ?>">
                            <i class="fas fa-clock"></i>
                            <span>Visitors Log</span>
                        </a>
                    </li>
                    <li>
                        <a href="add_visitor.php" class="<?php echo $current_page === 'add_visitor.php' ? 'active' : ''; ?>">
                            <i class="fas fa-user-plus"></i>
                            <span>Add New Visitor</span>
                        </a>
                    </li>
                    <li>
                        <a href="prisoners.php" class="<?php echo $current_page === 'prisoners.php' ? 'active' : ''; ?>">
                            <i class="fas fa-users"></i>
                            <span>Prisoners List</span>
                        </a>
                    </li>
                    <li>
                        <a href="add_prisoner.php" class="<?php echo $current_page === 'add_prisoner.php' ? 'active' : ''; ?>">
                            <i class="fas fa-user-plus"></i>
                            <span>Add New Prisoner</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-footer">
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <div class="dark-mode-toggle" id="darkModeToggle">
                    <div class="dark-mode-toggle-left">
                        <i class="fas <?php echo $darkMode ? 'fa-sun' : 'fa-moon'; ?>"></i>
                        <span>Dark Mode</span>
                    </div>
                    <div class="toggle-switch <?php echo $darkMode ? 'active' : ''; ?>"></div>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu toggle -->
        <div class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </div>
        
        <!-- Main Content Area -->
        <div class="main-content">
<?php endif; ?>