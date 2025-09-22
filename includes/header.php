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
        <a href="index.php" class="header-logo"><img src="assets/images/logo-white.png" alt="<?php echo APP_NAME; ?> Logo"></a>
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
            <div class="notification-dropdown">
                <button class="icon-button notification-toggle" id="notificationToggle">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">5</span>
                </button>
                <div class="notification-menu" id="notificationMenu">
                    <div class="notification-header">
                        <h6>Notifications</h6>
                    </div>
                    <div class="notification-list">
                        <div class="notification-item unread">
                            <div class="notification-content">
                                <div class="notification-title">New Customer Added</div>
                                <div class="notification-message">John Doe has been added to your customer list</div>
                                <div class="notification-time">2 minutes ago</div>
                            </div>
                        </div>
                        <div class="notification-item unread">
                            <div class="notification-content">
                                <div class="notification-title">Deal Closed</div>
                                <div class="notification-message">Deal with ABC Corp has been successfully closed</div>
                                <div class="notification-time">1 hour ago</div>
                            </div>
                        </div>
                        <div class="notification-item">
                            <div class="notification-content">
                                <div class="notification-title">Task Reminder</div>
                                <div class="notification-message">Follow up with potential client scheduled for today</div>
                                <div class="notification-time">3 hours ago</div>
                            </div>
                        </div>
                        <div class="notification-item">
                            <div class="notification-content">
                                <div class="notification-title">Monthly Report Ready</div>
                                <div class="notification-message">Your monthly sales report is now available</div>
                                <div class="notification-time">1 day ago</div>
                            </div>
                        </div>
                        <div class="notification-item">
                            <div class="notification-content">
                                <div class="notification-title">System Update</div>
                                <div class="notification-message">CRM system has been updated to version 2.1</div>
                                <div class="notification-time">2 days ago</div>
                            </div>
                        </div>
                    </div>
                    <div class="notification-footer">
                        <a href="#" class="view-all-notifications">View all notifications</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="user-profile-dropdown">
            <div class="user-profile" id="userProfileToggle">
                <div class="user-avatar"><?php echo substr($_SESSION['user_name'] ?? 'Admin', 0, 2); ?></div>
                <span><?php echo $_SESSION['user_name'] ?? 'Admin User'; ?></span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="user-profile-menu" id="userProfileMenu">
                <div class="profile-header">
                    <div class="profile-info">
                        <div class="profile-avatar-large"><?php echo substr($_SESSION['user_name'] ?? 'Admin', 0, 2); ?></div>
                        <div class="profile-details">
                            <div class="profile-name"><?php echo $_SESSION['user_name'] ?? 'Admin User'; ?></div>
                            <div class="profile-email">admin@company.com</div>
                        </div>
                    </div>
                </div>
                <div class="profile-menu-items">
                    <a href="#" class="profile-menu-item">
                        <i class="fas fa-user"></i>
                        <span>My Profile</span>
                    </a>
                    <a href="#" class="profile-menu-item">
                        <i class="fas fa-cog"></i>
                        <span>Account Settings</span>
                    </a>
                    <div class="profile-menu-divider"></div>
                    <a href="logout.php" class="profile-menu-item logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Sign Out</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

