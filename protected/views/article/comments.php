   <section class="comments" id='post_comments'>
    <? if (isset($comments[0])): ?>
    
	<h2>תגובות לכתבה:</h2>
        <? foreach($comments as $comment) 
	    {
		$this->renderPartial('//article/singleComment', array('comment' => &$comment));
	    } 
	?>
        
        
        
    <?endif;?>
    </section>