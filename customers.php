<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers<?php echo APP_TITLE_SUFFIX; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="app-container">
        <?php /* Sidebar disabled but kept for future use: include __DIR__ . '/includes/sidebar.php'; */ ?>
        <main class="main-content">
            <?php include __DIR__ . '/includes/header.php'; ?>
            <div class="page-content">
                <?php
                // Module-local table configuration
                $CUSTOMER_TABLE_COLUMNS = [
                    ['key' => 'name',   'label' => 'Name'],
                    ['key' => 'email',  'label' => 'Email'],
                    ['key' => 'phone',  'label' => 'Phone'],
                    ['key' => 'status', 'label' => 'Status'],
                    ['key' => 'revenue', 'label' => 'Revenue'],
                ];

                $CUSTOMER_TABLE_SHOW_ACTIONS = true;

                $STATUS_TO_BADGE_CLASS = [
                    'Active'   => 'badge--success',
                    'Pending'  => 'badge--warning',
                    'Inactive' => 'badge--danger',
                ];

                $CUSTOMERS = [
                    [
                        'name' => 'Jane Cooper',
                        'email' => 'jane.cooper@example.com',
                        'phone' => '+1 222 333 4444',
                        'status' => 'Active',
                        'revenue' => 'PKR 45,890',
                    ],
                    [
                        'name' => 'Jacob Jones',
                        'email' => 'jacob.jones@example.com',
                        'phone' => '+1 555 666 7777',
                        'status' => 'Pending',
                        'revenue' => 'PKR 32,150',
                    ],
                ];
                ?>
                <div class="card">
                    <div class="card__header page-card-header">
                        <div class="card__title-container">
                            <h3 class="card__title"><i class="fas fa-users" style="margin-right: var(--spacing-sm); color: var(--color-primary-light);"></i>Customer List</h3>
                            <div class="d-flex align-items-center" style="gap: var(--spacing-sm);">
                                <button class="btn btn--primary"><i class="fas fa-plus"></i> Add Customer</button>
                            </div>
                        </div>
                        <div class="filter-bar d-none d-md-flex align-items-center">
                            <form id="customerFilterForm" class="d-flex align-items-center" onsubmit="return false;" style="gap: var(--spacing-sm);">
                                <div class="filter-input-container">
                                    <input type="text" class="form-control form-control-md" id="filterQuery" placeholder="Search name">
                                    <input type="email" class="form-control form-control-md" id="filterEmail" placeholder="Email">
                                    <input type="text" class="form-control form-control-md" id="filterPhone" placeholder="Phone">
                                    <select id="filterStatus" class="form-select form-select-md" aria-label="Filter status">
                                        <option value="">All Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                    <button type="button" class="btn btn-sm btn--secondary" id="applyCustomerFilter"><i class="fas fa-filter"></i></button>
                                    <button type="button" class="btn btn-sm btn--secondary" id="clearCustomerFilter"><i class="fas fa-times"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <?php foreach ($CUSTOMER_TABLE_COLUMNS as $col): ?>
                                        <th><?php echo htmlspecialchars($col['label']); ?></th>
                                    <?php endforeach; ?>
                                    <?php if ($CUSTOMER_TABLE_SHOW_ACTIONS): ?>
                                        <th>Actions</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($CUSTOMERS as $idx => $customer): ?>
                                    <tr>
                                        <?php foreach ($CUSTOMER_TABLE_COLUMNS as $col): ?>
                                            <td>
                                                <?php if ($col['key'] === 'status'):
                                                    $status = $customer['status'];
                                                    $badge = $STATUS_TO_BADGE_CLASS[$status] ?? 'badge--primary';
                                                ?>
                                                    <span class="badge <?php echo $badge; ?>"><?php echo htmlspecialchars($status); ?></span>
                                                <?php else: ?>
                                                    <?php echo htmlspecialchars($customer[$col['key']] ?? ''); ?>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; ?>
                                        <?php if ($CUSTOMER_TABLE_SHOW_ACTIONS): ?>
                                            <td>
                                                <button class="btn btn-sm btn--secondary"><i class="fas fa-eye"></i></button>
                                                <button
                                                    class="btn btn-sm btn--secondary edit-customer-btn"
                                                    data-index="<?php echo (int)$idx; ?>"
                                                    data-name="<?php echo htmlspecialchars($customer['name']); ?>"
                                                    data-email="<?php echo htmlspecialchars($customer['email']); ?>"
                                                    data-phone="<?php echo htmlspecialchars($customer['phone']); ?>"
                                                    data-status="<?php echo htmlspecialchars($customer['status']); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Customer Modal -->
                <div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="customerModalTitle">Add Customer</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="customerForm">
                                    <input type="hidden" id="customerIndex" name="index" value="">
                                    <div class="row g-3">
                                        <!-- 1. Text Input -->
                                        <div class="col-12 col-md-4">
                                            <label for="customerName" class="form-label">Full Name</label>
                                            <input type="text" class="form-control form-control-sm" id="customerName" name="name" required>
                                        </div>

                                        <!-- 2. Dropdown (Select) -->
                                        <div class="col-12 col-md-4">
                                            <label for="customerStatus" class="form-label">Status</label>
                                            <select class="form-select form-select-sm" id="customerStatus" name="status" required>
                                                <option value="">Select Status</option>
                                                <option value="Active">Active</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>

                                        <!-- 3. Email Input -->
                                        <div class="col-12 col-md-4">
                                            <label for="customerEmail" class="form-label">Email Address</label>
                                            <input type="email" class="form-control form-control-sm" id="customerEmail" name="email" required>
                                        </div>

                                        <!-- 4. Number Input -->
                                        <div class="col-12 col-md-4">
                                            <label for="customerAge" class="form-label">Age</label>
                                            <input type="number" class="form-control form-control-sm" id="customerAge" name="age" min="1" max="120">
                                        </div>

                                        <!-- 5. Date Input -->
                                        <div class="col-12 col-md-4">
                                            <label for="customerBirthDate" class="form-label">Birth Date</label>
                                            <input type="date" class="form-control form-control-sm" id="customerBirthDate" name="birth_date">
                                        </div>

                                        <!-- 6. File Input -->
                                        <div class="col-12 col-md-4">
                                            <label for="customerPhoto" class="form-label">Profile Photo</label>
                                            <input type="file" class="form-control form-control-sm" id="customerPhoto" name="photo" accept="image/*">
                                        </div>

                                        <!-- 7. Textarea -->
                                        <div class="col-12">
                                            <label for="customerNotes" class="form-label">Notes</label>
                                            <textarea class="form-control form-control-sm" id="customerNotes" name="notes" rows="3" placeholder="Additional notes about the customer..."></textarea>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" form="customerForm">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer View Detail Modal -->
                <div class="modal fade" id="customerViewModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="modal-title-container">
                                    <div class="modal-avatar">
                                        <div class="avatar-placeholder" id="customerViewModalAvatar">JD</div>
                                    </div>
                                    <h5 class="modal-title" id="customerViewModalTitle">Customer Details</h5>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">


                                    <!-- All Data Fields in Single Section -->
                                    <div class="col-12">
                                        <div class="info-section">
                                            <h6 class="info-section-title">
                                                <i class="fas fa-user"></i>
                                                Customer Information
                                            </h6>
                                            <div class="info-items-grid">
                                                <div class="info-item">
                                                    <label>Email</label>
                                                    <span id="customerViewEmail">john.doe@example.com</span>
                                                </div>
                                                <div class="info-item">
                                                    <label>Phone</label>
                                                    <span id="customerViewPhone">+1 (555) 123-4567</span>
                                                </div>
                                                <div class="info-item">
                                                    <label>Age</label>
                                                    <span id="customerViewAge">28</span>
                                                </div>
                                                <div class="info-item">
                                                    <label>Birth Date</label>
                                                    <span id="customerViewBirthDate">1995-03-15</span>
                                                </div>
                                                <div class="info-item">
                                                    <label>Status</label>
                                                    <span class="status-badge" id="customerViewStatusDetail">Active</span>
                                                </div>
                                                <div class="info-item">
                                                    <label>Revenue</label>
                                                    <span class="revenue-amount" id="customerViewRevenue">PKR 45,890</span>
                                                </div>
                                                <div class="info-item">
                                                    <label>Registration Date</label>
                                                    <span id="customerViewRegDate">2023-01-15</span>
                                                </div>
                                                <div class="info-item">
                                                    <label>Last Contact</label>
                                                    <span id="customerViewLastContact">2024-01-20</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Notes Section -->
                                    <div class="col-12">
                                        <div class="info-section">
                                            <h6 class="info-section-title">
                                                <i class="fas fa-sticky-note"></i>
                                                Notes
                                            </h6>
                                            <div class="notes-content" id="customerViewNotes">
                                                <p>Additional notes about the customer will appear here. This section can contain important information, preferences, or any other relevant details.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="editCustomerFromView">
                                    <i class="fas fa-edit"></i>
                                    Edit Customer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>