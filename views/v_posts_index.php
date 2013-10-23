<?php foreach($posts as $post): ?>


	<article>
	    <div class="postLeft">
	    	<h4><?=$post['user_name']?></h4>
	    	<img class="profilePic" src="" />
	    </div>

	    <div class="postRight">
		    <time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
		        <?=Time::display($post['created'])?>
		    </time>
		    <p><?=$post['content']?></p>
	    </div>
	    <br class="clearfloat">
    </article>
    

  

<?php endforeach; ?>