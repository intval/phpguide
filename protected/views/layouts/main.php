
<?php $this->renderPartial('//layouts/header'); ?>


<div class="container">
<div class="row">
    
    <section id="sidebar" class="span4_5" >
        <?php $this->renderPartial('//layouts/sidebar'); ?>
    </section>


    <section id="content" class="span11 offset0_5">
        <?=$content; ?> 
    </section> <!-- /content -->



</div>
<div class="row footer">

    <div class="span4">
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="3B73HULF5CZAG">
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="Donate" style="height: 26px;width:92px;border:none;">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>

    </div>
    
    <div class="about-contacts span3 offset8" >
        <div class="email" >Alex<!-- >@. -->@<!-- >@. -->phpguide<!-- >@. -->.<!-- >@. -->co.il</div>
        <a class="msn" href="msnim:chat?contact=c1424095@pjjkp.com">c1424095@pjjkp.com</a>
		<a class="skype" href="skype:raskin.alex?chat">raskin.alex</a>
        <a class="jabber" href="xmpp:phpg@jabber.ru">phpg@jabber.ru</a>
    </div>

</div>
</div>


    
<?php $this->renderPartial('//layouts/footer'); ?>