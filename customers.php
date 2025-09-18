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
                ];

                $CUSTOMER_TABLE_SHOW_ACTIONS = true;

                $STATUS_TO_BADGE_CLASS = [
                    'Active'   => 'badge-success',
                    'Pending'  => 'badge-warning',
                    'Inactive' => 'badge-danger',
                ];

                $CUSTOMERS = [
                    [
                        'name' => 'Jane Cooper',
                        'email' => 'jane.cooper@example.com',
                        'phone' => '+1 222 333 4444',
                        'status' => 'Active',
                    ],
                    [
                        'name' => 'Jacob Jones',
                        'email' => 'jacob.jones@example.com',
                        'phone' => '+1 555 666 7777',
                        'status' => 'Pending',
                    ],
                ];
                ?>
                <div class="card-custom">
                    <div class="card-header-custom page-card-header">
                        <div class="card-title-container">
                            <h3 class="card-title"><i class="fas fa-users" style="margin-right: var(--spacing-sm); color: var(--color-primary-light);"></i>Customer List</h3>
                            <div class="d-flex align-items-center" style="gap: var(--spacing-sm);">
                                <button class="btn-custom btn-primary-custom"><i class="fas fa-plus"></i> Add Customer</button>
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
                                </div>
                                <div class="filter-btn-container">
                                    <button type="button" class="btn-custom btn-md btn-secondary-custom" id="clearCustomerFilter">Clear</button>
                                    <button type="button" class="btn-custom btn-md btn-secondary-custom" id="applyCustomerFilter"><i class="fas fa-filter"></i> Apply</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive-custom">
                        <table class="table-custom">
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
                                                    $badge = $STATUS_TO_BADGE_CLASS[$status] ?? 'badge-primary';
                                                ?>
                                                    <span class="badge-custom <?php echo $badge; ?>"><?php echo htmlspecialchars($status); ?></span>
                                                <?php else: ?>
                                                    <?php echo htmlspecialchars($customer[$col['key']] ?? ''); ?>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; ?>
                                        <?php if ($CUSTOMER_TABLE_SHOW_ACTIONS): ?>
                                            <td>
                                                <button class="btn-custom btn-sm btn-secondary-custom"><i class="fas fa-eye"></i></button>
                                                <button
                                                    class="btn-custom btn-sm btn-secondary-custom edit-customer-btn"
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
                                    <div class="row g-2">
                                        <div class="col-12 col-md-6">
                                            <label for="customerName" class="form-label">Name</label>
                                            <input type="text" class="form-control form-control-sm" id="customerName" name="name" required>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="customerEmail" class="form-label">Email</label>
                                            <input type="email" class="form-control form-control-sm" id="customerEmail" name="email" required>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="customerPhone" class="form-label">Phone</label>
                                            <input type="text" class="form-control form-control-sm" id="customerPhone" name="phone" required>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="customerStatus" class="form-label">Status</label>
                                            <select class="form-select form-select-sm" id="customerStatus" name="status" required>
                                                <option value="Active">Active</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
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
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>