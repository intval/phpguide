<? /** @var $problems ContestProblem[] */ ?>

<h1 style="margin-top:20px; color:slategray;">
    PHPG Code Cup #1
</h1>
<br/><br/>
<? foreach($problems as $problem): ?>


    <div class="well well-small" style='background: #FAFAFA; cursor: pointer;' data-type='contestProblem'>
        <h5>
            <a href='/contest/problem/<?=$problem->problemid?>' rel="problemPage"><?=e($problem->title)?></a>
        </h5>

            <?=e($problem->shortDesc)?>
        <br/><br/>

        נסיונות:
        <?= $problem->userSubmitsCount ?>
        &nbsp; &nbsp;
        ניקוד: 86/96
    </div>


<? endforeach; ?>
