<? if ($message) : ?>
    <h3 class="message">
        <?= $message; ?>
    </h3>
<? endif; ?>
<div id="title_bar" class="title_bar">
    <div id="titlebar_left">

        <h2 id="page_title">Add Fact</h2>

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

                <div class="clearfix" style="float: left; margin-top: 10px; margin-left: 170px">
                    <?= Form::label('category', 'Category'); ?>
                    <?= Form::select('category', $categories->as_array("id", "title")); ?>
                </div>


                <div class="clearfix" style="float: left; margin-top: 10px; margin-left: 170px">
                    <?= Form::label('is_true', 'Is_true'); ?>
                    <?= Form::select('is_true', array(true => 'True', false => 'false')); ?>
                </div>


                <div class="pull-right">
                    <?= Form::submit('save', 'Save'); ?>
                </div>

                <?= Form::close(); ?>

            </div>
        </div>
    </div>
</div>