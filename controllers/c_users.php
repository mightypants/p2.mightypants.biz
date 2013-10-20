<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function index() {
        echo "This is the index page";
    }

    public function signup() {

        # Setup view
        $output = $this->template;
        $output->title   = "Sign Up";
        $output->contentLeft = View::instance('v_index_index');
        $output->contentRight = View::instance('v_users_signup');
        

        $client_files_head = Array("/css/form.css");
        $output->client_files_head = Utils::load_client_files($client_files_head);  

        # Set client files that need to load before the closing </body> tag
        $client_files_body = Array("/js/form.js");
        $output->client_files_body = Utils::load_client_files($client_files_body);

        # Render template
        echo $output;

    }

    public function p_signup() {

        # Dump out the results of POST to see what the form submitted
        // print_r($_POST);
        # More data we want stored with the user
        $_POST['created']  = Time::now();
        $_POST['modified'] = Time::now();

        # Encrypt the password  
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);            

        # Create an encrypted token via their email address and a random string
        $_POST['token'] = sha1(TOKEN_SALT.$_POST['user_name'].Utils::generate_random_string()); 

        # Insert this user into the database
        $user_id = DB::instance(DB_NAME)->insert('users', $_POST);

        # For now, just confirm they've signed up - 
        # You should eventually make a proper View for this
        echo 'You\'re signed up';  

        //TODO: redirect to profile      
    }

    public function login($error = NULL) {
        $output = $this->template;
        $output->title = "Login";
        $output->contentLeft = View::instance('v_index_index');
        $output->contentRight = View::instance('v_users_login');
        $output->contentRight->error = $error;

        $client_files_head = Array("/css/form.css");
        $output->client_files_head = Utils::load_client_files($client_files_head);  

        # Set client files that need to load before the closing </body> tag
        $client_files_body = Array("/js/form.js");
        $output->client_files_body = Utils::load_client_files($client_files_body);

        echo $output;
    }

    public function p_login() {
    # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
    $_POST = DB::instance(DB_NAME)->sanitize($_POST);

    # Hash submitted password so we can compare it against one in the db
    $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

    # Search the db for this email and password
    # Retrieve the token if it's available
    $q = "SELECT token 
        FROM users 
        WHERE user_name = '".$_POST['user_name']."' 
        AND password = '".$_POST['password']."'";

    $token = DB::instance(DB_NAME)->select_field($q);

    # If we didn't find a matching token in the database, it means login failed
    if(!$token) {

        # Send them back to the login page
        Router::redirect("/users/login/error"); 
        
    # But if we did, login succeeded! 
    } else {
        
        setcookie("token", $token, strtotime('+1 year'), '/');
        Router::redirect("/users/profile");
    }

}

    public function logout() {
        # Generate and save a new token for next login
        $new_token = sha1(TOKEN_SALT.$this->user->user_name.Utils::generate_random_string());

        # Create the data array we'll use with the update method
        # In this case, we're only updating one field, so our array only has one entry
        $data = Array("token" => $new_token);

        # Do the update
        DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

        # Delete their token cookie by setting it to a date in the past - effectively logging them out
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

        if($user_name) {
            $output->content->user_name = $user_name;    
        }
        elseif ($this->user) {
            $output->content->user_name = $this->user->user_name;
        }
        else {
            $output->content->user_name = NULL;
        }

         #  Set client files that need to load in the <head>
        $client_files_head = Array("/css/profile.css");
        $output->client_files_head = Utils::load_client_files($client_files_head);  

        # Set client files that need to load before the closing </body> tag
        $client_files_body = Array("/js/profile.min.js");
        $output->client_files_body = Utils::load_client_files($client_files_body);

        # Render View
        echo $output;

    }

} # end of the class