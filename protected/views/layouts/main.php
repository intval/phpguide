
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

    <div class="about-contacts" >
        <div class="email" >Alex<!-- >@. -->@<!-- >@. -->phpguide<!-- >@. -->.<!-- >@. -->co.il</div>
        <a class="msn" href="msnim:chat?contact=c1424095@pjjkp.com">c1424095@pjjkp.com</a>
		<a class="skype" href="skype:raskin.alex?chat">raskin.alex</a>
        <a class="jabber" href="xmpp:phpg@jabber.ru">phpg@jabber.ru</a>
    </div>

</div>
</div>


    
<?php $this->renderPartial('//layouts/footer'); ?>