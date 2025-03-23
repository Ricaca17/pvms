<?php
$page_title = "Add Prisoner";
require_once 'includes/header.php';

$errors = [];
$success = false;

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate inputs
    $inmate_id = trim($_POST['inmate_id'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $cell_block = trim($_POST['cell_block'] ?? '');
    $cell_number = trim($_POST['cell_number'] ?? '');
    $sentence_start = trim($_POST['sentence_start'] ?? '');
    $sentence_end = trim($_POST['sentence_end'] ?? '');
    $offense = trim($_POST['offense'] ?? '');
    $status = $_POST['status'] ?? 'Active';
    $photo = ''; // Photo upload would be handled separately
    
    // Validation
    if (empty($inmate_id)) {
        $errors[] = "Inmate ID is required.";
    }
    
    if (empty($first_name)) {
        $errors[] = "First name is required.";
    }
    
    if (empty($last_name)) {
        $errors[] = "Last name is required.";
    }
    
    if (empty($dob)) {
        $errors[] = "Date of birth is required.";
    }
    
    if (empty($gender)) {
        $errors[] = "Gender is required.";
    }
    
    if (empty($cell_block)) {
        $errors[] = "Cell block is required.";
    }
    
    if (empty($cell_number)) {
        $errors[] = "Cell number is required.";
    }
    
    if (empty($sentence_start)) {
        $errors[] = "Sentence start date is required.";
    }
    
    if (empty($offense)) {
        $errors[] = "Offense is required.";
    }
    
    // If no errors, add prisoner
    if (empty($errors)) {
        $prisoner_data = [
            'inmate_id' => $inmate_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'dob' => $dob,
            'gender' => $gender,
            'cell_block' => $cell_block,
            'cell_number' => $cell_number,
            'sentence_start' => $sentence_start,
            'sentence_end' => $sentence_end ?: null,
            'offense' => $offense,
            'status' => $status,
            'photo' => $photo
        ];
        
        $prisoner_id = addPrisoner($prisoner_data);
        
        if ($prisoner_id) {
            $success = true;
        } else {
            $errors[] = "Failed to add prisoner. Please try again.";
        }
    }
}
?>

<div class="page-header">
    <div class="page-header-icon">
        <i class="fas fa-user-plus"></i>
    </div>
    <h1>Add New Prisoner</h1>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Prisoner Information</h2>
        <p class="card-description">Enter the details of the new prisoner</p>
    </div>
    
    <div class="card-content">
        <?php if ($success): ?>
            <div class="alert alert-success mb-4">
                <i class="fas fa-check-circle"></i>
                <span>Prisoner added successfully!</span>
            </div>
            
            <div class="flex justify-between">
                <a href="add_prisoner.php" class="btn btn-outline">Add Another Prisoner</a>
                <a href="prisoners.php" class="btn btn-primary">View All Prisoners</a>
            </div>
        <?php else: ?>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger mb-4">
                    <ul class="list-disc pl-5">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form method="post" action="">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="inmate_id" class="form-label">Inmate ID</label>
                        <input type="text" id="inmate_id" name="inmate_id" class="form-control" value="<?php echo htmlspecialchars($_POST['inmate_id'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" id="dob" name="dob" class="form-control" value="<?php echo htmlspecialchars($_POST['dob'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="gender" class="form-label">Gender</label>
                        <select id="gender" name="gender" class="form-select" required>
                            <option value="" disabled <?php echo !isset($_POST['gender']) ? 'selected' : ''; ?>>Select Gender</option>
                            <option value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="cell_block" class="form-label">Cell Block</label>
                        <input type="text" id="cell_block" name="cell_block" class="form-control" value="<?php echo htmlspecialchars($_POST['cell_block'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="cell_number" class="form-label">Cell Number</label>
                        <input type="text" id="cell_number" name="cell_number" class="form-control" value="<?php echo htmlspecialchars($_POST['cell_number'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="sentence_start" class="form-label">Sentence Start Date</label>
                        <input type="date" id="sentence_start" name="sentence_start" class="form-control" value="<?php echo htmlspecialchars($_POST['sentence_start'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="sentence_end" class="form-label">Sentence End Date (Leave blank for life sentence)</label>
                        <input type="date" id="sentence_end" name="sentence_end" class="form-control" value="<?php echo htmlspecialchars($_POST['sentence_end'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group col-span-2">
                        <label for="offense" class="form-label">Offense</label>
                        <textarea id="offense" name="offense" class="form-control" rows="3" required><?php echo htmlspecialchars($_POST['offense'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select">
                            <option value="Active" <?php echo (!isset($_POST['status']) || $_POST['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                            <option value="Released" <?php echo (isset($_POST['status']) && $_POST['status'] == 'Released') ? 'selected' : ''; ?>>Released</option>
                            <option value="Transferred" <?php echo (isset($_POST['status']) && $_POST['status'] == 'Transferred') ? 'selected' : ''; ?>>Transferred</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group mt-4 flex justify-end gap-2">
                    <a href="prisoners.php" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary">Add Prisoner</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>