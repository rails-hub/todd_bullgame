<? if ($message) : ?>
    <h3 class="message">
        <?= $message; ?>
    </h3>
<? endif; ?>
<div id="title_bar" class="title_bar">
    <div id="titlebar_left">

        <h2 id="page_title">Admin Users</h2>

        <div class="right">
            <?= HTML::anchor("/admin/add", "Add Admin", array("class" => "btn large")) ?>
        </div>
    </div>
    <div id="titlebar_right"></div>
</div>
<div class="without_sidebar" id="active_admin_content">
    <div id="main_content_wrapper">
        <div id="main_content">
            <div id="dashboard_default_message" class="blank_slate_container">

                <table class="table">
                    <thead>
                    <tr>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach ($admin_users as $ad) : ?>
                        <tr>
                            <td><?= $ad->email ?></td>
                            <td>Admin</td>
                            <td>
                                <?= HTML::anchor("admin/admin_user/{$ad->id}", "Edit", array("class" => "edit_admin", "id" => "{$ad->id}")) ?>
                                <? if ($ad->id != $current_user->id) : ?>
                                    <?= HTML::anchor("#", "Delete", array("class" => "delete_admin", "id" => "{$ad->id}")) ?>
                                <? endif; ?>
                            </td>
                        </tr>
                    <? endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>