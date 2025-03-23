<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
requireLogin();

$pageTitle = 'Add New Visitor';
$formAction = '';
$visitor = [
    'first_name' => '',
    'last_name' => '',
    'id_type' => 'national',
    'id_number' => '',
    'relationship' => 'family',
    'phone' => '',
    'email' => '',
    'address' => ''
];

// Check if editing an existing visitor
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $visitorId = $_GET['edit'];
    $existingVisitor = getVisitorById($visitorId);
    
    if ($existingVisitor) {
        $pageTitle = 'Edit Visitor';
        $formAction = '?edit=' . $visitorId;
        $visitor = $existingVisitor;
    }
}

$error = '';
$success = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $required_fields = ['first_name', 'last_name', 'id_type', 'id_number', 'relationship', 'phone'];
    $missing_fields = [];
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $missing_fields[] = ucwords(str_replace('_', ' ', $field));
        }
    }
    
    if (!empty($missing_fields)) {
        $error = 'Please fill in the following fields: ' . implode(', ', $missing_fields);
    } else {
        // Prepare visitor data
        $visitorData = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'id_type' => $_POST['id_type'],
            'id_number' => $_POST['id_number'],
            'relationship' => $_POST['relationship'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'] ?? '',
            'address' => $_POST['address'] ?? ''
        ];
        
        // Update or add visitor
        if (isset($_GET['edit'])) {
            if (updateVisitor($visitorId, $visitorData)) {
                $success = 'Visitor updated successfully!';
                $visitor = getVisitorById($visitorId); // Refresh data
            } else {
                $error = 'An error occurred while updating the visitor.';
            }
        } else {
            if (addVisitor($visitorData)) {
                $success = 'Visitor added successfully!';
                // Clear form for new entry
                $visitor = [
                    'first_name' => '',
                    'last_name' => '',
                    'id_type' => 'national',
                    'id_number' => '',
                    'relationship' => 'family',
                    'phone' => '',
                    'email' => '',
                    'address' => ''
                ];
            } else {
                $error = 'An error occurred while adding the visitor.';
            }
        }
    }
}

require_once 'includes/header.php';
?>

<div class="page-header">
    <div class="page-header-icon bg-blue-100">
        <i class="fas fa-user-plus text-blue-600"></i>
    </div>
    <h1><?php echo $pageTitle; ?></h1>
</div>

<div class="max-w-4xl mx-auto">
    <?php if ($error): ?>
        <div class="alert alert-error mb-6">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success mb-6">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Visitor Information</h2>
        </div>
        <div class="card-content">
            <form method="POST" action="<?php echo $formAction; ?>" data-validate>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="first_name" class="form-label">First Name *</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo htmlspecialchars($visitor['first_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name" class="form-label">Last Name *</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo htmlspecialchars($visitor['last_name']); ?>" required>
                    </div>
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="id_type" class="form-label">ID Type *</label>
                        <select id="id_type" name="id_type" class="form-select" required>
                            <option value="national" <?php echo $visitor['id_type'] === 'national' ? 'selected' : ''; ?>>National ID</option>
                            <option value="drivers" <?php echo $visitor['id_type'] === 'drivers' ? 'selected' : ''; ?>>Driver's License</option>
                            <option value="passport" <?php echo $visitor['id_type'] === 'passport' ? 'selected' : ''; ?>>Passport</option>
                            <option value="other" <?php echo $visitor['id_type'] === 'other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="id_number" class="form-label">ID Number *</label>
                        <input type="text" id="id_number" name="id_number" class="form-control" value="<?php echo htmlspecialchars($visitor['id_number']); ?>" required>
                    </div>
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="relationship" class="form-label">Relationship to Prisoner *</label>
                        <select id="relationship" name="relationship" class="form-select" required>
                            <option value="family" <?php echo $visitor['relationship'] === 'family' ? 'selected' : ''; ?>>Family</option>
                            <option value="spouse" <?php echo $visitor['relationship'] === 'spouse' ? 'selected' : ''; ?>>Spouse</option>
                            <option value="legal" <?php echo $visitor['relationship'] === 'legal' ? 'selected' : ''; ?>>Legal Representative</option>
                            <option value="friend" <?php echo $visitor['relationship'] === 'friend' ? 'selected' : ''; ?>>Friend</option>
                            <option value="other" <?php echo $visitor['relationship'] === 'other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number *</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($visitor['phone']); ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($visitor['email'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="address" class="form-label">Address</label>
                    <textarea id="address" name="address" class="form-control" rows="3"><?php echo htmlspecialchars($visitor['address'] ?? ''); ?></textarea>
                </div>
                
                <div class="flex justify-end space-x-2 mt-6">
                    <a href="visitors.php" class="btn btn-outline">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        <?php echo isset($_GET['edit']) ? 'Update Visitor' : 'Save Visitor'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>