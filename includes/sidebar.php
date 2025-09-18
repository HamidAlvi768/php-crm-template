<?php
require_once __DIR__ . '/config.php';

$menu_items = [
    ['icon' => 'fa-dashboard', 'label' => 'Dashboard', 'url' => 'index.php'],
    ['icon' => 'fa-users',    'label' => 'Customers', 'url' => 'customers.php'],
    ['icon' => 'fa-user-plus','label' => 'Leads',     'url' => 'leads.php'],
    ['icon' => 'fa-handshake','label' => 'Deals',     'url' => 'deals.php'],
    ['icon' => 'fa-tasks',    'label' => 'Tasks',     'url' => 'tasks.php'],
    ['icon' => 'fa-chart-bar','label' => 'Reports',   'url' => 'reports.php'],
    ['icon' => 'fa-cog',      'label' => 'Settings',  'url' => 'settings.php'],
];

$current_page = current_page_name();
?>
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">CRM</div>
        <div class="sidebar-brand"><?php echo APP_NAME; ?></div>
    </div>
    <nav class="sidebar-menu">
        <?php foreach ($menu_items as $item): $active = ($current_page === $item['url']) ? 'active' : ''; ?>
            <div class="menu-item">
                <a href="<?php echo $item['url']; ?>" class="menu-link <?php echo $active; ?>">
                    <i class="fas <?php echo $item['icon']; ?> menu-icon"></i>
                    <span><?php echo htmlspecialchars($item['label']); ?></span>
                </a>
            </div>
        <?php endforeach; ?>
    </nav>
</aside>

