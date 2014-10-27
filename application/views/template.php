<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php echo HTML::style("/media/css/bootstrap.css"); ?>
    <?php echo HTML::style("/media/css/base.css"); ?>
    <?php echo HTML::style("/media/css/active_admin.css"); ?>

    <?php echo HTML::script("/media/js/jquery-1.11.0.min.js"); ?>
    <?php echo HTML::script("/media/js/jquery-migrate-1.2.1.min.js"); ?>
    <?php echo HTML::script("/media/js/jquery-ui.js"); ?>
    <?php echo HTML::script("/media/js/admin.js"); ?>

    <title>Bull Game Admin</title>
</head>

<body class="index admin_dashboard active_admin logged_in admin_namespace">
<div id="wrapper">
    <? if ($current_user != null) : ?>
        <div id="header" class="header">
            <h1 id="site_title" class="site_title">BG AdminPanel</h1>
            <ul id="tabs" class="header-item">
                <li id="admin_users" class="current">
                    <?= HTML::anchor("admin/index", "Admin Users") ?>
                </li>
                <li id="users">
                    <?= HTML::anchor("admin/users", "Users") ?>
                </li>
                <li id="admin-cat">
                    <?= HTML::anchor("admin/categories", "Categories") ?>
                </li>
                <li id="admin-levels">
                    <?= HTML::anchor("admin/facts", "Facts") ?>
                </li>
            </ul>
            <p id="utility_nav" class="header-item">
                <span class="current_user"><?= $current_user->email ?></span>
                <?= HTML::anchor("admin/logout", "Logout") ?>
        </div>
    <? endif; ?>

    <div id="content">
        <?= $content ?>
    </div>
</div>

</body>

</html>
