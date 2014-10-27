<?php defined('SYSPATH') or die('No direct script access.');
require_once Kohana::find_file('vendor', 'mailer/lib/swift_required');
require_once Kohana::find_file('vendor', 'mailer/lib/swift_init');

class Controller_Game extends Controller
{

    public function action_check_user()
    {
        // Store a user id
        $session = Session::instance();
        $session->set('user_id', $this->request->query('id'));
//        if ($this->request->query('email') != 'undefined' && $this->request->query('email') != null && $this->request->query('email') != '') {
        $create_user = ORM::factory('user')->create_user($this->request->query('name'), $this->request->query('id'), $this->request->query('email'));

        if ($create_user) {
            $lead = ORM::factory('leaderboard')->create_update_lead($create_user->id, $this->request->query('name'), $this->request->query('picture'));
            $upoint = ORM::factory('upoint')->where('user_id', '=', $create_user->id)->find();
            $upoints = ORM::factory('upoint')->where('user_id', '=', $create_user->id)->find_all();
            if ($upoint->loaded()) {
                foreach ($upoints as $up) {
                    $up->delete();
                }
            }
            $user_id = $session->get('user_id');
            $user = ORM::factory('user')->where('udid', '=', $user_id)->find();
            echo $user->id;
        } else {
            echo "not-ok";
        }
//    }  else {
//            echo "not-ok";
//        }
    }

    public
    function action_check_fact()
    {
        $fact = ORM::factory('fact')->where('id', '=', $this->request->query('fact_id'))->find();
        $session = Session::instance();
        $user_id = $session->get('user_id');
        if ($fact->loaded()) {
            $point = ORM::factory('point')->find();
            $upoint = ORM::factory('upoint')->create_upoint($fact, $user_id, $point);
            if ($upoint) {
                $user = ORM::factory('user')->where('udid', '=', $user_id)->find();
                $total_upoints = DB::select(array(DB::expr('SUM(`score`)'), 'total_upoints'))
                    ->from('upoints')
                    ->where('user_id', '=', $user->id)
                    ->execute()
                    ->get('total_upoints');
                $user->score = $total_upoints;
                $user->update();
                $leaderboard = ORM::factory('leaderboard')->create_leaderboard($user);
                echo $upoint->score;
            } else {
                return "not-ok";
            }
        } else {
            return "not-ok";
        }
    }

    public
    function action_clean_score()
    {
//        try {
        $session = Session::instance();
        $user_id = $session->get('user_id');
        $user = ORM::factory('user')->where('udid', '=', $user_id)->find();
        $category = ORM::factory('category')->where('id', '=', $this->request->query('category_id'))->find();
        #clean score for the whole category
        $upoint = ORM::factory('upoint')->where('category_id', '=', $this->request->query('category_id'))->and_where('user_id', '=', $user->id)->find();
        $upoints = ORM::factory('upoint')->where('category_id', '=', $this->request->query('category_id'))->and_where('user_id', '=', $user->id)->find_all();

        if ($upoint->loaded()) {
            foreach ($upoints as $up) {
                $up->delete();
            }
        }

        $total_upoints = DB::select(array(DB::expr('SUM(`score`)'), 'total_upoints'))
            ->from('upoints')
            ->where('user_id', '=', $user->id)
            ->execute()
            ->get('total_upoints');
        $user->score = $total_upoints;
        $user->update();

        $categories = ORM::factory('category')->find_all();
        $point = ORM::factory('point')->find();

        $facts = ORM::factory('fact')->where('category_id', '=', $category->id)->limit(6)->order_by(DB::expr('RAND()'))->find_all();
        $this->response->body(View::factory('partials/facts')
                ->bind('point', $point)
                ->bind('facts', $facts)
                ->bind('category', $category)
                ->bind('user', $user)
                ->bind('categories', $categories)
        );
//        } catch (Exception $e) {
//            echo "not-ok";
//        }
    }

    public
    function action_friend_list()
    {
        $json = json_decode("{$this->request->query('list')}");
        $user_array = array();
        foreach ($json as $item) {
            $user = ORM::factory('user')->where('udid', '=', $item->id)->find();
            if ($user->loaded()) {
                $leaderboard = ORM::factory('leaderboard')->where('user_id', '=', $user->id)->find();
                if ($leaderboard->loaded()) {
                    $lead = ORM::factory('leaderboard')->update_leaderboard($leaderboard, $item->name, $item->picture->data->url);
                    array_push($user_array, array("user_id" => $leaderboard->user_id, "name" => $leaderboard->name, "picture" => $leaderboard->picture, "score" => $leaderboard->score));
                }
            }
        }
        $session = Session::instance();
        $user_id = $session->get('user_id');
        $u = ORM::factory('user')->where('udid', '=', $user_id)->find();

        if ($u->loaded()) {
            $user_lead = ORM::factory('leaderboard')->where('user_id', '=', $u->id)->find();
            if ($user_lead->loaded()) {
                array_push($user_array, array("user_id" => $user_lead->user_id, "name" => $user_lead->name, "picture" => $user_lead->picture, "score" => $user_lead->score));
            }
        }
        $errors = array_filter($user_array);
        if (!empty($errors)) {
            usort($user_array, array($this, "sort_my_array"));
            $user_array = array_slice($user_array, 0, 10);
            $convert = json_encode($user_array);
            print $convert;
        } else {
            return false;
        }

    }

    public
    function sort_my_array($a, $b)
    {
        return $b['score'] - $a['score'];
    }


} // End Game
