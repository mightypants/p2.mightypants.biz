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
        $output->content = View::instance('v_users_signup');
        $output->title   = "Sign Up";

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
        $_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string()); 

        # Insert this user into the database
        $user_id = DB::instance(DB_NAME)->insert('users', $_POST);

        # For now, just confirm they've signed up - 
        # You should eventually make a proper View for this
        echo 'You\'re signed up';         
    }

    public function login() {
        $output = $this->template;
        $output->title = "Login";
        $output->content = View::instance('v_users_login');  

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
        Router::redirect("/users/login/");

    # But if we did, login succeeded! 
    } else {

        /* 
        Store this token in a cookie using setcookie()
        Important Note: *Nothing* else can echo to the page before setcookie is called
        Not even one single white space.
        param 1 = name of the cookie
        param 2 = the value of the cookie
        param 3 = when to expire
        param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
        */
        setcookie("token", $token, strtotime('+1 year'), '/');

        # Send them to the main page - or whever you want them to go
        Router::redirect("/");

    }

}

    public function logout() {
        echo "This is the logout page";
    }

    public function profile($user_name = NULL) {

        $output = $this->template;
        $output->title = "Profile";
        $output->content = View::instance('v_users_profile');        

        # Pass information to the view fragment
        $output->content->user_name = $user_name;

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