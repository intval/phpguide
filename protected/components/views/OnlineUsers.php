<?
/*** @var $users User[] */
?>

<div>
    עכשיו און ליין:

    <? foreach($users as $user): ?>

        <span>
            <a
                title="<?= $user->last_visit->format("H:i:s") ?>"
                href="<?=bu('users/'.urlencode($user->login));?>"
            >
                <?= e($user->login) ?>
            </a>,
        </span>

    <? endforeach; ?>

</div>