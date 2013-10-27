<?php

class posts_controller extends base_controller {

    public function __construct() {
        parent::__construct();

        # Make sure user is logged in if they want to use anything in this controller
        if(!$this->user) {
            die("Members only. <a href='/users/login'>Login</a>");
        }
    }

    public function add() {

        # Setup view
        $output = $this->template;
        $output->content = View::instance('v_posts_add');
        $output->title   = "New Post";

        $client_files_head = Array("/css/form.css","/css/layout_tall.css");
        $output->client_files_head = Utils::load_client_files($client_files_head);  

        # Set client files that need to load before the closing </body> tag
        $client_files_body = Array("/js/form.js");
        $output->client_files_body = Utils::load_client_files($client_files_body);

        # Render template
        echo $output;

    }

    public function p_add() {
        
        $newPost = $_POST['content'];
           
        if(strlen($newPost) > 0) {
            # Associate this post with this user
            $_POST['user_id']  = $this->user->user_id;

            # Unix timestamp of when this post was created / modified
            $_POST['created']  = Time::now();
            $_POST['modified'] = Time::now();

            # Insert
            # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
            DB::instance(DB_NAME)->insert('posts', $_POST);

            Router::redirect("/posts/index/success");
        }
        else {
        Router::redirect("/posts/index/error");
        }
    }

    public function index($message = NULL) {

        # Set up the View, including posts and curr user profile
        $output = $this->template;
        
        $output->contentLeft = View::instance('v_users_profile_short');
        #$output->contentLeftBot = View::instance('v_posts_users');
        $output->contentLeft->email = $this->user->email;
        $output->contentLeft->user_name = $this->user->user_name;
        $output->contentLeft->profile_pic = $this->user->profile_pic;        
        
        $output->contentRight = View::instance('v_posts_index');
        
        if($message == 'error'){
            $output->contentRight->message = "Your post contains no content.  This confuses us.";
        }
        elseif($message == 'success'){
            $output->contentRight->message = "Post added.";
        }
        $output->contentRight->message = $message;
        $output->title   = "Posts";

        # Build the query
        $q = "SELECT p.*, u.user_name, u.profile_pic_sm FROM posts p JOIN users u ON p.user_id=u.user_id ORDER BY p.created DESC";

        # Run the query
        $posts = DB::instance(DB_NAME)->select_rows($q);

        # Pass data to the View
        $output->contentRight->posts = $posts;

        $client_files_head = Array("/css/layout_tall.css","/css/form.css","/css/post.css");
        $output->client_files_head = Utils::load_client_files($client_files_head); 

        # Render the View
        echo $output;

    }

    public function users() {

        $output = $this->template;
        $output->content = View::instance("v_posts_users");
        $output->title   = "Users";

        # Build the query to get all the users
        $q = "SELECT *
            FROM users";

        # Execute the query to get all the users. 
        # Store the result array in the variable $users
        $users = DB::instance(DB_NAME)->select_rows($q);

        # Build the query to figure out who the current user follows
        $q = "SELECT * 
            FROM users_users
            WHERE user_id = ".$this->user->user_id;

        # return users followed
        $connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');

        # Pass data (users and connections) to the view
        $output->content->users       = $users;
        $output->content->connections = $connections;

        $client_files_head = Array("/css/post.css","/css/layout_tall.css");
        $output->client_files_head = Utils::load_client_files($client_files_head); 

        # Render the view
        echo $output;
    }

    public function follow($user_id_followed) {

    # Prepare the data array to be inserted
        $data = Array(
            "created" => Time::now(),
            "user_id" => $this->user->user_id,
            "user_id_followed" => $user_id_followed
            );

        # Do the insert
        DB::instance(DB_NAME)->insert('users_users', $data);

        # Send them back
        Router::redirect("/posts/users");

    }

    public function unfollow($user_id_followed) {

        # Delete this connection
        $where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
        DB::instance(DB_NAME)->delete('users_users', $where_condition);

        # Send them back
        Router::redirect("/posts/users");

    }
}

