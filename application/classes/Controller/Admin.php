<?php defined('SYSPATH') or die('No direct script access.');
require_once Kohana::find_file('vendor', 'mailer/lib/swift_required');
require_once Kohana::find_file('vendor', 'mailer/lib/swift_init');

class Controller_Admin extends Controller_Template
{
    public $template = 'template';
    protected $_session;
    protected $_user = null;

    protected $_config;

    public function before()
    {
        $this->auth = Auth::instance();
        if (in_array($this->request->action(), array('index', 'admin_user', 'delete', 'add', 'users', 'delete_user', 'users', 'categories', 'category', 'add_category', 'delete_category', 'facts', 'fact', 'add_fact', 'delete_fact', 'export_users'))) {
            if (!$this->logged_in()) {
                HTTP::redirect("/admin/sign_in");
            }
        }
        parent::before();
    }

    public function action_sign_in()
    {
        if (Auth::instance()->logged_in()) {
            HTTP::redirect('admin/index');
        } else {
            $this->template->current_user = $this->_user;
            $this->template->content = View::factory('admin/sign_in')
                ->bind("current_user", $this->_user)
                ->bind('message', $message);


            if (HTTP_Request::POST == $this->request->method()) {
                // Attempt to login user
                $remember = array_key_exists('remember', $this->request->post()) ? (bool)$this->request->post('remember') : FALSE;
                $user = $this->_admin_login($this->request->post('email'), $this->request->post('password'), $remember);

                // If successful, redirect user to index
                if ($user) {
                    $get_user = Auth::instance()->get_user();
                    HTTP::redirect('admin/index');

                } else {
                    $message = 'Login failed';
                }
            }
        }
    }

    protected function _admin_login($user, $password, $remember)
    {
        if (!is_object($user)) {
            $username = $user;

            // Load the user
            $user = ORM::factory('admin');
            $user->where($user->unique_key($username), '=', $username)->find();
        }

        if (is_string($password)) {
            // Create a hashed password
            $password = $this->hash($password);
        }

        // If the passwords match, perform a login
        if ($user->password === $password) {
            if ($remember === TRUE) {
                // Token data
                $data = array(
                    'user_id' => $user->pk(),
                    'expires' => time() + $this->_config['lifetime'],
                    'user_agent' => sha1(Request::$user_agent),
                );

            }

            // Finish the login
            $session = Session::instance();
            $session->set('signed_in', $user->id);

            return TRUE;
        }

        // Login failed
        return FALSE;
    }

    public function action_index()
    {
        $this->template->current_user = $this->_user;
        $admin_users = ORM::factory('admin')->find_all();
        $this->template->content = View::factory("admin/index")
            ->bind("current_user", $this->_user)
            ->bind("admin_users", $admin_users)
            ->bind("message", $message);
    }

    public function action_admin_user()
    {
        $id = $this->request->param('id');
        $admin = ORM::factory('admin')->where('id', '=', $id)->find();

        $this->template->current_user = $this->_user;
        $this->template->content = View::factory("admin/admin_user")
            ->bind('errors', $errors)
            ->bind("current_user", $this->_user)
            ->bind("admin", $admin)
            ->bind("message", $message);

        if (HTTP_Request::POST == $this->request->method()) {
            try {

                // update the user using form values
                $user = ORM::factory('admin')->update_admin($admin, $this->request);
                if ($user) {
                    $message = "Admin user updated successfully.";

                } else {
                    $message = "Rules: Provide a valid and Unique Email. Password must be of (6-32) characters and confirmation message must match.";
                }


            } catch (ORM_Validation_Exception $e) {

                // Set failure message
                $message = 'There were errors, please see form below.';

                // Set errors using custom messages
                $errors = $e->errors('models');
            }
        }
    }

    public function action_delete()
    {
        $id = $this->request->param('id');
        $admin = ORM::factory('admin')->where('id', '=', $id)->find();
        if ($admin->loaded()) {
            $admin->delete();
            HTTP::redirect('admin/index');
        } else {
            HTTP::redirect('admin/index');
        }
    }

    public function action_delete_user()
    {
        $id = $this->request->param('id');
        $user = ORM::factory('user')->where('id', '=', $id)->find();
        if ($user->loaded()) {
            $upoint = ORM::factory('upoint')->where('user_id', '=', $id)->find();
            $upoints = ORM::factory('upoint')->where('user_id', '=', $id)->find_all();
            if ($upoint->loaded()) {
                foreach ($upoints as $p) {
                    $p->delete();
                }
            }
            $lead = ORM::factory('leaderboard')->where('user_id', '=', $id)->find();
            if ($lead->loaded()) {
                $lead->delete();
            }
            $user->delete();
            HTTP::redirect('admin/users');
        } else {
            HTTP::redirect('admin/users');
        }
    }

    public function action_add()
    {
        $this->template->current_user = $this->_user;
        $admin_users = ORM::factory('admin')->where('id', '!=', $this->_user->id)->find_all();
        $this->template->content = View::factory("admin/add")
            ->bind('errors', $errors)
            ->bind("current_user", $this->_user)
            ->bind("admin_users", $admin_users)
            ->bind("message", $message);

        if (HTTP_Request::POST == $this->request->method()) {
            try {

                // Create the user using form values
                $user = ORM::factory('admin')->create_admin($this->request);
                if ($user) {
                    $message = "Admin user created successfully.";

                } else {
                    $message = "Rules: Provide a valid and Unique Email. Password must be of (6-32) characters and confirmation message must match.";
                }
//                HTTP::redirect('admin/index');


            } catch (ORM_Validation_Exception $e) {

                // Set failure message
                $message = 'There were errors, please see form below.';

                // Set errors using custom messages
                $errors = $e->errors('models');
            }
        }
    }

    public function action_users()
    {
        $this->template->current_user = $this->_user;
        $admin_users = ORM::factory('user')->find_all();
        $this->template->content = View::factory("admin/users")
            ->bind("current_user", $this->_user)
            ->bind("users", $admin_users)
            ->bind("message", $message);

    }

    public function action_categories()
    {
        $this->template->current_user = $this->_user;
        $categories = ORM::factory('category')->find_all();
        $this->template->content = View::factory("admin/categories")
            ->bind("current_user", $this->_user)
            ->bind("categories", $categories)
            ->bind("message", $message);

    }

    public function action_category()
    {
        $id = $this->request->param('id');
        $this->template->current_user = $this->_user;
        $category = ORM::factory('category')->where('id', '=', $id)->find();
        $this->template->content = View::factory("admin/category")
            ->bind("current_user", $this->_user)
            ->bind("category", $category)
            ->bind("message", $message);
        if (HTTP_Request::POST == $this->request->method()) {
            try {
                $update_cat = ORM::factory('category')->update_category($category, $this->request);
                $message = "Updated Successfully";

            } catch (ORM_Validation_Exception $e) {

                // Set failure message
                $message = 'There were errors, please see form below.';

                // Set errors using custom messages
                $messag = $e->errors('models');
                $message = $messag["title"];
            }
        }
    }

    public function action_add_category()
    {
        $this->template->current_user = $this->_user;
        $this->template->content = View::factory("admin/add_category")
            ->bind("current_user", $this->_user)
            ->bind("message", $message);
        if (HTTP_Request::POST == $this->request->method()) {
            try {
                $update_cat = ORM::factory('category')->create_category($this->request);
                $message = "Added Successfully";

            } catch (ORM_Validation_Exception $e) {

                // Set failure message
                $message = 'There were errors, please see form below.';

                // Set errors using custom messages
                $messag = $e->errors('models');
                $message = $messag["title"];
            }
        }
    }

    public function action_delete_category()
    {
        $id = $this->request->param('id');
        $this->template->current_user = $this->_user;
        $category = ORM::factory('category')->where('id', '=', $id)->find();
        $fact = ORM::factory('fact')->where('category_id', '=', $category->id)->find();
        $facts = ORM::factory('fact')->where('category_id', '=', $category->id)->find_all();
        if ($fact->loaded()) {
            foreach ($facts as $f) {
                $f->delete();
            }
        }
        $upoint = ORM::factory('upoint')->where('category_id', '=', $category->id)->find();
        $upoints = ORM::factory('upoint')->where('category_id', '=', $category->id)->find_all();
        if ($upoint->loaded()) {
            foreach ($upoints as $f) {
                $f->delete();
            }
        }
        $category->delete();
        HTTP::redirect('/admin/categories');

    }

    public function action_facts()
    {
        $this->template->current_user = $this->_user;
        $facts = ORM::factory('fact')->find_all();
        $this->template->content = View::factory("admin/facts")
            ->bind("current_user", $this->_user)
            ->bind("facts", $facts)
            ->bind("message", $message);

    }

    public function action_fact()
    {
        $id = $this->request->param('id');
        $this->template->current_user = $this->_user;
        $fact = ORM::factory('fact')->where('id', '=', $id)->find();
        $categories = ORM::factory('category')->find_all();
        $this->template->content = View::factory("admin/fact")
            ->bind("current_user", $this->_user)
            ->bind("categories", $categories)
            ->bind("fact", $fact)
            ->bind("message", $message);
        if (HTTP_Request::POST == $this->request->method()) {
            try {
                $update_fact = ORM::factory('fact')->update_fact($fact, $this->request);
                $message = "Updated Successfully";

            } catch (ORM_Validation_Exception $e) {

                // Set failure message
                $message = 'There were errors, please see form below.';

                // Set errors using custom messages
                $messag = $e->errors('models');
                $message = $messag["title"];
            }
        }
    }

    public function action_add_fact()
    {
        $this->template->current_user = $this->_user;
        $categories = ORM::factory('category')->find_all();
        $this->template->content = View::factory("admin/add_fact")
            ->bind("current_user", $this->_user)
            ->bind("categories", $categories)
            ->bind("message", $message);
        if (HTTP_Request::POST == $this->request->method()) {
            try {
                $update_cat = ORM::factory('fact')->create_fact($this->request);
                $message = "Added Successfully";

            } catch (ORM_Validation_Exception $e) {

                // Set failure message
                $message = 'There were errors, please see form below.';

                // Set errors using custom messages
                $messag = $e->errors('models');
                $message = $messag["title"];
            }
        }
    }

    public function action_delete_fact()
    {
        $id = $this->request->param('id');
        $this->template->current_user = $this->_user;
        $fact = ORM::factory('fact')->where('id', '=', $id)->find();
        $upoint = ORM::factory('upoint')->where('category_id', '=', $fact->category_id)->find();
        $upoints = ORM::factory('upoint')->where('category_id', '=', $fact->category_id)->find_all();

        if ($upoint->loaded()) {
            foreach ($upoints as $f) {
                $f->delete();
            }
        }
        $fact->delete();
        HTTP::redirect('/admin/facts');
    }

    public function action_export_users()
    {
        $id = $this->request->param('id');
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=bullgaame_users.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        $data = array();
        $users = ORM::factory('user')->find_all();
        array_push($data, array("Facebook ID", "Name", "Email"));
        foreach ($users as $id) {
            $devData = array();
            array_push($devData, $id->udid);
            array_push($devData, $id->name);
            array_push($devData, $id->email);
            array_push($data, $devData);
        }
        $this->outputCSV($data);
        die();

    }

    public function action_logout()
    {
        $session = Session::instance();
        $session->set('signed_in', null);
        HTTP::redirect('/admin/index');

    }

    function outputCSV($data)
    {
        $output = fopen("php://output", "w");
        foreach ($data as $row) {
            fputcsv($output, $row); // here you can change delimiter/enclosure
        }
        fclose($output);
    }


    /**
     * Creates a hashed hmac password from a plaintext password. This
     * method is deprecated, [Auth::hash] should be used instead.
     *
     * @deprecated
     * @param  string $password Plaintext password
     */
    public
    function hash_password($password)
    {
        return $this->hash($password);
    }


    /**
     * Perform a hmac hash, using the configured method.
     *
     * @param   string $str string to hash
     * @return  string
     */
    public
    function hash($str)
    {
        $hash_key = Kohana::$config->load('auth')->get('hash_key');
        $hash_method = Kohana::$config->load('auth')->get('hash_method');
        if (!$hash_key)
            throw new Kohana_Exception('A valid hash key must be set in your auth config.');

        return hash_hmac($hash_method, $str, $hash_key);
    }

    protected
    function logged_in()
    {
        $session = Session::instance();
        $id = $session->get('signed_in');
        if ($session && $session != null) {
            $_user = ORM::factory('admin')->where('id', '=', $id)->find();
            if ($_user->loaded()) {
                $this->_user = $_user;
                return $_user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}