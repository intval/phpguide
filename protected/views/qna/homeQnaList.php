<h3>
    שאלות אחרונות
</h3>


<section id="homepage_qna" >
    <?
    foreach($qnas as $qna)
    {
	$this->renderPartial('//qna/qnaHomeItem', array('qna' => &$qna));
    }
    ?>
</section>
