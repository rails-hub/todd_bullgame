<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Leaderboard extends ORM
{

    public function rules()
    {
        return array(
            'user_id' => array(
                array('not_empty')
            ),
            'score' => array(
                array('not_empty')
            )
        );
    }

    public function create_leaderboard($user)
    {
        $leaderboard = ORM::factory('leaderboard')->where('user_id', '=', $user->id)->find();
        if ($leaderboard->loaded()) {
            if ($user->score > $leaderboard->score) {
                $leaderboard->score = $user->score;
                $leaderboard->update();
            }
        } else {
            $this->user_id = $user->id;
            $this->score = $user->score;
            $this->save();
        }
    }

    public function update_leaderboard($leaderboard, $name, $picture)
    {
        $leaderboard->name = $name;
        $leaderboard->picture = $picture;
        $leaderboard->update();
    }

    public function create_update_lead($id, $name, $picture)
    {
        $already = ORM::factory('leaderboard')->where('user_id', '=', $id)->find();
        if ($already->loaded()) {
            $already->name = $name;
            $already->picture = $picture;
            $already->update();
        } else {
            $this->user_id = $id;
            $this->score = 0;
            $this->name = $name;
            $this->picture = $picture;
            $this->save();
        }
    }


} // End  Leaderboard
