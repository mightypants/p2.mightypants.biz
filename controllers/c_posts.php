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

        $client_files_head = Array("/css/form.css","/css/styles_b.css");
        $output->client_files_head = Utils::load_client_files($client_files_head);  

        # Set client files that need to load before the closing </body> tag
        $client_files_body = Array("/js/form.js");
        $output->client_files_body = Utils::load_client_files($client_files_body);

        # Render template
        echo $output;

    }

    public function p_add() {

        # Associate this post with this user
        $_POST['user_id']  = $this->user->user_id;

        # Unix timestamp of when this post was created / modified
        $_POST['created']  = Time::now();
        $_POST['modified'] = Time::now();

        # Insert
        # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
        DB::instance(DB_NAME)->insert('posts', $_POST);

        # Quick and dirty feedback
        echo "Your post has been added. <a href='/posts/add'>Add another</a>";

    }

    public function index() {

        # Set up the View
        $output = $this->template;
        $output->content = View::instance('v_posts_index');
        $output->title   = "Posts";

        # Build the query
        $q = "SELECT * FROM posts p JOIN users u ON p.user_id=u.user_id";

        # Run the query
        $posts = DB::instance(DB_NAME)->select_rows($q);

        # Pass data to the View
        $output->content->posts = $posts;

        $client_files_head = Array("/css/post.css");
        $output->client_files_head = Utils::load_client_files($client_files_head); 

        # Render the View
        echo $output;

}
}