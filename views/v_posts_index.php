<form method='POST' action='/posts/p_add'>
    <textarea name='content' id='content' class="reqTextField">Add something...</textarea>
    <input type='submit' class="submitBtn" value='New post'>
    
    <?php 
    	if(isset($message)) {
    		if($message == 'error') {
    			echo "<p class=\"error\">Your post contains no content.  This confuses us.</p>";
    		}
    		else {
    			echo "<p class=\"success\">Your post has been added.  Congratulations.</p>";
    		}
   		}
    ?>   
    </p>
    <br class="clearfloat">
</form> 


<?php if(isset($posts)): ?> 
	<?php foreach($posts as $post): ?>

		<article>
		    <img class="profilePicSmall" src="<?=$post['profile_pic_sm']?>" />

		    <div class="postRight">
			    <time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
			        <?=Time::display($post['created'])?>
			    </time>
			    <h4><?=$post['user_name']?></h4>
			    <p><?=$post['content']?></p>
		    </div>
		    <br class="clearfloat">
	    </article>
	<?php endforeach; ?>

<?php else: ?>
	<p>There is no content to view at this time.</p>         
<?php endif; ?>  
