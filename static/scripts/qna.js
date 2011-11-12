
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
	$('#answersCounter').text( parseInt($('#answersCounter').text(),10) +1 );
    },
    
    clearAnswerText: function()
    {
	$('#message').val('');
    },
    
    appendAnswer: function(text)
    {
	$('#qnaAnswers').append((text));
    }
}
