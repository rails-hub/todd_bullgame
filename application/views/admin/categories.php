<? if ($message) : ?>
    <h3 class="message">
        <?= $message; ?>
    </h3>
<? endif; ?>
<div id="title_bar" class="title_bar">
    <div id="titlebar_left">

        <h2 id="page_title">Categories</h2>

        <div class="right">
            <?= HTML::anchor("/admin/add_category", "Add Category", array("class" => "btn large")) ?>
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
                        <th>Title</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach ($categories as $c) : ?>
                        <tr>
                            <td><?= $c->title ?></td>
                            <td>
                                <?= HTML::anchor("#", "Delete", array("class" => "delete_category", "id" => "{$c->id}")) ?>
                                <?= HTML::anchor("admin/category/{$c->id}", "Edit", array("class" => "edit_category", "id" => "{$c->id}")) ?>
                            </td>
                        </tr>
                    <? endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>