<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
requireLogin();

$visitors = getAllVisitors();

// Handle visitor deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = $_GET['delete'];
    if (deleteVisitor($id)) {
        header("Location: visitors.php?success=1");
        exit;
    } else {
        header("Location: visitors.php?error=1");
        exit;
    }
}

require_once 'includes/header.php';
?>

<div class="page-header">
    <div class="page-header-icon bg-blue-100">
        <i class="fas fa-users text-blue-600"></i>
    </div>
    <h1>Registered Visitors</h1>
</div>

<div class="space-y-6">
    <!-- Header with search and actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="relative w-full sm:w-64">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search text-gray-500"></i>
            </span>
            <input type="text" id="searchVisitors" placeholder="Search visitors..." class="form-control pl-10">
        </div>
        <div class="flex gap-2 w-full sm:w-auto">
            <a href="add_visitor.php" class="btn btn-primary">
                <i class="fas fa-user-plus mr-2"></i>
                Add New Visitor
            </a>
        </div>
    </div>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            Visitor deleted successfully!
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error">
            An error occurred while deleting the visitor.
        </div>
    <?php endif; ?>
    
    <!-- Visitors table -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>ID Type</th>
                    <th>ID Number</th>
                    <th>Relationship</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($visitors)): ?>
                    <tr>
                        <td colspan="8" class="text-center py-8 text-gray-500">
                            No visitors found
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($visitors as $visitor): ?>
                        <tr class="visitor-row">
                            <td><?php echo htmlspecialchars($visitor['id']); ?></td>
                            <td class="font-medium">
                                <?php echo htmlspecialchars($visitor['first_name'] . ' ' . $visitor['last_name']); ?>
                            </td>
                            <td><?php echo ucfirst(htmlspecialchars($visitor['id_type'])); ?></td>
                            <td><?php echo htmlspecialchars($visitor['id_number']); ?></td>
                            <td><?php echo ucfirst(htmlspecialchars($visitor['relationship'])); ?></td>
                            <td><?php echo htmlspecialchars($visitor['phone']); ?></td>
                            <td><?php echo htmlspecialchars($visitor['email'] ?? 'N/A'); ?></td>
                            <td class="text-right">
                                <div class="table-actions">
                                    <a href="add_visitor.php?edit=<?php echo $visitor['id']; ?>" class="btn btn-ghost btn-icon">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="visitors.php?delete=<?php echo $visitor['id']; ?>" class="btn btn-ghost btn-icon" onclick="return confirm('Are you sure you want to delete this visitor?')">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchVisitors');
        const visitorRows = document.querySelectorAll('.visitor-row');
        
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            
            visitorRows.forEach(row => {
                const visitorName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const idNumber = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                
                if (visitorName.includes(searchTerm) || idNumber.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>

<?php require_once 'includes/footer.php'; ?>