<? if ($message) : ?>
    <h3 class="message">
        <?= $message; ?>
    </h3>
<? endif; ?>
<div id="title_bar" class="title_bar">
    <div id="titlebar_left">

        <h2 id="page_title">Facts</h2>

        <div class="right">
            <?= HTML::anchor("/admin/add_fact", "Add Fact", array("class" => "btn large")) ?>
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
                        <th>Is True ?</th>
                        <th>Category_id</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach ($facts as $c) : ?>
                        <tr>
                            <td><?= $c->title ?></td>
                            <td><?= $c->is_true ?></td>
                            <td><?= $c->category_id ?></td>
                            <td>
                                <?= HTML::anchor("#", "Delete", array("class" => "delete_fact", "id" => "{$c->id}")) ?>
                                <?= HTML::anchor("admin/fact/{$c->id}", "Edit", array("class" => "edit_fact", "id" => "{$c->id}")) ?>
                            </td>
                        </tr>
                    <? endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>