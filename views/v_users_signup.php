<div id="contentRight">
    <p>Please fill out all fields below to create your account.</p>
    <form id="contactFrm" method="POST" action="/users/p_signup">
        <div class="reqField">
            <p class="fieldName">Username:</p>
            <input class="reqTextField" name='user_name' id="user_name" type='text' value="" />
            <img class="tooltipIcon" src="/images/tooltip.png">
            <br class="clearfloat">
        </div>
        <div class="reqField">
            <p class="fieldName">First Name:</p>
            <input class="reqTextField" name='first_name' id="first_name" type='text' value="" />
            <img class="tooltipIcon" src="/images/tooltip.png">
            <br class="clearfloat">
        </div>
        <div class="reqField">
            <p class="fieldName">Last Name:</p>
            <input class="reqTextField" name='last_name' id="last_name" type='text' value="" />
            <img class="tooltipIcon" src="/images/tooltip.png">
            <br class="clearfloat">
        </div>
        <div class="reqField">
            <p class="fieldName">Email:</p>
            <input class="reqTextField" name='email' id="email" type='text' value="" />
            <img class="tooltipIcon" src="/images/tooltip.png">
            <br class="clearfloat">
        </div>
        <div class="reqField">
            <p class="fieldName">Password:</p>
            <input class="reqTextField" name='password' id="password" type='password' value="" />
            <img class="tooltipIcon" src="/images/tooltip.png">
            <br class="clearfloat">
        </div>
        <input type='submit' class="submitBtn" id="frmSubmit" value='Sign Up' size='15' />   
    </form>
    <p class='error'>
        <?php if(isset($error)): ?> 
            Login failed. Please double check your email and password.
        <?php endif; ?>  
    </p> 
</div>
<br class="clearfloat" />

<p id="usrReqs" class="tooltip">Usernames must be 6 to 15 characters long and contain only letters and numbers--no spaces.</p>
<p id="emailReqs" class="tooltip">Please use a valid e-mail address.</p>
<p id="pwReqs" class="tooltip">Passwords must be 6 to 15 characters long and contain at least one number and one letter.  Only letters and numbers can be used.</p>