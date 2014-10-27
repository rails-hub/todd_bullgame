<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Admin extends ORM
{

    public function rules()
    {
        return array(
            'password' => array(
                array('not_empty')
            ),
            'email' => array(
                array('not_empty'),
                array('email'),
                array(array($this, 'unique'), array('email', ':value')),
            )
        );
    }

    public function unique_key($value)
    {
        return Valid::email($value) ? 'email' : 'email';
    }


    public function create_admin($request)
    {

        if ($request->post("password") === ($request->post("password_confirm")) && (strlen($request->post("password") >= 6 && strlen($request->post("password")) < 32))) {
            $this->email = $request->post("email");
            $this->password = $this->hash($request->post("password"));
            $this->save();
            return true;
        } else {
            return false;
        }
    }

    public function update_admin($admin, $request)
    {

        if ($request->post("password") === ($request->post("password_confirm")) && (strlen($request->post("password") >= 6 && strlen($request->post("password")) < 32))) {
            $already = ORM::factory('admin')->where('email', '=', $request->post("email"))->find();
            if ($already->loaded()) {
                return false;
            } else {
                $admin->email = $request->post("email");
                $admin->password = $this->hash($request->post("password"));
                $admin->update();
                return true;
            }

        } else {
            return false;
        }
    }


    public
    function hash($str)
    {
        $hash_key = Kohana::$config->load('auth')->get('hash_key');
        $hash_method = Kohana::$config->load('auth')->get('hash_method');
        if (!$hash_key)
            throw new Kohana_Exception('A valid hash key must be set in your auth config.');

        return hash_hmac($hash_method, $str, $hash_key);
    }


} // End  Admin
