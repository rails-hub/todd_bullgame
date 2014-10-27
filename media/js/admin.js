window.onload = function () {
    $('.delete_admin').live('click', function () {

        var $message = "Do you really want to Delete this Admin?";
        var ask = confirm($message);
        var _id = $(this).attr('id');
        if (ask == true) {
            window.location = "delete/" + _id;
        }
    });
    $('.delete_user').live('click', function () {

        var $message = "Do you really want to Delete this User?";
        var ask = confirm($message);
        var _id = $(this).attr('id');
        if (ask == true) {
            window.location = "delete_user/" + _id;
        }
    });
    $('.delete_category').live('click', function () {

        var $message = "Do you really want to Delete this Category?";
        var ask = confirm($message);
        var _id = $(this).attr('id');
        if (ask == true) {
            window.location = "delete_category/" + _id;
        }
    });
    $('.delete_fact').live('click', function () {

        var $message = "Do you really want to Delete this Fact?";
        var ask = confirm($message);
        var _id = $(this).attr('id');
        if (ask == true) {
            window.location = "delete_fact/" + _id;
        }
    });

    var url = window.location;
    var urlParts = url.toString().split('/');
    var action = urlParts[4];
    $('#tabs').find('.current').removeClass('current');
    if (action == "index" || action == "admin_user" || action == "add") {
        $('#tabs').find('#admin_users').addClass('current');
    }
    else if (action == "users") {
        $('#tabs').find('#users').addClass('current');
    }
    else if (action == "categories" || action == "add_category" || action == "category") {
        $('#tabs').find('#admin-cat').addClass('current');
    }
    else if (action == "facts" || action == "add_fact" || action == "fact") {
        $('#tabs').find('#admin-levels').addClass('current');
    }

};
