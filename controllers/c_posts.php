<?php

class posts_controller extends base_controller {

    public function __construct() {
        parent::__construct();

        if(!$this->user) {
            Router::redirect('/users/login/access_denied');
        }
    }

    public function p_add() {
        
        $newPost = $_POST['content'];
           
        if(strlen($newPost) > 0) {
            # Associate this post with this user
            $_POST['user_id']  = $this->user->user_id;

            # Unix timestamp of when this post was created / modified
            $_POST['created']  = Time::now();
            $_POST['modified'] = Time::now();

            #add new post to the database
            DB::instance(DB_NAME)->insert('posts', $_POST);

            Router::redirect("/posts/index/success");
        }
        else {
            Router::redirect("/posts/index/error");
        }
    }

    public function index($message = NULL) {
        #force the user to follow own posts
        $this->follow_self();
        
        # Set up the View, including posts and curr user profile
        $output = $this->template;
        
        #call profile_short method to return basic user info to go in dashboard page
        $profile = new users_controller();
        $output->contentLeft = $profile->profile_short();        
        
        #get lisf of users to display in left sidebar
        $output->contentLeftBot = $this->users();       
        
        #setup main window/posts view
        $output->contentRight = View::instance('v_posts_index');
        $output->contentRight->currUserID = $this->user->user_id;
        $output->contentRight->message = $message;
        $output->title   = $this->user->user_name . " - Dashboard";

        # Build the query
        $q = 'SELECT
                p.content,
                p.created,
                p.user_id,
                p.post_id,
                u.user_name,
                u.profile_pic_sm
              FROM posts p
              INNER JOIN users_users uu
              ON p.user_id = uu.user_id_followed
              INNER JOIN users u
              ON p.user_id = u.user_id
              WHERE uu.user_id = '.$this->user->user_id . ' 
              ORDER BY p.created DESC' ;
        # Run the query
        $posts = DB::instance(DB_NAME)->select_rows($q);

        # Pass data to the View
        $output->contentRight->posts = $posts;

        $client_files_head = Array("/css/layout_tall.css","/css/form.css","/css/post.css");
        $output->client_files_head = Utils::load_client_files($client_files_head); 

        $client_files_body = Array("/js/delete.js");
        $output->client_files_body = Utils::load_client_files($client_files_body);

        # Render the View
        echo $output;

    }

    public function users() {
        $output = $this->template;
        $this->template->contentLeftBot = View::instance("v_posts_users");

        # Build and execute the query to get all the users
        $q = "SELECT *
            FROM users";
        $users = DB::instance(DB_NAME)->select_rows($q);

        # Build and execute the query to figure out who the current user follows
        $q = "SELECT * 
            FROM users_users
            WHERE user_id = ".$this->user->user_id;
        $connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');

        # Pass data (users and connections) to the view
        $output->contentLeftBot->users       = $users;
        $output->contentLeftBot->currUserID    = $this->user->user_id;
        $output->contentLeftBot->connections = $connections;

        # Render the view
        return $output->contentLeftBot;
    }

    public function follow($user_id_followed) {

        #Build and execute query to create connection
        $data = Array(
            "created" => Time::now(),
            "user_id" => $this->user->user_id,
            "user_id_followed" => $user_id_followed
            );
        DB::instance(DB_NAME)->insert('users_users', $data);

        Router::redirect("/posts/index");

    }

    public function unfollow($user_id_followed) {
        # Delete this connection
        $where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
        DB::instance(DB_NAME)->delete('users_users', $where_condition);

        Router::redirect("/posts/index");

    }

    public function follow_self() {
        $currUserID = $this->user->user_id;
        
        #build and execute the query to see if the user is already following self
        $q = "SELECT *
              FROM users_users 
              WHERE user_id = '$currUserID' 
              AND user_id = '$currUserID' ";
        $connection = DB::instance(DB_NAME)->select_rows($q);

        #create the connection if not already present
        if (empty($connection)) {
            $data = Array(
            "created" => Time::now(),
            "user_id" => $this->user->user_id,
            "user_id_followed" => $this->user->user_id   
            );

            DB::instance(DB_NAME)->insert('users_users', $data);
        }

    }

    public function delete($post_id) {
        $where_condition = "WHERE post_id = '$post_id' ";
        DB::instance(DB_NAME)->delete('posts', $where_condition);
        Router::redirect("/posts/index");

    }
}

