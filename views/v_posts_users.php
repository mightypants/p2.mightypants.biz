<div id="userList"><h2>Users</h2>
<? foreach($users as $user): ?>
    <? if($user['user_id'] != $currUserID): ?>
        <!-- Print this user's name -->
        <p class="userLink"><?=$user['user_name']?><br />

        <!-- If there exists a connection with this user, show a unfollow link -->
        <? if(isset($connections[$user['user_id']])): ?>
            <a class="follow" href='/posts/unfollow/<?=$user['user_id']?>'>Unfollow</a>

        <!-- Otherwise, show the follow link -->
        <? else: ?>
            <a class="follow" href='/posts/follow/<?=$user['user_id']?>'>Follow</a>
        <? endif; ?>
        </p>
    <? endif; ?>
<? endforeach; ?>
</div>
