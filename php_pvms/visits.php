<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
requireLogin();

// Get all visits
$visits = getAllVisits();

// Handle visit status updates
if (isset($_GET['complete']) && is_numeric($_GET['complete'])) {
    $id = $_GET['complete'];
    if (completeVisit($id)) {
        header("Location: visits.php?success=completed");
        exit;
    }
}

if (isset($_GET['cancel']) && is_numeric($_GET['cancel'])) {
    $id = $_GET['cancel'];
    if (cancelVisit($id)) {
        header("Location: visits.php?success=cancelled");
        exit;
    }
}

// Handle visit deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM visits WHERE id = ?");
    if ($stmt->execute([$id])) {
        header("Location: visits.php?success=deleted");
        exit;
    }
}

// Handle new visit form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_visit'])) {
    $visitData = [
        'visitor_id' => $_POST['visitor_id'],
        'prisoner_id' => $_POST['prisoner_id'],
        'visit_purpose' => $_POST['visit_purpose'],
        'visit_date' => $_POST['visit_date'],
        'visit_time' => $_POST['visit_time']
    ];
    
    if (addVisit($visitData)) {
        header("Location: visits.php?success=added");
        exit;
    } else {
        $error = "Failed to add visit";
    }
}

// Get all visitors and prisoners for the form
$allVisitors = getAllVisitors();
$allPrisoners = getAllPrisoners();

require_once 'includes/header.php';
?>

<div class="page-header">
    <div class="page-header-icon bg-blue-100">
        <i class="fas fa-clock text-blue-600"></i>
    </div>
    <h1>Visitors Log</h1>
</div>

<div class="space-y-6">
    <!-- Header with search and actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="relative w-full sm:w-64">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search text-gray-500"></i>
            </span>
            <input type="text" id="searchVisits" placeholder="Search visitors or prisoners..." class="form-control pl-10">
        </div>
        <div class="flex flex-wrap gap-2 w-full sm:w-auto">
            <select id="statusFilter" class="form-select w-[180px]">
                <option value="all">All Statuses</option>
                <option value="Scheduled">Scheduled</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
            </select>
            <button type="button" class="btn btn-outline" id="dateFilterBtn">
                <i class="fas fa-calendar mr-2"></i>
                Date
            </button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addVisitModal">
                <i class="fas fa-user-plus mr-2"></i>
                New Visit
            </button>
        </div>
    </div>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php 
            $message = '';
            switch ($_GET['success']) {
                case 'added':
                    $message = 'Visit scheduled successfully!';
                    break;
                case 'completed':
                    $message = 'Visit marked as completed!';
                    break;
                case 'cancelled':
                    $message = 'Visit cancelled successfully!';
                    break;
                case 'deleted':
                    $message = 'Visit deleted successfully!';
                    break;
            }
            echo $message;
            ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-error">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <!-- Visits table -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Visitor</th>
                    <th>Prisoner</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Purpose</th>
                    <th>Activation Code</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($visits)): ?>
                    <tr>
                        <td colspan="9" class="text-center py-8 text-gray-500">
                            No visits found
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($visits as $visit): ?>
                        <tr class="visit-row" data-status="<?php echo $visit['status']; ?>" data-date="<?php echo $visit['visit_date']; ?>">
                            <td class="font-medium"><?php echo htmlspecialchars($visit['visitor_name']); ?></td>
                            <td><?php echo htmlspecialchars($visit['prisoner_name']); ?></td>
                            <td>
                                <?php 
                                $visitDate = new DateTime($visit['visit_date']);
                                $today = new DateTime();
                                $tomorrow = new DateTime('tomorrow');
                                $yesterday = new DateTime('yesterday');
                                
                                if ($visitDate->format('Y-m-d') === $today->format('Y-m-d')) {
                                    echo 'Today';
                                } elseif ($visitDate->format('Y-m-d') === $tomorrow->format('Y-m-d')) {
                                    echo 'Tomorrow';
                                } elseif ($visitDate->format('Y-m-d') === $yesterday->format('Y-m-d')) {
                                    echo 'Yesterday';
                                } else {
                                    echo formatDate($visit['visit_date']);
                                }
                                ?>
                            </td>
                            <td><?php echo formatTime($visit['visit_time']); ?></td>
                            <td><?php echo calculateDuration($visit['entry_time'], $visit['exit_time']); ?></td>
                            <td>
                                <span class="badge badge-outline <?php echo getStatusBadgeClass($visit['status']); ?>">
                                    <?php echo $visit['status']; ?>
                                </span>
                            </td>
                            <td><?php echo ucfirst($visit['visit_purpose']); ?></td>
                            <td>
                                <?php if ($visit['status'] === 'Scheduled'): ?>
                                    <span class="font-mono"><?php echo $visit['activation_code']; ?></span>
                                <?php else: ?>
                                    <span class="text-gray-500">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-right">
                                <div class="table-actions">
                                    <?php if ($visit['status'] === 'Scheduled'): ?>
                                        <a href="visits.php?complete=<?php echo $visit['id']; ?>" class="btn btn-ghost btn-icon" title="Mark as Completed">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="visits.php?cancel=<?php echo $visit['id']; ?>" class="btn btn-ghost btn-icon" title="Cancel Visit" onclick="return confirm('Are you sure you want to cancel this visit?')">
                                            <i class="fas fa-ban"></i>
                                        </a>
                                    <?php elseif ($visit['status'] === 'In Progress'): ?>
                                        <a href="visits.php?complete=<?php echo $visit['id']; ?>" class="btn btn-ghost btn-icon" title="Complete Visit">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="visits.php?delete=<?php echo $visit['id']; ?>" class="btn btn-ghost btn-icon" title="Delete Visit" onclick="return confirm('Are you sure you want to delete this visit?')">
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

<!-- Add Visit Modal -->
<div id="addVisitModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Schedule New Visit</h2>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <form method="POST" action="" data-validate>
                <div class="form-group">
                    <label for="visitor_id" class="form-label">Visitor *</label>
                    <select id="visitor_id" name="visitor_id" class="form-select" required>
                        <option value="">Select Visitor</option>
                        <?php foreach ($allVisitors as $visitor): ?>
                            <option value="<?php echo $visitor['id']; ?>">
                                <?php echo htmlspecialchars($visitor['first_name'] . ' ' . $visitor['last_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="prisoner_id" class="form-label">Prisoner *</label>
                    <select id="prisoner_id" name="prisoner_id" class="form-select" required>
                        <option value="">Select Prisoner</option>
                        <?php foreach ($allPrisoners as $prisoner): ?>
                            <option value="<?php echo $prisoner['id']; ?>">
                                <?php echo htmlspecialchars($prisoner['first_name'] . ' ' . $prisoner['last_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="visit_purpose" class="form-label">Visit Purpose *</label>
                    <select id="visit_purpose" name="visit_purpose" class="form-select" required>
                        <option value="family">Family Visit</option>
                        <option value="legal">Legal Consultation</option>
                        <option value="social">Social Visit</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="visit_date" class="form-label">Visit Date *</label>
                        <input type="date" id="visit_date" name="visit_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="visit_time" class="form-label">Visit Time *</label>
                        <input type="time" id="visit_time" name="visit_time" class="form-control" required>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-2 mt-6">
                    <button type="button" class="btn btn-outline" id="cancelAddVisit">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </button>
                    <button type="submit" name="add_visit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        Schedule Visit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 100;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: white;
    margin: 10% auto;
    padding: 0;
    border-radius: 0.5rem;
    width: 90%;
    max-width: 600px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.dark .modal-content {
    background-color: var(--gray-800);
    border: 1px solid var(--gray-700);
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--gray-200);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.dark .modal-header {
    border-bottom: 1px solid var(--gray-700);
}

.modal-header h2 {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
}

.modal-body {
    padding: 1.5rem;
}

.close {
    color: var(--gray-500);
    font-size: 1.5rem;
    font-weight: bold;
    cursor: pointer;
}

.close:hover {
    color: var(--gray-700);
}

.dark .close:hover {
    color: var(--gray-300);
}

/* Alert Styles */
.alert {
    padding: 1rem;
    border-radius: 0.375rem;
    margin-bottom: 1rem;
}

.alert-success {
    background-color: #d1fae5;
    color: #047857;
    border: 1px solid #a7f3d0;
}

.alert-error {
    background-color: #fee2e2;
    color: #b91c1c;
    border: 1px solid #fecaca;
}

.dark .alert-success {
    background-color: rgba(6, 78, 59, 0.5);
    color: #34d399;
    border-color: #065f46;
}

.dark .alert-error {
    background-color: rgba(127, 29, 29, 0.5);
    color: #f87171;
    border-color: #991b1b;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('searchVisits');
        const visitRows = document.querySelectorAll('.visit-row');
        
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            filterVisits();
        });
        
        // Status filter
        const statusFilter = document.getElementById('statusFilter');
        statusFilter.addEventListener('change', function() {
            filterVisits();
        });
        
        // Date filter
        const dateFilterBtn = document.getElementById('dateFilterBtn');
        dateFilterBtn.addEventListener('click', function() {
            const today = new Date().toISOString().split('T')[0];
            const dateInput = prompt('Enter date (YYYY-MM-DD):', today);
            
            if (dateInput) {
                filterVisits(dateInput);
            }
        });
        
        function filterVisits(dateFilter = null) {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;
            
            visitRows.forEach(row => {
                const visitorName = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const prisonerName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const rowStatus = row.getAttribute('data-status');
                const rowDate = row.getAttribute('data-date');
                
                const matchesSearch = visitorName.includes(searchTerm) || prisonerName.includes(searchTerm);
                const matchesStatus = statusValue === 'all' || rowStatus === statusValue;
                const matchesDate = !dateFilter || rowDate === dateFilter;
                
                if (matchesSearch && matchesStatus && matchesDate) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        // Modal functionality
        const modal = document.getElementById('addVisitModal');
        const modalTrigger = document.querySelector('[data-toggle="modal"]');
        const closeBtn = document.querySelector('.close');
        const cancelBtn = document.getElementById('cancelAddVisit');
        
        modalTrigger.addEventListener('click', function() {
            modal.style.display = 'block';
        });
        
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
        
        cancelBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
        
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
</script>

<?php require_once 'includes/footer.php'; ?>