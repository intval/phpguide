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
            window.analytics.track('registration', 'failed', 'Empty Input');
			
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
            window.analytics.track('registration', 'failed', data);
		    $('#regResult').html(data).show();
		}
		else
		{
            window.analytics.track('registration', 'success');
		    window.location = redirect_after_login_to ;
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
    	$('#result').html(data).show().addClass('alert alert-success');
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
    },


    regManualSubmit: function()
    {
        var data = $('#regManualForm :input');
        var resultDiv = $('#regManualResult');
        var valid = true;

        for(var i = 0; i < data.length; i++)
            if($(data[i]).val() === '')
                valid = false;

        if(!valid)
        {
            resultDiv.html('יש להזין את כל השדות').show();
            return;
        }

        resultDiv.hide();
        $.post('login/register', data.serialize(), function(ret){

            if(ret === 'ok')
            {
                window.analytics.track('registration', 'success');
                window.location = redirect_after_login_to;
            }
            else
            {
                window.analytics.track('registration', 'failed', ret);
                resultDiv.html(ret).show();
            }

        });

    }
    
}