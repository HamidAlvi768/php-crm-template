<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard<?php echo APP_TITLE_SUFFIX; ?></title>
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
                <div class="page-header">
                    <h1 class="page-title">Dashboard</h1>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="stat">
                            <div class="stat__icon stat__icon--primary"><i class="fas fa-users"></i></div>
                            <div class="stat__content">
                                <div class="stat__label">Total Customers</div>
                                <div class="stat__value">8,543</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="stat">
                            <div class="stat__icon stat__icon--primary"><i class="fas fa-dollar-sign"></i></div>
                            <div class="stat__content">
                                <div class="stat__label">Revenue</div>
                                <div class="stat__value">PKR 245,890</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="stat">
                            <div class="stat__icon stat__icon--primary"><i class="fas fa-user-plus"></i></div>
                            <div class="stat__content">
                                <div class="stat__label">New Leads</div>
                                <div class="stat__value">324</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="stat">
                            <div class="stat__icon stat__icon--primary"><i class="fas fa-chart-line"></i></div>
                            <div class="stat__content">
                                <div class="stat__label">Conversion Rate</div>
                                <div class="stat__value">18.5%</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card__header dashboard-card-header">
                                <h3 class="card__title">Sales Overview</h3>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn--secondary" id="salesDayBtn">Day</button>
                                    <button class="btn btn-sm btn--primary" id="salesMonthBtn">Month</button>
                                    <button class="btn btn-sm btn--secondary" id="salesYearBtn">Year</button>
                                </div>
                            </div>
                            <div class="chart-container"><canvas id="salesChart"></canvas></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card__header">
                                <h3 class="card__title">Lead Sources</h3>
                            </div>
                            <div class="chart-container"><canvas id="leadSourceChart"></canvas></div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card__header dashboard-card-header">
                                <h3 class="card__title">Recent Customers</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Customer</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                                                    <div class="user-avatar" style="width: 30px; height: 30px; font-size: var(--font-size-xs);">JW</div>
                                                    <span>John Wilson</span>
                                                </div>
                                            </td>
                                            <td>john.wilson@email.com</td>
                                            <td>+1 234 567 8900</td>
                                            <td><span class="badge badge--success">Active</span></td>
                                            <td>PKR 45,890</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                                                    <div class="user-avatar" style="width: 30px; height: 30px; font-size: var(--font-size-xs);">SJ</div>
                                                    <span>Sarah Johnson</span>
                                                </div>
                                            </td>
                                            <td>sarah.j@company.com</td>
                                            <td>+1 234 567 8901</td>
                                            <td><span class="badge badge--warning">Pending</span></td>
                                            <td>PKR 12,340</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                                                    <div class="user-avatar" style="width: 30px; height: 30px; font-size: var(--font-size-xs);">MB</div>
                                                    <span>Michael Brown</span>
                                                </div>
                                            </td>
                                            <td>m.brown@business.org</td>
                                            <td>+1 234 567 8902</td>
                                            <td><span class="badge badge--success">Active</span></td>
                                            <td>PKR 78,950</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                                                    <div class="user-avatar" style="width: 30px; height: 30px; font-size: var(--font-size-xs);">ED</div>
                                                    <span>Emily Davis</span>
                                                </div>
                                            </td>
                                            <td>emily.davis@tech.io</td>
                                            <td>+1 234 567 8903</td>
                                            <td><span class="badge badge--danger">Inactive</span></td>
                                            <td>PKR 5,670</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card__header">
                                <h3 class="card__title">Patient Distribution by Area</h3>
                            </div>
                            <div class="chart-container"><canvas id="patientAreaChart"></canvas></div>
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