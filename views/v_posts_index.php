<form method='POST' action='/posts/p_add'>
    <textarea name='content' id='content' class="reqTextField"></textarea>
    <input type='submit' class="submitBtn" value='New post'>

    <?php 
    	if(isset($message)) {
    		if($message == 'error') {
    			echo "<p class=\"error\">Your post has no content.  This confuses us.</p>";
    		}
    		else {
    			echo "<p class=\"success\">Your post has been added.  Congratulations.</p>";
    		}
   		}
    ?>   
    </p>
    <br class="clearfloat">
</form> 

<div id="postWrapper">
<?php if(!empty($posts)): ?> 
	<?php foreach($posts as $post): ?>	
		<article>
		    <img class="profilePicSmall" src="<?=$post['profile_pic_sm']?>" />

		    <div class="postRight">
			    <time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
			        <?=Time::display($post['created'])?>
			    </time>
			    <a class="userLink" href='/users/profile/<?=$post['user_name']?>'><?=$post['user_name']?></a>
			    <p><?=htmlspecialchars($post['content'])?></p>
			    <? if ($post['user_id'] == $currUserID): ?>
			    	<a href="/posts/delete/<?=$post['post_id']?>" class="delPost">Delete post</a></p>
				<? endif ; ?>
		    </div>
		    <br class="clearfloat">
	    </article>
	<?php endforeach; ?>

<?php else: ?>
	<p>There is no content to view at this time.  Try following some other users or adding your own posts.</p>         
<?php endif; ?>  
</div>
