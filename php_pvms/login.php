<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$error = '';

// Process login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password';
    } else {
        if (authenticateUser($username, $password)) {
            header("Location: index.php");
            exit;
        } else {
            $error = 'Invalid username or password';
        }
    }
}

require_once 'includes/header.php';
?>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">
                <i class="fas fa-lock fa-2x"></i>
            </div>
            <h1 class="login-title">Prison Visitor Management System</h1>
            <p class="login-description">Enter your credentials to access the admin dashboard</p>
        </div>
        
        <form class="login-form" method="POST" action="" data-validate>
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-user text-gray-500"></i>
                    </span>
                    <input type="text" id="username" name="username" class="form-control pl-10" value="admin" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-lock text-gray-500"></i>
                    </span>
                    <input type="password" id="password" name="password" class="form-control pl-10" value="admin123" required>
                </div>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary w-full">Login</button>
            </div>
        </form>
        
        <div class="login-footer">
            <p>Demo credentials: admin / admin123</p>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>