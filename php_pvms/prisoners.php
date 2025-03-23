<?php
$page_title = "Prisoners Management";
require_once 'includes/header.php';

// Get prisoners with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $_GET['search'] : null;

$prisoners = getPrisoners($limit, $offset, $search);

// Get total count for pagination
$total_prisoners = count(getPrisoners(null, 0, $search));
$total_pages = ceil($total_prisoners / $limit);
?>

<div class="page-header">
    <div class="page-header-icon">
        <i class="fas fa-user-lock"></i>
    </div>
    <h1>Prisoners Management</h1>
</div>

<div class="card mb-6">
    <div class="card-header">
        <div class="flex justify-between items-center">
            <h2 class="card-title">All Prisoners</h2>
            <a href="add_prisoner.php" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span>Add Prisoner</span>
            </a>
        </div>
    </div>
    
    <div class="card-content">
        <!-- Search Form -->
        <form action="" method="get" class="mb-4">
            <div class="flex gap-2">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-500"></i>
                    </span>
                    <input type="text" name="search" class="form-control pl-10" placeholder="Search prisoners..." value="<?php echo htmlspecialchars($search ?? ''); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
                <?php if ($search): ?>
                    <a href="prisoners.php" class="btn btn-outline">Clear</a>
                <?php endif; ?>
            </div>
        </form>
        
        <!-- Prisoners Table -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Cell Location</th>
                        <th>Sentence</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($prisoners)): ?>
                        <tr>
                            <td colspan="6" class="text-center">No prisoners found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($prisoners as $prisoner): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($prisoner['inmate_id']); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($prisoner['first_name'] . ' ' . $prisoner['last_name']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($prisoner['cell_block'] . ' - ' . $prisoner['cell_number']); ?>
                                </td>
                                <td>
                                    <div>From: <?php echo formatDate($prisoner['sentence_start']); ?></div>
                                    <?php if ($prisoner['sentence_end']): ?>
                                        <div>To: <?php echo formatDate($prisoner['sentence_end']); ?></div>
                                    <?php else: ?>
                                        <div>To: Life Sentence</div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo generateStatusBadge($prisoner['status']); ?>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="view_prisoner.php?id=<?php echo $prisoner['id']; ?>" class="btn btn-sm btn-ghost" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="edit_prisoner.php?id=<?php echo $prisoner['id']; ?>" class="btn btn-sm btn-ghost" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="prisoner_visitors.php?id=<?php echo $prisoner['id']; ?>" class="btn btn-sm btn-ghost" title="Visitors">
                                            <i class="fas fa-users"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="flex justify-between items-center mt-4">
                <div>
                    Showing <?php echo $offset + 1; ?> to <?php echo min($offset + $limit, $total_prisoners); ?> of <?php echo $total_prisoners; ?> prisoners
                </div>
                <div class="flex gap-2">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="btn btn-sm btn-outline">
                            <i class="fas fa-chevron-left"></i>
                            Previous
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="btn btn-sm btn-outline">
                            Next
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>