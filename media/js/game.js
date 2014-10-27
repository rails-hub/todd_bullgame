window.onload = function () {
    var landing = 1;
    $('.white-glow > img').live('click', function (event) {
//        event.preventDefault();
//        $("#landing-" + landing).animate({ marginLeft: "-100px", opacity: 0 }, 100).hide();
//        $("#categories").fadeIn("slow").animate({ marginLeft: "0", opacity: 1 }, 100).show();
    });
    $("#gotoCat").live('click', function (event) {
        event.preventDefault();
        if (!$('#categories').is(":visible")) {
            $("#landing-" + landing).animate({ marginLeft: "-100px", opacity: 0 }, 100).hide();
            $("#categories").fadeIn("slow").animate({ marginLeft: "0", opacity: 1 }, 100).show();
        }
    });
    $('#backToLanding').live('click', function (event) {
        event.preventDefault();
        var au = document.getElementById("game-audio-6");
        if (!$.browser.msie) {
            au.play();
        }

        $("#categories").animate({ marginLeft: "-100px", opacity: 0 }, 100).hide();
        var random = Math.floor(Math.random() * 2) + 1;
        var landing = random;
        $("#landing-" + random).fadeIn("slow").animate({ marginLeft: "0", opacity: 1 }, 100).show();
    });
    $('#backToCategory').live('click', function (event) {
        event.preventDefault();

        var au = document.getElementById("game-audio-6");
        if (!$.browser.msie) {
            au.play();
        }

        $('#whole-facts').find('.fact-container').hide();
        $('#categories').show();
        $('#bulls-bottom-row').hide();
    });
    $('#backToCat').live('click', function (event) {
        event.preventDefault();

        if (!$.browser.msie) {
            var audio = document.getElementById("game-audio-3");
            audio.pause();

            var au = document.getElementById("game-audio-6");
            au.play();
        }

        $('#points-cont').hide();
        $('#categories').show();
        $('#bulls-bottom-row').hide();
    });
    $('#backToC').live('click', function (event) {
        event.preventDefault();
        if (!$.browser.msie) {
            var audio = document.getElementById("game-audio-3");
            audio.pause();

            var au = document.getElementById("game-audio-6");
            au.play();
        }
        $('#lead-board').hide();
        $('#categories').show();
        $('#bulls-bottom-row').hide();
    });
    $('.category').live('click', function (event) {
        if (!$.browser.msie) {
            var audio = document.getElementById("game-audio-2");
            audio.play();
        }

        var _id = $(this).attr('id').toString().split("-");
        $.ajax({
            url: "game/clean_score?category_id=" + _id[1],
            type: 'POST',
            dataType: 'html',
            processData: false,
            success: function (data) {
                if (data != 'not-ok') {
                    $('#categories').hide();
                    $('#whole-facts').html(data);
                    $('#facts-' + _id[1]).show();
                    var info_close = $('#info_close').val();
                    if (!info_close) {
                        $('#wrap-' + _id[1]).show();
                    }
                    else {
                        $('.black_overlay').hide();
                        $('#wrap-' + _id[1]).hide();
                    }
                    $('#bulls-wrapper_' + _id[1]).find(".bull_class").css("opacity", "");
                    $('#bulls-wrapper_' + _id[1]).find(".bulls-text").addClass("bulls-click");
                    $('.c_options').val(0);
                    $('.t_traveled').val(0);
                    $('.f_traveled').val(0);
                    $('#bulls-bottom-row').show();
                    $('#baby-bull-img').css("left", "35px");
                    if (!$.browser.msie) {
                        var audio = document.getElementById("game-audio-3");
                        audio.play();
                    }

                }
            }
        });
    });
    $('.wrapper-popup').live('click', function (event) {
        $('#categories').hide();
        var _id = $(this).attr('id').toString().split("-");
        $('#bulls-wrapper_' + _id[1]).find(".bull_class").css("opacity", "");
        $('#bulls-wrapper_' + _id[1]).find(".bulls-text").addClass("bulls-click");
        $('#facts-' + _id[1]).show();
        $('.black_overlay').hide();
        $('.wrapper-popup').hide();
        $('#info_close').val(true);
    });

    check_fact = function (obj) {
        var clicked = $('#c_click').val();
        var complete = $('#c_complete').val();
        if (clicked == 0 && complete == 0) {
            if (!$.browser.msie) {
                var au = document.getElementById("game-audio-7");
                au.play();
            }

            $('#c_click').val(1);
            var _parent = $(obj);
            var id = $(obj).attr('id').toString().split("_");
            id = id[1];
            $(_parent).css('opacity', '.25');
            $('#' + id).removeClass("bulls-click");
            $('#' + id).removeAttr("onclick");
            var _id = $(obj).find(">:first-child").attr('id').toString().split("_");
            var iid = _id[1];
            var ival = parseInt($("#f_c_" + iid).val());
            var moveLevel = 470;
            var tval = parseInt($("#t_c_" + iid).val());
            var fval = parseInt($("#false_c_" + iid).val());
            var moveBull = parseInt(moveLevel / tval);
            var travelled = parseInt($('#t_traveled_' + iid).val());
            var false_travelled = parseInt($('#f_traveled_' + iid).val());
            $.ajax({
                url: "game/check_fact?fact_id=" + _id[0] + "&max=" + ival,
                type: 'POST',
                dataType: 'html',
                processData: false,
                success: function (data) {
                    if (data != "not-ok") {
                        //each level score
                        $('#c_sc').val(data);

                        //                    selected wrong one
                        if (id == 'ts') {
                            var score = parseInt($('#bl_po').val());
                            var negative = parseInt($('#negative').val());
                            var total_score = $('#bl_po').val((score - negative));
                            $(".t-score").html($('#bl_po').val());

                            flag_cross = $('#t_traveled_' + iid).val(travelled + 1);
                            flag_val = $('#t_traveled_' + iid).val();
//                            $(_parent).css('background-color', 'red');

                            $('#pow-' + _id[0]).fadeIn('slow').show();
                            $('#pow-' + _id[0]).find('.red-pow').show();
                            $(_parent).addClass('replace-bull');
                            $(_parent).find('.bulls-text').hide();
                            var check_flag = true;
                            if (flag_val >= tval) {
                                check_flag = false;
                                $('#c_complete').val(1);
                                $('#baby-bull-img').animate({left: "+=" + moveBull}, 2000, function () {
                                    $('#facts-' + _id[1]).hide();
                                    $('#bulls-bottom-row').hide();
                                    $('#points-cont').show();
                                    $('#fscore').css("color", "#E4164D");
                                    $('#pts').css("color", "#E4164D");
                                    $('#fscore').html(data);
                                    $('#inner-heading-score').html("couldn't stop the bull!");
                                    $('#nextLevel').hide();
                                    $('#shareFB').hide();
                                    $('#tryAgain').show();
                                    var audio = document.getElementById("game-audio-3");
                                    audio.pause();
                                    if (!$.browser.msie) {
                                        var au = document.getElementById("game-audio-4");
                                        au.play();
                                    }

                                });

                            }
                            else {
//                                $('#baby-bull-img').addClass('flipImage');
                                $('#baby-bull-img').animate({left: "+=" + moveBull}, 2000);
                            }
                        }

                        //                     selected false correctly
                        else if (id == 'fs') {
                            score = parseInt($('#bl_po').val());
                            var positive = parseInt($('#positive').val());
                            $('#bl_po').val(score + positive);
                            $(".t-score").html($('#bl_po').val());

                            var flag_cross = $('#f_traveled_' + iid).val(false_travelled + 1);
                            var flag_val = $('#f_traveled_' + iid).val();
                            var check_false_flag = true;

                            $('#pow-' + _id[0]).fadeIn('slow').show();
                            $('#pow-' + _id[0]).find('.green').show();
                            $(_parent).addClass('replace-bull');
                            $(_parent).find('.bulls-text').hide()
                            if (flag_val >= fval) {
                                check_false_flag = false;

                                $('#c_complete').val(1);
                                $('#facts-' + _id[1]).hide();
                                $('#bulls-bottom-row').hide();
                                $('#points-cont').show();
                                $('#fscore').css("color", "#18D71D");
                                $('#pts').css("color", "#18D71D");
                                $('#fscore').html(data);
                                $('#inner-heading-score').html("you stopped the bull!");
                                $('#nextLevel').show();
                                $('#shareFB').show();
                                $('#tryAgain').hide();

                                if (!$.browser.msie) {
                                    var audio = document.getElementById("game-audio-3");
                                    audio.pause();

                                    var au = document.getElementById("game-audio-5");
                                    au.play();
                                }

                            }
                        }

                        $('#c_cat').val(_id[1]);
                        $('#c_lev').val(_id[2]);
                        var opt = parseInt($('#options_' + iid).val()) + 1;
                        $('#options_' + iid).val(opt);
                    }
                    else {
                        $(_parent).css("opacity", "");
                        $('#' + id).addClass("bulls-click");
                        $('#' + id).attr("onclick", "check_fact(" + this + ")");
                    }
                    $('#c_click').val(0);
                },
                error: function (data) {
                    $('#c_click').val(0);
                    $(_parent).css("opacity", "");
                    $('#' + id).addClass("bulls-click");
                }


            });
        }
    }


    $('#nextLevel').live('click', function (event) {
        if (!$.browser.msie) {
            var audio = document.getElementById("game-audio-3");
            audio.pause();

            var au = document.getElementById("game-audio-6");
            au.play();
        }

        var _category = parseInt($('#c_cat').val());
        $('#bulls-bottom-row').hide();
        $('#points-cont').hide();
        $('#categories').show();
        $('#backToLanding-' + _category).remove();
        $('.c_options').val(0);
        $('.t_traveled').val(0);
        $('.f_traveled').val(0);
        $('#c_complete').val(0);
        $('#c_click').val(0);
        $(".category-wrapper > a").each(function () {
            if (!$(this).is(":visible")) {
                $(this).show();
                return false;
            }
        });
    });

    $('#tryAgain').live('click', function (event) {
        if (!$.browser.msie) {
            var au = document.getElementById("game-audio-6");
            au.play();
            var audio = document.getElementById("game-audio-3");
            audio.play();
        }
        var _category = parseInt($('#c_cat').val());

        $.ajax({
            url: "game/clean_score?category_id=" + _category,
            type: 'POST',
            dataType: 'html',
            processData: false,
            success: function (data) {
                if (data != 'not-ok') {
                    $('#points-cont').hide();
                    $('#whole-facts').html(data);
                    $('#facts-' + _category).show();
                    $('#wrap-' + _category).hide();
                    $('.black_overlay').hide();
                    $('.c_options').val(0);
                    $('.t_traveled').val(0);
                    $('.f_traveled').val(0);
                    $('#c_complete').val(0);
                    $('#c_click').val(0);
                    $('#bulls-bottom-row').show();
                    $('#baby-bull-img').css("left", "35px");
                }
            }
        });

    });

    $('#shareFB').live('click', function (event) {
        if (!$.browser.msie) {
            var au = document.getElementById("game-audio-6");
            au.play();

        }
        var _category = parseInt($('#c_cat').val());
        var _cat_name = $('#c_cat_name_' + _category).val();
        var score = $('#c_sc').val();
        var loc = $(location).attr('href');
        FB.ui({
            method: 'feed',
            name: 'Play Stop The Bull with me!',
            link: 'https://apps.facebook.com/stopthebull/',
            picture: 'http://stopthebullgame.com//media/img/bull.png',
            caption: 'Just beat the category ' + _cat_name + ' and scored ' + score + ' pts',
            description: "Stomp out the Executive Branch's Lies, and help secure America now!"
        }, function (response) {

            if (typeof response != 'undefined') {

            }
        });
    });

    $('.no-category').live('click', function () {
        if (!$.browser.msie) {
            var au = document.getElementById("game-audio-6");
            au.play();
        }

        $('#lead-board').show();
        $('#categories').hide();
        $('.leaderboard-wrapper').html('');
        FB.api(
            "/me/friends",
            { fields: 'id, name, picture' },
            function (response) {
                if (response && !response.error) {
                    var clean_it = encodeURIComponent(JSON.stringify(response.data));
                    $.ajax({
                        url: "game/friend_list?list=" + clean_it,
                        type: 'POST',
                        dataType: 'json',
                        processData: false,
                        success: function (data) {
                            $.each(data, function (i, item) {
                                var u_id = parseInt($('#u-id').val());
                                add_class = null;
                                share_class = "";
                                if (item.user_id == u_id) {
                                    var add_class = "pink";
                                    var share_class = '<div id="share-lead" class="share">share</div>';
                                }
                                var html_div = "<div class='leaderboard-row " + add_class + "'><div class='rank'>" + parseInt(i + 1) + "</div><div class='person-img'><img src=" + item.picture + "></img></div><div class='name'>" + item.name + "</div><div class='scope'>" + item.score + "</div>" + share_class + "</div>";
                                $('.leaderboard-wrapper').append(html_div);

                            })
                        }
                    });
                }
            }
        );
    });

    $('#share-lead').live('click', function () {
        var au = document.getElementById("game-audio-6");
        if (!$.browser.msie) {
            au.play();
        }

        var sc = $('#c_sc').val();
        var score = $(this).prev().text();
        FB.ui({
            method: 'feed',
            name: 'Play Stop The Bull with me!',
            link: 'https://apps.facebook.com/stopthebull/',
            picture: 'http://stopthebullgame.com//media/img/bull.png',
            caption: 'Just scored ' + sc + ' pts',
            description: "Stomp out the Executive Branch's Lies, and help secure America now!"
        }, function (response) {

            if (typeof response != 'undefined') {
            }
        });
    });

    $('#friend-invite').live('click', function () {
        var au = document.getElementById("game-audio-6");
        if (!$.browser.msie) {
            au.play();
        }

        FB.ui({method: 'apprequests',
            message: 'Hey! Join me in securing America and play Stop the Bull!'
        }, function (response) {
            console.log(response);
        });
    });

//    $(".bull_class").live('mouseover', function () {
//        if (!$(this).hasClass('replace-bull')) {
//            id = $(this).attr('id');
//            $('#' + id).rotate({ angle: -30,
//                animateTo: 15,
//                callback: rotation(id),
//                easing: function (x, t, b, c, d) {
//                    return c * (t / d) + b;
//                }
//
//            });
//        }
//    });
//
//    $(".bull_class").live('mouseout', function () {
//        if (!$(this).hasClass('replace-bull')) {
//            $('.bull_class').rotate({
//                animateTo: 0,
//                easing: function (x, t, b, c, d) {
//                    return c * (t / d) + b;
//                }
//            });
//        }
//
//    });
//
//    rotation = function (id) {
//        $('.bull_class').rotate({
//            animateTo: 0,
//            easing: function (x, t, b, c, d) {
//                return c * (t / d) + b;
//            }
//
//        });
//    }

    var which = null;
    $(".bull_class").live('mouseover', function () {
        var clicked = $('#c_click').val();
        var complete = $('#c_complete').val();
        if (clicked == 0 && complete == 0) {
            $(this).addClass('over');
        }
    });

    $(".bull_class").live('mouseout', function () {
        var clicked = $('#c_click').val();
        var complete = $('#c_complete').val();
        if (clicked == 0 && complete == 0) {

            var id = $(this).attr('id');
            which = id;
            $(".bull_class").removeClass('over').removeClass('out');
            $(this).removeClass('over');
            $(this).addClass('out');
            window.setTimeout(function () {
                $('#' + which).removeClass('over').removeClass('out');
            }, 1500);
        }
    });

};
