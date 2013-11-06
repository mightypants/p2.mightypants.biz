<?php

class index_controller extends base_controller {
	
	/*-------------------------------------------------------------------------------------------------

	-------------------------------------------------------------------------------------------------*/
	public function __construct() {
		parent::__construct();
	} 
		
	/*-------------------------------------------------------------------------------------------------
	Accessed via http://localhost/index/index/
	-------------------------------------------------------------------------------------------------*/
	public function index() {
		$output = $this->template;
		
		// setup if statement, check cookie for login and go to user home
		if($this->userObj->authenticate()) {

	        Router::redirect("/posts/index");

	    # But if we did, login succeeded! 
	    } else {
	        $output->contentLeft = View::instance('v_index_index');
			$output->contentRight = View::instance('v_users_login');	

        	$client_files_head = Array("/css/form.css","/css/layout_short.css");
	        $output->client_files_head = Utils::load_client_files($client_files_head);  
    	}
		
		$output->title = "Very Enjoyable Social Media Website";


	      					     		
		# Render the view
		echo $output;



	} # End of method

	
	
} # End of class
