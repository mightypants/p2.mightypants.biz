<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="/css/styles.css" />	
					
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<body>	

	<div id="nav">
        <a href='/'>Home</a>

        <!-- Menu for users who are logged in -->
        <?php if($user): ?>

            <a href='/users/logout'>Logout</a>
            <a href='/users/profile'>Profile</a>

        <!-- Menu options for users who are not logged in -->
        <?php else: ?>

            <a href='/users/signup'>Sign up</a>
            <a href='/users/login'>Log in</a>

        <?php endif; ?>

	</div>
	<div id="wrapper">

	
	<?php if(isset($content)) echo $content; ?>
	<?php if(isset($contentLeft)) echo 
		"<div id=\"contentLeft\"> 
			$contentLeft 
		</div>"; 
	?>
	<?php if(isset($contentRight)) echo 
		"<div id=\"contentRight\"> 
			$contentRight 
		</div>
		" ; 
	?>
	<?php if(isset($contentLeftBot)) echo 
		"<div id=\"contentLeftBot\"> 
			$contentLeftBot 
		</div>
		<br class=\"clearfloat\" />" ; 
	?>
	<br class="clearfloat" />
	<?php if(isset($client_files_body)) echo $client_files_body; ?>

	</div>
	<div id="foot">+1 Features: View/Edit profiles | Delete posts</div>
</body>
</html>