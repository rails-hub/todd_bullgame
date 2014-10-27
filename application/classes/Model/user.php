<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_User extends ORM
{

    public function rules()
    {
        return array(
            'name' => array(
                array('not_empty')
            ),
            'udid' => array(
                array('not_empty')
            ),
            'email' => array(
                array('not_empty')
            )
        );
    }

    public function create_user($name, $udid, $email)
    {
        $user = ORM::factory('user')->where('udid', '=', $udid)->find();
        if ($user->loaded()) {
            $user->score = 0;
            $user->update();
            return $user;
        } else {
            try {
                $this->name = $name;
                $this->udid = $udid;
                $this->email = $email;
                $user = $this->save();
                return $user;
            } catch
            (ORM_Validation_Exception $e) {
                $errors = $e->errors();
                return false;
            }
        }
    }

} // End  User
