<?php
	class test_controller extends base_controller {
	
	public function test1() {
		
		$errors = array(
			1 => 'bad',
			2 => 'you messed up',
			3 => 'frown');

		$this->template->content = View::instance('v_test');
		$this->template->content->err = $errors;
	}
}


