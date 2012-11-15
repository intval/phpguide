var qna = 
{
    answerSent : function(xhr)
    {
    	if(isguest)
    	{
    		xhr.abort();
    		unauth_message('qnaAnswer');
    		return false;
    	}
    	
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
    questionIdEdited : 0,
    
    startEditting: function(id)
    {
    	$.get('qna/getEditForm' , {id : id.replace('answer', '')} , function(result){
    		$('#' + id).hide().after(result);
    		qna.editedId = id;
    	});
    	
    },
    
    editSent: function(xhr)
    {
    	
    	if ('' === $.trim($('#editmessage'+qna.editedId.replace('answer', '')).val()) ) 
    	{
    		xhr.abort();
    		$('#' + qna.editedId).show();
        	$('.qnaCommentForm').remove();
    		return false;
		}
    	
    	$('.btnEditAnswer').attr('disabled', 'disabled');
    	return true;
    },
    
    editSuccess: function(data, status, xhr)
    {
    	$('.qnaCommentForm').remove();
    	$('#' + qna.editedId).show().replaceWith(data);
    	qna.editedId = false;
    	
    },
    
    
    startEdittingQuestion : function (textElem)
    {
    	
    	var id = textElem.attr('id').replace('questionText', '');
    	questionIdEdited = id;
    	
    	$.get('qna/getQuestionEditForm' , {'id' : id} , function(result){
    		textElem.hide().after(result);
    	});
    	
    	var h2TitleContainer = jQuery('.question-summary-wrapper h2');
    	h2TitleContainer.html('<input type="text" id="editQuestionTitle" ' +  
    						  ' style="width:400px" value="'+
    						  escapeHtml(h2TitleContainer.find('a').text())+
    						  '"/>');
    },
    
    editQuestionSent: function ()
    {
    	
    	$('#editQuestionSubjectHidden').val($('#editQuestionTitle').val());
    	
    	if ('' === $.trim($('#editedQuestion').val()) || '' === $.trim($('#editQuestionTitle').val()) ) 
    	{
    		xhr.abort();
    		$('#' + questionIdEdited).show().replaceWith(data);
        	$('.qnaCommentForm').remove();
    		return false;
		}
    	
    	
    	$('.btnEditAnswer').attr('disabled', 'disabled');
    	return true;
    },
    
    editQuestionSuccess : function(data, status, xhr)
    {
    	document.location  = data;
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
    			'success':qna.editSuccess,
    			'beforeSend':qna.editSent,
    			'type':'POST','url':'/Qna/answer','cache':false,
    			'data':jQuery(this).parents("form").serialize()});
    		
    		return false;
    	});
    	
    	
    	jQuery('#qnaQuestionHolder')
    	.on('click', 'a.qna-question-edit',  function(item){
    		qna.startEdittingQuestion($(this).nextAll('div.qnapost'));
    	})
    	.on('click', 'a.qna-question-delete',  function(item){
    		if(confirm('sure?'))
			{
    			var id = $(this).nextAll('div.qnapost').attr('id').replace('questionText', '');
	    		$.get('qna/deleteQuestion', {id: id});
	    		// if we relocate immidiately, the ajax request might not be sent
	    		window.setTimeout("document.location = '/qna'", 30);
			}
    	})
    	.on('click','.btnEditQuestion', function(){
    		if(qna.editQuestionSent())
    		{
	    		jQuery.ajax({
	    			'success':qna.editQuestionSuccess,
	    			'type':'POST','url':'/Qna/new',
	    			'cache':false,'data':jQuery(this).parents("form").serialize()});
    		}
    		return false;
    	});
    	
    },
    
    activateCorrectMarkingButton : function()
    {
    	jQuery(".correct_ans").click(function() {
  		  $.get("/qna/markascorrect/", { ans: parseInt($(this).attr('data-id')) } );
  		  $('.correct_ans').remove();
  		  return false;
  		});
    },

    activateSubscriptionHandler : function()
    {
        jQuery('#qnaSubscribe').on('click', function(checkbox){

            var isChecked = $('#qnaSubscribe').is(':checked');
            var qid = jQuery('#QnaComment_qid').val();

            jQuery.get('/qna/subscribe', {subscribe: isChecked, subscribeQid: qid});
            qna.changeSubscriptionButtonText(isChecked);

        });
    },

    changeSubscriptionButtonText : function(isChecked)
    {
        var statusBlock = jQuery('#qnaSubscriptionStatus');
        var textSubscribe = statusBlock.find('span.sub');
        var textUnsub = statusBlock.find('span.unsub');

        if(isChecked)
        {
            textSubscribe.hide();
            textUnsub.show();
            statusBlock.removeClass('alert-warning').addClass('alert-success');
        }
        else
        {
            textUnsub.hide();
            textSubscribe.show();
            statusBlock.removeClass('alert-success').addClass('alert-warning');
        }
    },
    
    handlePage : function()
    {
    	qna.activateEditingButton();
    	qna.activateCorrectMarkingButton();
        qna.activateSubscriptionHandler();
    }
    
};

$(document).ready(qna.handlePage);

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
