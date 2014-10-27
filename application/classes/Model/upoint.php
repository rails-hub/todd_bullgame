<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Upoint extends ORM
{

    public function rules()
    {
        return array(
            'category_id' => array(
                array('not_empty')
            ),
            'score' => array(
                array('not_empty')
            )
        );
    }

    public function create_upoint($fact, $user_id, $point)
    {
        $user = ORM::factory('user')->where('udid', '=', $user_id)->find();
        if ($user->loaded()) {
            try {
                $upoint = ORM::factory('upoint')->where('category_id', '=', $fact->category_id)->and_where('user_id', '=', $user->id)->find();
                if ($upoint->loaded()) {
                    $upoint->category_id = $fact->category_id;
                    if ($fact->is_true) {
                        $upoint->score = $upoint->score - $point->guess_wrong;
                    } else {
                        $upoint->score = $upoint->score + $point->guess_right;
                    }
                    $upoint->user_id = $user->id;
                    $result = $upoint->update();
                    return $result;
                } else {
                    $this->category_id = $fact->category_id;
                    if ($fact->is_true) {
                        $this->score = -$point->guess_wrong;
                    } else {
                        $this->score = $point->guess_right;
                    }
                    $this->user_id = $user->id;
                    $result = $this->save();
                    return $result;
                }
            } catch
            (ORM_Validation_Exception $e) {
                $errors = $e->errors();
                return false;
            }
        } else {
            return false;
        }
    }

} // End  Upoint
