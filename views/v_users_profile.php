<img src="<?=$profile_pic?>" class="profilePic" />
<div id="profileInfo">
	<h2><?=$user_name?></h4>
	
	<div class="profileLeft">
		<p><strong>E-mail:</strong> <?=$email?><br />
		<strong>Name:</strong> <?=$first_name . " " . $last_name?></p>
	</div>

	<div class="profileRight">
		<p><strong>Hometown:</strong> <?=$hometown?><br />
		<strong>Age:</strong> <?=$age?></p>
	</div>

	<p><strong>About <?=$first_name?>:</strong><br />
	<?=$about?>
	</p>

	<a href="/users/edit_profile" class="submitBtn">Edit Profile</a>
	<br class="clearfloat">	
</div>


