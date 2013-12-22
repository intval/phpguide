<table class="qna_forum_list" width="100%" border="0" cellspacing="0" cellpadding="4">

    <? /*** @var $questionsWithCategories QnaQuestion[] */
    foreach($questionsWithCategories as $qWithCat):

        $direction = preg_match('#[א-ת]+#u', $qWithCat->category->cat_name) ? 'rtl' : 'ltr';

    ?>

    <tr >

        <td align="center">
            <div class="icon category_<?=$qWithCat->categoryid?>_colored"></div>
        </td>

        <td class='category_name'>

            <a
                title="פורום <?=e($qWithCat->category->cat_name)?>"
                href="<?=bu('forum/'.$qWithCat->categoryid)?>"
                dir="<?=$direction?>"
                ><?=e($qWithCat->category->cat_name)?>
            </a>

            <p><?=e($qWithCat->category->cat_description)?></p>
        </td>


        <td class="spacer"><span></span></td>


        <td class="last_post">
            <a
                title="השאלה האחרונה בפורום"
                href="<?=e($qWithCat->getUrl())?>"
                class='title'><?=e($qWithCat->subject)?></a>
            <p>
            על ידי:
                <a href="<?=e(bu('users/'.$qWithCat->author->login))?>" class="author"><?=e($qWithCat->author->login)?></a>,
                <time class='timeago' dir="rtl" datetime="<?=e($qWithCat->time->date2rfc())?>"><?=e($qWithCat->time->format('H:i'))?></time>
            </p>
        </td>
    </tr>

    <? endforeach; ?>

</table>