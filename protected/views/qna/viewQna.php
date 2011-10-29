<link rel="stylesheet" type="text/css" href="<?=bu('/static/styles/jush.css')?>" media="screen, projection" />
<div style="border-right:3px solid #13768C; margin-right:-25px; padding-right:25px; margin-bottom:20px;">


<? $this->renderPartial('//qna/qnaHomeItem', array('qna' => &$qna)) ?>

<div class="clear"></div>
<div style="border-top:1px dashed gray; margin-top:10px; padding-top:10px; " class="qnapost">
<?=  $qna->html_text ?>
</div>

<img src="/static/images/q.jpg" />
</div>

<h3><?=$qna->answers?> 
תשובות
</h3>
<br/><br/>

