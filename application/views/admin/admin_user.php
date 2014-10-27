<? if ($message) : ?>
    <h3 class="message">
        <?= $message; ?>
    </h3>
<? endif; ?>

<div class="modalcontainer thinbase login header-signup">
    <div class="modalcontainer-header modalcontainer-header-up">
        <h3>Edit Admin</h3></div>
    <div class="modalcontainer-body modalcontainer-body-up">
        <?= Form::open(); ?>

        <div class="clearfix">
            <?= Form::label('email', 'Email Address'); ?>
            <?= Form::input('email', $admin->email); ?>
            <div class="error">
                <?= Arr::get($errors, 'email'); ?>
            </div>
        </div>

        <div class="clearfix">
            <?= Form::label('password', 'Password'); ?>
            <?= Form::password('password'); ?>
            <div class="error">
                <?= Arr::path($errors, '_external.password'); ?>
            </div>
        </div>

        <div class="clearfix">
            <?= Form::label('password_confirm', 'Confirm Password'); ?>
            <?= Form::password('password_confirm'); ?>
            <div class="error">
                <?= Arr::path($errors, '_external.password_confirm'); ?>
            </div>
        </div>
        <div class="containerSignUp">
            <div class="pull-right pull-rightSignUp">
                <?= Form::submit('create', 'Update'); ?>
                <?= Form::close(); ?>
            </div>

        </div>

    </div>
</div>


