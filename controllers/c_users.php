<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function signup($message = NULL) {
        # Setup view
        $output = $this->template;
        $output->title   = "Sign Up";
        $output->contentLeft = View::instance('v_index_index');
        $output->contentRight = View::instance('v_users_signup');
        $output->contentRight->message = $message;

        # Set client files within the header and body
        $client_files_head = Array("/css/form.css","/css/layout_short.css");
        $output->client_files_head = Utils::load_client_files($client_files_head);  
        $client_files_body = Array("/js/form.js");
        $output->client_files_body = Utils::load_client_files($client_files_body);

        echo $output;

    }

    public function p_signup() {
        //check to see if username or e-mail are already taken
        $user_exists = DB::instance(DB_NAME)->select_field("SELECT user_name FROM users WHERE user_name = '" . $_POST['user_name'] . "'");
        $email_exists = DB::instance(DB_NAME)->select_field("SELECT email FROM users WHERE email = '" . $_POST['email'] . "'");

        //check that all form fields are valid
        $formErrors = array();
        foreach($_POST as $k=>$v) {
            if(!$this->validateFields($k, $v)){
                array_push($formErrors, $k);
            }          
        }

        if ($user_exists || $email_exists) {
            Router::redirect("/users/signup/user_exists");
        }
        elseif (!empty($formErrors)) {
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
            Router::redirect("/users/login/success");
        }
    }

    public function login($message = NULL) {
        # Setup view
        $output = $this->template;
        $output->title = "Login";
        $output->contentLeft = View::instance('v_index_index');
        $output->contentRight = View::instance('v_users_login');
        $output->contentRight->message = $message;

        # Set client files within the header and body
        $client_files_head = Array("/css/form.css","/css/layout_short.css");
        $output->client_files_head = Utils::load_client_files($client_files_head);  

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
            Router::redirect('/users/login/access_denied');
        }

        $output = $this->template;
        $output->title = $this->user->user_name. " - Profile";
        $output->content = View::instance('v_users_profile');        

        #use user name from URL param if present, otherwise use info for currently logged in user
        if($user_name) {
            $output->content->user_name = $user_name;  
            $q = "SELECT *
              FROM users
              WHERE user_name = '$user_name' ";
            # Run the query
            $user_info = DB::instance(DB_NAME)->select_rows($q); 

            $output->content->user_name = $user_name;
            $output->content->email = $user_info[0]['email'];
            $output->content->first_name = $user_info[0]['first_name'];
            $output->content->profile_pic = $user_info[0]['profile_pic'];
            $output->content->last_name = $user_info[0]['last_name'];
            $output->content->hometown = $user_info[0]['hometown'];
            $output->content->age = $user_info[0]['age'];
            $output->content->about = $user_info[0]['about'];
        }
        elseif ($this->user) {
            $currUser = $this->user;
            $output->content->user = $currUser;
            $output->content->user_name = $currUser->user_name;
            $output->content->email = $currUser->email;
            $output->content->first_name = $currUser->first_name;
            $output->content->profile_pic = $currUser->profile_pic;
            $output->content->last_name = $currUser->last_name;
            $output->content->hometown = $currUser->hometown;
            $output->content->age = $currUser->age;
            $output->content->about = $currUser->about;
            $output->content->loggedInUser = true;
        }
        else {
            $output->content->user_name = NULL;
        }

        # Set client files within the header and body
        $client_files_head = Array("/css/form.css","/css/layout_tall.css","/css/profile.css");
        $output->client_files_head = Utils::load_client_files($client_files_head);  

        echo $output;

    }

    public function edit_profile($error=NULL) {

        if(!$this->user) {
            Router::redirect('/users/login/access_denied');
        }

        $output = $this->template;
        $output->title = $this->user->user_name. " - Profile";
        $output->content = View::instance('v_users_edit_profile');        

        $currUser = $this->user;
        $output->content->user = $currUser;
        $output->content->profile_pic = $currUser->profile_pic;
        $output->content->user_name = $currUser->user_name;
        $output->content->email = $currUser->email;
        $output->content->first_name = $currUser->first_name;
        $output->content->profile_pic = $currUser->profile_pic;
        $output->content->last_name = $currUser->last_name;
        $output->content->hometown = $currUser->hometown;
        $output->content->age = $currUser->age;
        $output->content->about = $currUser->about;
        $output->content->error = $error;

        # Set client files within the header and body
        $client_files_head = Array("/css/layout_tall.css","/css/form.css","/css/profile.css");
        $output->client_files_head = Utils::load_client_files($client_files_head);  
        $client_files_body = Array("/js/form.js");
        $output->client_files_body = Utils::load_client_files($client_files_body);

        echo $output;   
    }

    public function p_edit_profile() {

        //check that all form fields are valid
        $formErrors = array();
        foreach($_POST as $k=>$v) {
            if(!$this->validateFields($k, $v)){
                array_push($formErrors, $k);
            }          
        }

        if(!empty($formErrors)) {
            Router::redirect('/users/edit_profile/error');
        }
        else {
            DB::instance(DB_NAME)->update("users", $_POST, "WHERE user_id = '".$this->user->user_id."'");
            Router::redirect("/users/profile");
        }

    }

    public function profile_short() {

        $output = $this->template;
        $output->contentLeft = View::instance('v_users_profile_short');        

        $output->contentLeft->user_name = $this->user->user_name;
        $output->contentLeft->profile_pic = $this->user->profile_pic;

        return $output->contentLeft;

    }

    public function validateLength($fieldValue, $min, $max) {
        return strlen($fieldValue) > $min && strlen($fieldValue) < $max;
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

    public function validateNumOnly($fieldValue) {
        return !preg_match('/.*[^0-9].*/', $fieldValue);
    }

    public function validateFields($field,$value) {
        if($field == 'user_name') {
            return  $this->validateLength($value, 5, 16) && 
                    $this->validateAlphaNum($value);
        }
        if($field == 'email') {
            return  $this->validateEmailFormat($value);     
        }
        elseif($field == 'first_name') {
            return  $this->validateLength($value, 0, 25);     
        }
        elseif($field == 'last_name') {
            return  $this->validateLength($value, 0, 25);     
        }
        elseif($field == 'age') {
            return  $this->validateLength($value, 0, 4); //&&
                    //$this->validateNumOnly($value);     
        }
        elseif($field == 'hometown') {
            return  $this->validateLength($value, 1, 25);     
        }
        elseif($field == 'about') {
            return  $this->validateLength($value, 0, 900);     
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