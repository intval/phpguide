


<form method="post"  dir="rtl" style="font-size: 17px; margin: 20px 0 0 50px;" >
    <div id="wrong"  style="display:none; font-size:13px; text-align:right; background-color: #ff9999; padding:5px; width:250px;">שם משתמש או סיסמה לא נכונים</div>
    <table>
        <tr>
            <td style="width:100px">שם משתמש:</td>
            <td><input type="text" style="padding:5px 10px; " name="login" tabindex="2" id="focus"/></td>
        </tr>
        <tr>
            <td>סיסמה:</td>
            <td><input type="password" style=" padding:5px 10px; " name="pass" tabindex="3" /></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="התחבר"/></td>
        </tr>
    
    </table>
</form>

<script type='text/javascript'>
    jQuery('#focus').focus();
    jQuery('form').submit(function() {
      jQuery('#wrong').hide();
      jQuery.post('/Login/login', $(this).serialize(), login);
      return false;
    });
   
    function login(result)
    {
        if( result == 'ok')
        {
            window.location = '<?=e($return_location)?>';
        }
        else
        {
            jQuery('#wrong').html(result).show();
        }
    }
   
</script>

