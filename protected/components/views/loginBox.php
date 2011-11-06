<div class="user_info">
        
  
        <img src="<?=e($user->avatar)?>" alt="תמונה" width="50" height="50" class="right"/>
        <p class="right">
         
            שלום
          
            <span dir="ltr" ><b id="user_name"><?=e($user->member_name)?></b></span> <br/>
            
            <? if($user->is_registered): ?>
            <a href="/forum/"><?=$user->getNewForumPostsCount()?> הודעות פורום חדשות</a><br/>
            מאז ביקורך האחרון

            <div class="logout-link" title="התנתק">
                <a href="<?=bu('Login/logout')?>" title="התנתק">x</a>
            </div>

            <? else: ?>
            ברוך הבא ללמוד PHP
            <br/>
            <a href="javascript:void(0)" onclick="show_reg_form()">
        בחר לעצמך שם משתמש
            </a>
            <br/>
            

            <? endif; ?>

            
        </p>
        <div class="clear"></div>
        
        
        
    </div>