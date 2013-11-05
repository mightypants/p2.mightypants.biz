<img src="<?=$profile_pic?>" class="profilePic" />
<div id="profileInfo">
	<h2><?=$user_name?></h4>

	<?php 
   		if(isset($error)) {
    		echo "<p class=\"error\">There were errors with your entries.  Perhaps you misspelled your human name.</p>";
   		}
   		else {
        	echo "<p>Please fill out the fields below that you want to change.</p>";
    	}
    ?>   

	
	<form method="POST" action="/users/p_edit_profile">
		<div class="reqField">
	        <p class="fieldName">E-mail:</p>
		    <input class="reqTextField" name='email' id="email" type='text' value="<?=$email?>" />
		    <img class="tooltipIcon" src="/images/tooltip.png">
        	<p id="emailReqs" class="tooltip">Please use a valid e-mail address.</p>
	    </div>
		<div class="reqField">
			<p class="fieldName">First name:</p>
		    <input class="reqTextField" name='first_name' id="first_name" type='text' value="<?=$first_name?>" />
	    	<img class="tooltipIcon" src="/images/tooltip.png">
        	<p id="fNameReqs" class="tooltip">Field cannot be left blank.</p>
	    </div>
		<div class="reqField">
	        <p class="fieldName">Last name:</p>
	        <input class="reqTextField" name='last_name' id="last_name" type='text' value="<?=$last_name?>" />
	    	<img class="tooltipIcon" src="/images/tooltip.png">
        	<p id="lNameReqs" class="tooltip">Field cannot be left blank.</p>
	    </div>
	    <div class="reqField">
	        <p class="fieldName">Hometown:</p>
	        <input class="reqTextField" name='hometown' id="hometown" type='text' value="<?=$hometown?>" />
	    	<img class="tooltipIcon" src="/images/tooltip.png">
        	<p id="hometownReqs" class="tooltip">Field cannot be left blank.</p>
	    </div>
	    <div class="reqField">
	        <p class="fieldName">Age:</p>
	        <input class="reqTextField" name='age' id="age" type='text' value="<?=$age?>" />
	    	<img class="tooltipIcon" src="/images/tooltip.png">
        	<p id="ageReqs" class="tooltip">Field cannot be left blank.  Max digits is 3, unless you are a robot.  You aren't a robot, are you?</p>
	    </div>
		<div class="reqField">
			<p class="fieldName">About:</p>
		    <textarea name='about' id='about' class="reqTextField textBox"><?=$about?></textarea>
			<img class="tooltipIcon" src="/images/tooltip.png">
        	<p id="aboutReqs" class="tooltip">Field cannot be left blank.  Max characters is 900.</p>
		</div>
		<input type='submit' class="submitBtn" id="frmSubmit" value='Save Changes' />   
	</form>
</div>


