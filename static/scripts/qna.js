
var qna = 
{
    answerSent : function(xhr)
    {
		if( $('#message').val() == '') xrh.abort();
		qna.disableSubmitButton();
    },
    
    displayAnswer : function(data)
    {
		qna.appendAnswer(data);
		qna.clearAnswerText();
		qna.incrementAnswersCounter();
		qna.enableSubmitButton();
    },
    
    enableSubmitButton : function()
    {
    	$('#btnNewAnswer').removeAttr('disabled');
    },
    
    disableSubmitButton : function()
    {
    	$('#btnNewAnswer').attr('disabled', 'disabled');
    },
    
    incrementAnswersCounter: function()
    {
    	$('div.answered div.item-count').text( parseInt($('div.answered div.item-count').text(),10) +1 );
    },
    decrementAnswersCounter: function()
    {
    	$('div.answered div.item-count').text( parseInt($('div.answered div.item-count').text(),10) -1 );
    },
    clearAnswerText: function()
    {
    	$('#message').val('');
    },
    
    appendAnswer: function(text)
    {
    	$('#qnaAnswers').append((text));
    },
    
    // currently editted id
    editedId : 0,
    
    startEditting: function(id)
    {
    	$.get('qna/getEditForm' , {id : id.replace('answer', '')} , function(result){
    		$('#' + id).hide().after(result);
    		qna.editedId = id;
    	});
    	
    },
    
    editSent: function(xhr)
    {
    	if ('' === $.trim('#editmessage') ) 
    	{
    		xhr.abort();
    		$('#' + qna.editedId).show().replace(data);
        	$('#qnaCommentForm').remove();
    		return;
		}
    	
    	$('.btnEditAnswer').attr('disabled', 'disabled');
    	
    },
    
    editSuccess: function(data, status, xhr)
    {
    	$('#qnaCommentForm').remove();
    	$('#' + qna.editedId).show().replaceWith(data);
    	qna.editedId = false;
    	
    },
    
    
    
    activateEditingButton: function()
    {
    	$('#qnaAnswers')
    	.on('click', 'a.qna-answer-edit',  function(item){
    		qna.startEditting($(this).parents('div.answer').attr('id'));
    	})
    	.on('click', 'a.qna-answer-delete',  function(item){
    		if(confirm('sure?'))
			{
    			var div = $($(this).parents('div.answer')[0]);
        		var id = parseInt(div.attr('id').replace('answer', ''), 10);
	    		div.remove();
	    		qna.decrementAnswersCounter();
	    		$.get('qna/delete', {id: id});
			}
    	})
    	.on('click','.btnEditAnswer', function(){
    		jQuery.ajax({
    			'success':qna.editSuccess,'beforeSend':qna.editSent,'type':'POST','url':'/Qna/answer','cache':false,'data':jQuery(this).parents("form").serialize()});return false;
    	});
    }
    
}

$(document).ready(qna.activateEditingButton);
