
<?php $this->renderPartial('//layouts/header'); ?>

<div id="main">

    
    
    <section id="sidebar" >
        <?php $this->renderPartial('//layouts/sidebar'); ?>
    </section>


    <section id="content">
        <?=$content; ?> 
    </section> <!-- /content -->

    
    
    
    <!-- clear sidebar and content -->
    <div class='clear'></div>

</div> <!-- /main -->
    
<?php $this->renderPartial('//layouts/footer'); ?>