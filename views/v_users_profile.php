<img src="<?=$profile_pic?>" class="profilePic" />
<div id="profileInfo">
	<h2><?=$user_name?></h4>
	
	<div class="profileLeft">
		<p><strong>E-mail:</strong> <?=$email?><br />
		<strong>Name:</strong> <?=htmlspecialchars($first_name) . " " . htmlspecialchars($last_name)?></p>
	</div>

	<div class="profileRight">
		<p><strong>Hometown:</strong> <?=htmlspecialchars($hometown)?><br />
		<strong>Age:</strong> <?=htmlspecialchars($age)?></p>
	</div>

	<p><strong>About <?=htmlspecialchars($first_name)?>:</strong><br />
	<?=htmlspecialchars($about)?>
	</p>

	<?php if(isset($loggedInUser)): ?> 
	<a href="/users/edit_profile" class="submitBtn">Edit Profile</a>
	<?php endif; ?> 
	<br class="clearfloat">	
</div>


