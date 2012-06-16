var login = 
{
    submitted : function(xhr)
    {
		if( $.trim($('#loginname').val()) == '' || $.trim($('#loginpass').val()) == '')
		{
		    xhr.abort(); 
		    return;
		}
		
		login.disableBtn();
    },
    
    disableBtn : function()
    {
		$('loginSubmitBtn').attr('disabled','disabled');
		$('regSubmitBtn').attr('disabled','disabled');
		$('#loginResult').hide();
		$('#regResult').hide();
    },
    
    enableBtn: function()
    {
		$('loginSubmitBtn').removeAttr('disabled');
		$('regSubmitBtn').removeAttr('disabled');
    },
    
    xhrSuccess : function(data)
    {
		login.enableBtn();
		if(data != 'ok')
		{
		    $('#loginResult').html(data).show();
		}
		else
		{
		    window.location = redirect_after_login_to;
		}
    },
    
    
    regSubmitted : function(xhr)
    {
		if( 
		    $.trim($('#regname').val()) == '' || 
		    $.trim($('#regmail').val()) == '' 
		)
		{
		    xhr.abort(); 
			
		    $('#regResult').html(
		    'יש למלא את כל השדות'
		    ).show();
		    return;
		    
		}
		
		login.disableBtn();
    },
    
    regSuccess: function(data)
    {
		if(data != 'ok')
		{
		    $('#regResult').html(data).show();
		}
		else
		{
		    window.location = redirect_to;
		}
    },
    
    
    
    recoverySubmited: function(xhr)
    {
    	
    	if( $.trim($('#login').val()) == '' || $.trim($('#email').val()) == '')
		{
		    xhr.abort(); 
		    return;
		}
		
    	$('#result').hide();
		$('#recoverBtn').attr('disabled', 'disabled');
    },
    
    recoverySuccess: function(data)
    {
    	$('#recoverBtn').removeAttr('disabled');
    	$('#result').html(data).show();
    },
    
    passwordChangeSubmitted: function(xhr)
    {
    	if('' === $.trim($('#newpass').val()))
		{
    		xhr.abort();
    		return;
		}
    	
    	$('#changepwBtn').attr('disabled', 'disabled');
    	
    },
    
    passwordChangeSuccess: function(data)
    {
    	window.location = homepage_url;
    }
    
}