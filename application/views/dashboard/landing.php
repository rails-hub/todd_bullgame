<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= $title ?></title>

    <?php echo HTML::style("/media/css/style.css"); ?>
    <?php echo HTML::style("/media/css/landing.css"); ?>
    <?php echo HTML::script("/media/js/jquery-1.11.0.min.js"); ?>
    <?php echo HTML::script("/media/js/jquery-migrate-1.2.1.min.js"); ?>
    <?php echo HTML::script("/media/js/jquery-ui.js"); ?>
    <?php echo HTML::script("/media/js/jQueryRotate.js"); ?>
    <?php echo HTML::script("/media/js/json2.js"); ?>

</head>

<body>
<div id="fb-root"></div>
<script>
    jQuery(window).load(function () {
        if (!$.browser.msie) {
            var audio = document.getElementById("game-audio-1");
            audio.play();
        }
        //        setTimeout(function () {
        //            landing = 1;
        //            $("#landing-" + landing).animate({ marginLeft: "-100px", opacity: 0 }, 100).hide();
        //            $("#categories").fadeIn("slow").animate({ marginLeft: "0", opacity: 1 }, 100).show();
        //
        //        }, 3500);

    });

    window.fbAsyncInit = function () {
        FB.init({
            appId: '<?= $app_id ?>',
            xfbml: true,
            status: true,
            cookie: true,
            channelUrl: '//stopthebullgame.com/channel.html',
            version: 'v2.1'
        });
        function onLogin(response) {
            if (response.status == 'connected') {
                FB.api('/me?fields=first_name,name,email, picture', function (result) {
                    var picture = encodeURIComponent(JSON.stringify(result.picture.data.url));
                    $.ajax({
                        url: "game/check_user?id=" + result.id + "&email=" + result.email + "&name=" + result.name + "&picture=" + picture,
                        type: 'POST',
                        dataType: 'html',
                        processData: false,
                        success: function (data) {
                            if (data != 'not-ok') {
                                $('#u-id').val(data);
                                if (!$('#categories').is(":visible")) {
                                    var landing = 1;
                                    $("#landing-" + landing).animate({ marginLeft: "-100px", opacity: 0 }, 100).hide();
                                    $("#categories").fadeIn("slow").animate({ marginLeft: "0", opacity: 1 }, 100).show();
                                }
                            }
                        }

                    })
                });
            }
        }

        FB.getLoginStatus(function (response) {
            // Check login status on load, and if the user is
            // already logged in, go directly to the welcome message.
            if (response.status == 'connected') {
                onLogin(response);
            } else {
                // Otherwise, show Login dialog first.
                FB.login(function (response) {
                    onLogin(response);
                }, {scope: 'user_friends, email, public_profile,user_games_activity'});
            }
        }, true);
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = document.location.protocol + "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

</script>

<div id="wrapper">
    <audio controls id="game-audio-1" style="display: none">
        <source src="media/audio/SAN_Game_Audio_Intro.wav" type="audio/wav">
        <source src="media/audio/SAN_Game_Audio_Intro.mp3" type="audio/mp3">
        Your browser does not support the audio element.
    </audio>

    <audio controls id="game-audio-2" style="display: none">
        <source src="media/audio/SAN_Game_Audio_Category_Selection.wav" type="audio/wav">
        <source src="media/audio/SAN_Game_Audio_Category_Selection.mp3" type="audio/mp3">
    </audio>

    <audio controls id="game-audio-3" style="display: none" loop="loop">
        <source src="media/audio/SAN_Game_Audio_Loop.wav" type="audio/wav">
    </audio>

    <audio controls id="game-audio-4" style="display: none">
        <source src="media/audio/SAN_Game_Audio_Lose.wav" type="audio/wav">
    </audio>

    <audio controls id="game-audio-5" style="display: none">
        <source src="media/audio/SAN_Game_Audio_Win.mp3" type="audio/mp3">
        <source src="media/audio/SAN_Game_Audio_Win.wav" type="audio/wav">
    </audio>

    <audio controls id="game-audio-6" style="display: none">
        <source src="media/audio/Gentle Sweet Click 1.mp3" type="audio/mp3">
        <source src="media/audio/Gentle Sweet Click 1.wav" type="audio/wav">
    </audio>

    <audio controls id="game-audio-7" style="display: none">
        <source src="media/audio/SAN_Game_Audio_Bull_Selection.mp3" type="audio/mp3">
        <source src="media/audio/SAN_Game_Audio_Bull_Selection.wav" type="audio/wav">
    </audio>

    <div class="leading" id="landing-1" style="display: block">
        <div id="nav">
            <?= HTML::image("media/img/logo.png", array("alt" => "logo", "class" => "logoImg")) ?>
        </div>

        <div class="white-glow">
            <?= HTML::image("media/img/stop.png", array("alt" => "", "class" => "stopImg")) ?>
        </div>
        <div class="bull">
            <?= HTML::image("media/img/bull.png", array("alt" => "", "id" => "")) ?>
        </div>
        <a style="margin-left: 38%;width: 200px; z-index: 2222222222; color: green; margin-top: 5px" href="#"
           id="gotoCat" class="new-category">Play Now</a>

        <div class="flag">
            <?= HTML::image("media/img/flag.png", array("alt" => "")) ?>
        </div>
    </div>

    <div class="leading" id="landing-2" style="display: none">
        <div id="nav">
            <?= HTML::image("media/img/logo.png", array("alt" => "logo", "class" => "logoImg")) ?>
        </div>
        <div class="white-glow">
            <?= HTML::image("media/img/stop.png", array("alt" => "", "class" => "stopImg")) ?>
        </div>
        <div class="bull bullDiv">
            <?= HTML::image("media/img/flag-reverse.png", array("alt" => "")) ?>
        </div>
        <div class="flag flagDiv">
            <?= HTML::image("media/img/bull-2.png", array("alt" => "")) ?>
        </div>
    </div>

    <div id="categories" style="display: none; height: 100%">
        <div id="nav" style=" position:static;">
            <div class="left-text">
                <? #= HTML::anchor("#landing-1", "< Back", array("id" => "backToLanding")) ?>
            </div>
            <div class="mid-text" style="margin-left: 254px">
                category
            </div>
        </div>
        <div class="category-wrapper">
            <? $index = 1 ?>
            <? foreach ($categories as $cat) : ?>
                <?= Form::hidden("c_cat_name", $cat->title, array("id" => "c_cat_name_{$cat->id}")) ?>
                <? if ($index <= 3) : ?>
                    <?= HTML::anchor("#landing-{$index}", $cat->title, array("id" => "backToLanding-{$cat->id}", "style" => "display: block", "class" => $index == 1 ? "category" : "category marginTop15")) ?>
                <? else : ?>
                    <?= HTML::anchor("#landing-{$index}", $cat->title, array("id" => "backToLanding-{$cat->id}", "style" => "display: none", "class" => $index == 1 ? "category" : "category marginTop15")) ?>
                <? endif; ?>
                <? $index++ ?>
            <? endforeach; ?>
        </div>
        <?= HTML::anchor("#lead-board", "Leaderboard", array("id" => "leaderboard", "style" => "display: block;color: #00FF00;margin-top: 0px !important;height: 46px;margin-left: 104px;", "class" => "no-category marginTop15")) ?>
    </div>
    <?= Form::hidden("click", 0, array("id" => "c_click")) ?>
    <?= Form::hidden("complete", 0, array("id" => "c_complete")) ?>
    <?= Form::hidden("c_cat", 0, array("id" => "c_cat")) ?>
    <?= Form::hidden("c_lev", 0, array("id" => "c_lev")) ?>
    <?= Form::hidden("c_sc", 0, array("id" => "c_sc")) ?>
    <?= Form::hidden("negative", $point->guess_wrong, array("id" => "negative")) ?>
    <?= Form::hidden("positive", $point->guess_right, array("id" => "positive")) ?>
    <?= Form::hidden("bl_po", 0, array("id" => "bl_po")) ?>
    <?= Form::hidden("u-id", 0, array("id" => "u-id")) ?>
    <?= Form::hidden("info_close", false, array("id" => "info_close")) ?>

    <div id="whole-facts" style="display: block">

    </div>

    <div id="points-cont" style="display: none" class="points-cont">
        <div id="nav">
            <div class="left-text">
                <?= HTML::anchor("#categories", "< back", array("id" => "backToCat")) ?>
            </div>
            <div class="mid-text" style="margin-left:175px;">
                points!
            </div>
        </div>

        <div class="top-left">
            <?= HTML::image("media/img/top-left.png", array("alt" => "")) ?>
        </div>
        <div class="bottom-right">
            <?= HTML::image("media/img/right-strips.png", array("alt" => "")) ?>
        </div>
        <div class="inner-area">
            <div class="inner-heading" id="inner-heading-score">

            </div>
            <div class="pts green">

                <span id="fscore"> 0</span> <span id="pts" style="font-size:50px;">PTS</span>
            </div>

            <div class="button" style="color:#2396ec;" id="shareFB">
                share
            </div>
            <div class="button" style="margin-left:10px; color:#e4164d;padding-bottom: 0 !important;" id="nextLevel">
                next>>
            </div>
            <div class="button" style="color:#2396ec;display: none; margin-left: 142px" id="tryAgain">
                Try Again
            </div>
        </div>

    </div>

    <div id="lead-board" style="display: none; height: 100%;background: #4C4C4D">
        <div id="nav" style=" position:static;">
            <div class="left-text">
                <?= HTML::anchor("#categories", "< back", array("id" => "backToC")) ?>
            </div>
            <div class="mid-text" style="margin-left:145px;">
                leaderboard
            </div>
            <div class='button' style='margin-left: 30px; background-color: lightgreen' id="friend-invite"> Invite
                Friends
            </div>
        </div>
        <div class="row-white">
            <div class="row-text">
                <div class="leader-col1">
                    rank
                </div>
                <div class="leader-col1" style="margin-left:94px;">
                    name
                </div>
                <div class="leader-col1" style="margin-left:198px;">
                    score
                </div>
            </div>
        </div>
        <div class="leaderboard-wrapper" style="height: 63%; overflow-x: hidden; overflow-y: auto">

        </div>
    </div>


</div>
<?php echo HTML::script("/media/js/game.js"); ?>
</body>

</html>