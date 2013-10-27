<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function index() {
        echo "This is the index page";
    }

    public function signup($error = NULL) {
        # Setup view
        $output = $this->template;
        $output->title   = "Sign Up";
        $output->contentLeft = View::instance('v_index_index');
        $output->contentRight = View::instance('v_users_signup');
        $output->contentRight->error = $error;

        # Set client files within the header and body
        $client_files_head = Array("/css/form.css","/css/layout_short.css");
        $output->client_files_head = Utils::load_client_files($client_files_head);  
        $client_files_body = Array("/js/form.js");
        $output->client_files_body = Utils::load_client_files($client_files_body);

        echo $output;

    }

    public function p_signup() {

        $validForm;

        foreach($_POST as $k=>$v) {
            if(!$this->validateFields($k, $v)){
                $validForm = false;
            }
            else {
                $validForm = true;
            }
        }

        if(!$validForm) {
            Router::redirect("/users/signup/error");
        }
        else {
            # More data we want stored with the user
            $_POST['created']  = Time::now();
            $_POST['modified'] = Time::now();

            # Encrypt the password  
            $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);            

            # Create an encrypted token for user's sessions
            $_POST['token'] = sha1(TOKEN_SALT.$_POST['user_name'].Utils::generate_random_string()); 

            # Insert this user into the database
            $user_id = DB::instance(DB_NAME)->insert('users', $_POST); 

            Router::redirect("/users/login/");
        }
    }

    public function login($error = NULL) {
        # Setup view
        $output = $this->template;
        $output->title = "Login";
        $output->contentLeft = View::instance('v_index_index');
        $output->contentRight = View::instance('v_users_login');
        $output->contentRight->error = $error;

        # Set client files within the header and body
        $client_files_head = Array("/css/form.css","/css/layout_short.css");
        $output->client_files_head = Utils::load_client_files($client_files_head);  
        $client_files_body = Array("/js/form.js");
        $output->client_files_body = Utils::load_client_files($client_files_body);

        echo $output;
    }

    public function p_login() {
        # Sanitize the user entered data
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # Hash submitted password so we can compare it against one in the db
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        # Search the db for this username and password, retrieve token
        $q = "SELECT token 
            FROM users 
            WHERE user_name = '".$_POST['user_name']."' 
            AND password = '".$_POST['password']."'";

        $token = DB::instance(DB_NAME)->select_field($q);

        #redirect with error if token failed, otherwise redirect to user profile
        if(!$token) {
            Router::redirect("/users/login/error");             
        } else {
            setcookie("token", $token, strtotime('+1 year'), '/');
            Router::redirect("/posts/index");
        }

}

    public function logout() {
        # Generate and save a new token for next login
        $new_token = sha1(TOKEN_SALT.$this->user->user_name.Utils::generate_random_string());
        $data = Array("token" => $new_token);
        DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

        # Delete token cookie
        setcookie("token", "", strtotime('-1 year'), '/');

        # Send them back to the main index.
        Router::redirect("/");
    }

    public function profile($user_name = NULL) {

        if(!$this->user) {
            Router::redirect('/users/login');
        }

        $output = $this->template;
        $output->title = "Profile";
        $output->content = View::instance('v_users_profile');        

        #use user name from URL param if present, otherwise use info for currently logged in user
        if($user_name) {
            $output->content->user_name = $user_name;    
        }
        elseif ($this->user) {
            $currUser = $this->user;
            $output->content->user = $currUser;
            $output->content->user_name = $currUser->user_name;
            $output->content->email = $currUser->email;
            $output->content->first_name = $currUser->first_name;
            $output->content->profile_pic = $currUser->profile_pic;
            $output->content->last_name = $currUser->last_name;
        }
        else {
            $output->content->user_name = NULL;
        }

        # Set client files within the header and body
        $client_files_head = Array("/css/form.css","/css/layout_tall.css","/css/profile.css");
        $output->client_files_head = Utils::load_client_files($client_files_head);  
        $client_files_body = Array("/js/profile.min.js");
        $output->client_files_body = Utils::load_client_files($client_files_body);

        echo $output;

    }

    public function validateLength($fieldValue, $max, $min) {
        return strlen($fieldValue) > 5 && strlen($fieldValue) < 16;
    }

    public function validateEmailFormat($fieldValue) {
        return preg_match('/.+@.+\..{2,}/', $fieldValue);
    }

    public function validateAlphaNum($fieldValue) {
        return !preg_match('/.*[^\w].*/', $fieldValue);
    }

    public function validatePWChars($fieldValue) {
        return preg_match('/[0-9]/', $fieldValue) && preg_match('/[A-Za-z]/', $fieldValue);
    }


    public function validateFields($field,$value) {
        if($field == 'user_name') {
            return  $this->validateLength($value, 5, 16) && 
                    $this->validateAlphaNum($value);
        }
        elseif($field == 'email') {
            return  $this->validateEmailFormat($value);     
        }
        elseif($field == 'first_name') {
            return  $this->validateLength($value, 1, 25);     
        }
        elseif($field == 'last_name') {
            return  $this->validateLength($value, 1, 25);     
        }
        elseif($field == 'password') {
            return  $this->validateLength($value, 5, 16) &&
                    $this->validatePWChars($value) &&
                    $this->validateAlphaNum($value); 
        }
        else {
            return false;
        }
    }

} # end of the class