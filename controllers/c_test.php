<?php
	class test_controller extends base_controller {
	
	public function test1() {
		
		# Our SQL command
		$q = "INSERT INTO users SET 
	    first_name = 'Jonnie', 
	    last_name = 'Dredge',
	    email = 'mrmightypants@gmail.com'";

		# Run the command
		echo DB::instance(DB_NAME)->query($q);
	}
}


