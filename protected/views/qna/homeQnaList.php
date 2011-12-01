<h3>
    שאלות אחרונות
</h3>


<section id="homepage_qna" class='clearfix'>
    <?
    foreach($qnas as $qna)
    {
	    $this->renderPartial('//qna/qnaHomeItem', array('qna' => &$qna));
    }
    ?>
    <div class='clear'></div>
</section>
