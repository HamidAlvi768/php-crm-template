<?php require_once __DIR__ . '/config.php'; ?>
<?php
$menu_items = [
    ['icon' => 'fa-dashboard', 'label' => 'Dashboard', 'url' => 'index.php'],
    ['icon' => 'fa-users',    'label' => 'Customers', 'url' => 'customers.php'],
    ['icon' => 'fa-cog',      'label' => 'Settings',  'url' => 'settings.php'],
];
$current_page = current_page_name();
?>
<header class="header">
    <div class="header-left">
        <a href="index.php" class="header-logo"><img src="assets/images/logo.jpg" alt="<?php echo APP_NAME; ?> Logo"></a>
        <nav class="header-nav">
            <?php foreach ($menu_items as $item): if ($item['label'] === 'Settings') { continue; } $active = ($current_page === $item['url']) ? 'active' : ''; ?>
                <a href="<?php echo $item['url']; ?>" class="header-nav-link <?php echo $active; ?>">
                    <i class="fas <?php echo $item['icon']; ?>"></i>
                    <span><?php echo htmlspecialchars($item['label']); ?></span>
                </a>
            <?php endforeach; ?>
        </nav>
    </div>
    <div class="header-right">
        <?php $settingsActive = ($current_page === 'settings.php') ? 'active' : ''; ?>
        <a href="settings.php" class="header-nav-link <?php echo $settingsActive; ?>">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>
        <div class="header-icons">
            <button class="icon-button">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">5</span>
            </button>
        </div>
        <div class="user-profile">
            <div class="user-avatar"><?php echo substr($_SESSION['user_name'] ?? 'Admin', 0, 2); ?></div>
            <span><?php echo $_SESSION['user_name'] ?? 'Admin User'; ?></span>
            <i class="fas fa-chevron-down"></i>
        </div>
    </div>
</header>

