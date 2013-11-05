<?php 
    if(isset($error)) {
        echo "<p class=\"error\">There were errors with your entries.  Perhaps you misspelled your human name.</p>";
    }
    else {
        echo "<p>Please fill out all fields below to create your account.</p>";
    }
?> 

<form id="contactFrm" method="POST" action="/users/p_signup">
    <div class="reqField">
        <p class="fieldName">Username:</p>
        <input class="reqTextField" name='user_name' id="user_name" type='text' value="" />
        <img class="tooltipIcon" src="/images/tooltip.png">
        <p id="usrReqs" class="tooltip">Usernames must be 6 to 15 characters long, and may contain only letters and numbers.</p>
        <br class="clearfloat">
    </div>
    <div class="reqField">
        <p class="fieldName">First Name:</p>
        <input class="reqTextField" name='first_name' id="first_name" type='text' value="" />
        <img class="tooltipIcon" src="/images/tooltip.png">
        <p id="fNameReqs" class="tooltip">Field cannot be left blank.</p>
        <br class="clearfloat">
    </div>
    <div class="reqField">
        <p class="fieldName">Last Name:</p>
        <input class="reqTextField" name='last_name' id="last_name" type='text' value="" />
        <img class="tooltipIcon" src="/images/tooltip.png">
        <p id="lNameReqs" class="tooltip">Field cannot be left blank.</p>
        <br class="clearfloat">
    </div>
    <div class="reqField">
        <p class="fieldName">Email:</p>
        <input class="reqTextField" name='email' id="email" type='text' value="" />
        <img class="tooltipIcon" src="/images/tooltip.png">
        <p id="emailReqs" class="tooltip">Please use a valid e-mail address.</p>
        <br class="clearfloat">
    </div>
    <div class="reqField">
        <p class="fieldName">Password:</p>
        <input class="reqTextField" name='password' id="password" type='password' value="" />
        <img class="tooltipIcon" src="/images/tooltip.png">
        <p id="pwReqs" class="tooltip">6 to 15 characters long; least one number and one letter</p>
        <br class="clearfloat">
    </div>
    <input type='submit' class="submitBtn" id="frmSubmit" value='Sign Up' />   
</form>
