   <section class="comments" id='post_comments'>
    <?php if (isset($comments[0])): ?>
    
	<h2>תגובות לכתבה:</h2>
        <?php foreach($comments as $comment) 
	    {
			$this->renderPartial('//article/singleComment', array('comment' => &$comment));
	    } 
	?>
        
        
        
    <?php endif;?>
    </section>