<? foreach($users as $user): ?>

    <!--if($user == $this->user)-->

    <!-- Print this user's name -->
    <?=$user['user_name']?>

    <!-- If there exists a connection with this user, show a unfollow link -->
    <? if(isset($connections[$user['user_id']])): ?>
        <a href='/posts/unfollow/<?=$user['user_id']?>'>Unfollow</a>

    <!-- Otherwise, show the follow link -->
    <? else: ?>
        <a href='/posts/follow/<?=$user['user_id']?>'>Follow</a>
    <? endif; ?>

    <br><br>

<? endforeach; ?>