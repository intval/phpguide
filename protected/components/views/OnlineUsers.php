<?
/*** @var $users User[] */
?>

<div class="onlineUsers">
    עכשיו און ליין:

    <?
    for($i = 0, $count = count($users); $i < $count; $i++):
        $user = & $users[$i];
    ?>

        <span class="onlineUserRecord">
            <a
                title="<?= $user->last_visit->format("H:i:s") ?>"
                href="<?=bu('users/'.urlencode($user->login));?>"
            ><?=
                e($user->login)
            ?></a>
            <?= ($i+1 < $count) ? ', ' : '' ?>
        </span>

    <? endfor; ?>

</div>