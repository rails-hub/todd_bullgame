<? if ($message) : ?>
    <h3 class="message">
        <?= $message; ?>
    </h3>
<? endif; ?>

<div id="brandlarge">
    <h1>Bull Game Admin</h1>

    <p> Sign In as a Admin</p>
</div>

<div class="modalcontainer thinbase login">
    <div class="modalcontainer-header modalcontainer-header-up">
        <h3>Login</h3></div>
    <div class="modalcontainer-body modalcontainer-body-up">
        <?= Form::open(); ?>
        <div class="clearfix">
            <?= Form::label('email', 'Email'); ?>
            <?= Form::input('email', HTML::chars(Arr::get($_POST, 'username'))); ?>
        </div>
        <div class="clearfix">
            <?= Form::label('password', 'Password'); ?>
            <?= Form::password('password'); ?>
        </div>

        <div class="clearfix">
            <?= Form::label('remember', 'Remember Me'); ?>
            <?= Form::checkbox('remember'); ?>
        </div>

        <div class="pull-right">
            <?= Form::submit('login', 'Login'); ?>
        </div>

        <?= Form::close(); ?>

    </div>
    <!-- /modalcontainer-body -->
</div>


