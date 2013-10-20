<div id="contentRight">
    <p>Please login with your username and password below.  If you don't have an account, <a href="/users/signup">sign up here</a>.</p>

    
    <form id="contactFrm" method="POST" action="/users/p_login">
        <div class="reqField">
            <p class="fieldName">Username:</p>
            <input class="reqTextField" name='user_name' id="user_name" type='text' value="" size='25' />
            <p class="invalidWarning">*</p>
            <br class="clearfloat">
        </div>
        <div class="reqField">
            <p class="fieldName">Password:</p>
            <input class="reqTextField" name='password' id="password" type='password' value="" size='25' />
            <p class="invalidWarning">*</p>
            <br class="clearfloat">
        </div>
        <input type='submit' class="submitBtn" id="frmSubmit" value='Login' size='15' />   
    </form>
    <p class='error'>
        <?php if(isset($error)): ?> 
            Login failed. Please double check your email and password.
        <?php endif; ?>  
    </p>    
</div>
<br class="clearfloat" />