<?php defined('SYSPATH') or die('No direct script access.');
require_once Kohana::find_file('vendor', 'mailer/lib/swift_required');
require_once Kohana::find_file('vendor', 'mailer/lib/swift_init');

class Controller_Dashboard extends Controller
{

    public function action_index()
    {
        $title = "Stop the Bull";
        $app_id = "1475160229418185";
        $categories = ORM::factory('category')->find_all();
        $point = ORM::factory('point')->find();
        $this->response->body(View::factory('dashboard/landing')
            ->bind('title', $title)
            ->bind('app_id', $app_id)
            ->bind('point', $point)
            ->bind('levels', $levels)
            ->bind('categories', $categories));
    }

    public function action_privacy_policy()
    {
        $title = "Stop the Bull: Privacy Policy";
        $this->response->body(View::factory('shared/privacy-policy')
            ->bind('title', $title));
    }

    public function action_tos()
    {
        $title = "Stop the Bull: Terms of Service";
        $this->response->body(View::factory('shared/tos')
            ->bind('title', $title));
    }

} // End Dashboard
