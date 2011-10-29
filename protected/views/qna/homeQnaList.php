<h3>
    שאלות אחרונות
</h3>
<br/><br/>
<?
foreach($qnas as $qna)
{
    $this->renderPartial('//qna/qnaHomeItem', array('qna' => &$qna));
    
}
