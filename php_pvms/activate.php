<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$error = '';
$success = '';

// Process activation form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Combine the code digits
    $digits = $_POST['code'] ?? [];
    $activation_code = implode('', $digits);
    
    if (strlen($activation_code) !== 6) {
        $error = 'Please enter a valid 6-digit activation code';
    } else {
        // Try to activate the visit
        if (activateVisit($activation_code)) {
            $success = 'Visit activated successfully! Please proceed to the reception desk.';
        } else {
            $error = 'Invalid or expired activation code. Please check and try again.';
        }
    }
}

require_once 'includes/header.php';
?>

<div class="activation-container">
    <div class="activation-card">
        <div class="activation-logo">
            <i class="fas fa-key fa-2x"></i>
        </div>
        <h1 class="activation-title">Visitor Self-Activation</h1>
        <p class="activation-description">Enter the 6-digit activation code you received when your visit was scheduled</p>
        
        <?php if ($error): ?>
            <div class="alert alert-error mb-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success mb-4">
                <?php echo $success; ?>
            </div>
        <?php else: ?>
            <form method="POST" action="">
                <div class="activation-code">
                    <?php for ($i = 0; $i < 6; $i++): ?>
                        <input type="text" name="code[]" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                    <?php endfor; ?>
                </div>
                
                <button type="submit" class="btn btn-primary w-full">Activate Visit</button>
            </form>
        <?php endif; ?>
        
        <p class="mt-4 text-sm text-gray-500">
            If you don't have an activation code, please contact the prison administration office.
        </p>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>