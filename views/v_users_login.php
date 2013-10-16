<form id="contactFrm" method="POST" action="/users/p_login">
    <div class="reqField">
        <p class="fieldName">Username:</p>
        <input class="reqTextField" name='username' id="username" type='text' value="" size='25' />
        <p class="invalidWarning">*</p>
        <br class="clearfloat">
    </div>
    <div class="reqField">
        <p class="fieldName">Password:</p>
        <input class="reqTextField" name='password' id="password" type='text' value="" size='25' />
        <p class="invalidWarning">*</p>
        <br class="clearfloat">
    </div>
<input type='submit' class="submitBtn" id="frmSubmit" name="submit" value='Send' size='15' />   
</form>
