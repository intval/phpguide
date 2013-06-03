var qna =
{
    answerSent : function(xhr)
    {
    	if(window['isguest'])
    	{
    		xhr.abort();
    		unauth_message('qnaAnswer');
    		return false;
    	}

		if( $('#message').val() == '') xrh.abort();
		qna.disableSubmitButton();

        var isSubscribed = $('#qnasubscribe').is(':checked');
        qna.markMyselfSubscribed(isSubscribed);
        return true;
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
        var el = jQuery('div.answered div.item-count');
    	el.text( parseInt(el.text(),10) +1 );
    },
    decrementAnswersCounter: function()
    {
        var el = jQuery('div.answered div.item-count');
        el.text( parseInt(el.text(),10) -1 );
    },
    clearAnswerText: function()
    {
    	$('#message').val('');
        if($('form').sisyphus !== undefined) $('form').sisyphus().manuallyReleaseData();
    },

    appendAnswer: function(text)
    {
    	$('#qnaAnswers').append((text));
    },

    // currently editted id
    editedId : 0,
    questionIdEdited : 0,

    startEditing: function(id)
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

    editSuccess: function(data)
    {
    	$('.qnaCommentForm').remove();
    	$('#' + qna.editedId).show().replaceWith(data);
    	qna.editedId = false;
    },


    startEditingQuestion : function (textElem)
    {

    	var id = textElem.attr('id').replace('questionText', '');
    	qna.questionIdEdited = id;

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
        var subject = $('#editQuestionTitle').val();
    	$('#editQuestionSubjectHidden').val(subject);

    	if ('' === $.trim($('#editedQuestion').val()) || '' === $.trim(subject) )
    	{
    		xhr.abort();
    		$('#' + qna.questionIdEdited).show().replaceWith(data);
        	$('.qnaCommentForm').remove();
    		return false;
		}


    	$('.btnEditAnswer').attr('disabled', 'disabled');
    	return true;
    },

    editQuestionSuccess : function(data)
    {
        if($('form').sisyphus !== undefined) $('form').sisyphus().manuallyReleaseData();
    	document.location  = data;
    },

    activateEditingButton: function()
    {
    	$('#qnaAnswers')
    	.on('click', 'a.qna-answer-edit',  function(){
    		qna.startEditing($(this).parents('div.answer').attr('id'));
    	})
    	.on('click', 'a.qna-answer-delete',  function(){
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
    	.on('click', 'a.qna-question-edit',  function(){
    		qna.startEditingQuestion($(this).nextAll('div.qnapost'));
    	})
    	.on('click', 'a.qna-question-delete',  function(){
    		if(confirm('sure?'))
			{
    			var id = $(this).nextAll('div.qnapost').attr('id').replace('questionText', '');
	    		$.get('qna/deleteQuestion', {id: id});
	    		// if we relocate immediately, the ajax request might not be sent
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
        jQuery('#qnaSubscribe').on('click', function(){

            var isChecked = $('#qnaSubscribe').is(':checked');
            var qid = jQuery('#QnaComment_qid').val();

            jQuery.get('/qna/subscribe', {subscribe: isChecked, subscribeQid: qid});
            qna.markMyselfSubscribed(isChecked);

        });
    },

    markMyselfSubscribed: function(isSubscribed)
    {
        if(isSubscribed)
        {
            $('#qnaSubscribe').attr('checked', 'checked');
            $('#qnasubscribe').attr('checked', 'checked');
        }
        else
        {
            $('#qnaSubscribe').removeAttr('checked');
            $('#qnasubscribe').removeAttr('checked');
        }

        qna.changeSubscriptionButtonText(isSubscribed);
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
