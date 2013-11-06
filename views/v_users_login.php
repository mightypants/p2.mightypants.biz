<?php 
    if(isset($message)) {
        if($message == 'success') {
            echo "<p class=\"success\">Your account has been created successfully, please log in below.</p>";
        }
        elseif($message == 'error') {
            echo "<p class=\"error\">Login failed. Please double check your username and password and try again.</p>";
        }
        elseif($message == 'access_denied') {
            echo "<p class=\"error\">The area you have tried to access is for members only.  Please login and try again.</p>";
        }   
        else {
            echo "<p>Please login with your username and password below.  If you don't have an account, <a href=\"/users/signup\">sign up here</a>.</p>";
        }      
    }
    else {
        echo "<p>Please login with your username and password below.  If you don't have an account, <a href=\"/users/signup\">sign up here</a>.</p>";
    }
?> 

<form id="contactFrm" method="POST" action="/users/p_login">
    <div class="reqField">
        <p class="fieldName">Username:</p>
        <input class="reqTextField" name='user_name' id="user_name" type='text' value="" size='25' />
        <br class="clearfloat">
    </div>
    <div class="reqField">
        <p class="fieldName">Password:</p>
        <input class="reqTextField" name='password' id="password" type='password' value="" size='25' />
        <br class="clearfloat">
    </div>
    <input type='submit' class="submitBtn" id="frmSubmit" value='Login' />   
</form>

