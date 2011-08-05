<div class="user_info">
        
  
        <img src="<?=e($user->avatar)?>" alt="<?=e($user->member_name)?>" width="45" height="45" class="right"/>
        <p class="right">
         
            שלום
          
            <span dir="ltr" ><b id="user_name"><?=e($user->member_name)?></b></span> <br/>
            
            <? if($user->is_registered): ?>
            <a href="/forum/"><?=$user->getNewForumPostsCount()?> הודעות פורום חדשות</a><br/>
            מאז ביקורך האחרון
            
            <? else: ?>
            ברוך הבא לאתר לימוד PHP
            <br/>
            <a href="#" onclick="show_reg_form()">
        בחר לעצמך שם משתמש אחר
            </a>
            <br/>
            

            <? endif; ?>

            
        </p>
        <div class="clear"></div>
        
        <? if(!$user->is_registered): ?>

        <div id="reg_form" >
 
            <table border="0">
                
                <tr>
                    <td>שם חדש:</td>
                    <td><input type="text" id="new_user_name"/></td>
                </tr>    
                <tr>
                    <td>סיסמה:</td>
                    <td><input type="text" id="new_user_pass"/></td>
                </tr>              
                <tr>
                    <td></td>
                    <td><input type="button" value="שמור משתמש" onclick="register_new_member()"/></td>
                </tr>    
                
            </table>
            <br/>
            <a href="/VIPlogin.php"  style="font-size: 75%; text-decoration: none"> &mdash;
                לחץ כאן אם אתה כבר רשום בשם אחר
            </a>
            
        </div>
        
        <? endif; ?>
        
    </div>