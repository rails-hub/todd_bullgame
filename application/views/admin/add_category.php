<? if ($message) : ?>
    <h3 class="message">
        <?= $message; ?>
    </h3>
<? endif; ?>
<div id="title_bar" class="title_bar">
    <div id="titlebar_left">

        <h2 id="page_title">Add Category</h2>

    </div>
    <div id="titlebar_right"></div>
</div>
<div class="without_sidebar" id="active_admin_content">
    <div id="main_content_wrapper">
        <div id="main_content">
            <div id="dashboard_default_message" class="blank_slate_container">

                <?= Form::open(); ?>
                <div class="clearfix">
                    <?= Form::label('title', 'Title'); ?>
                    <?= Form::input('title', null); ?>
                </div>

                <div class="pull-right">
                    <?= Form::submit('save', 'Save'); ?>
                </div>

                <?= Form::close(); ?>

            </div>
        </div>
    </div>
</div>