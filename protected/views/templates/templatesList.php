<?php $this->renderPartial('//layouts/header'); ?>

    <div id="main">
    
    
    <section id="templates" class='templates-section'>

        <h1 class="content-title"> <span></span>עיצובים להורדה</h1>
            <br/>
            <ul style="margin-right:40px; color:#5782b8; line-height: 20px;">
                <li><b> חינם </b>— <span style="color:gray">כל העיצובים ניתנים להורדה בחינם . אין phpguide אחראית לדבר, נזק, תקינות וכל דבר אחר בעט השימוש בהם</span></li>
                <li><b>מותר לשינוי כפי רצונכם </b>— <span style="color:gray">אין צורך בקישור אל היוצרים בתחתית העמוד. למרות שמאוד נשמח אם תעזרו לאנשים אחרים למצוא עיצוב גם כן</span></li>
                <li><b>מותאם לכתיבה מימין לשמאל </b>— <span style="color:gray">כל העיצובים שוקפו כדי להתאים לכתיבה בעברית. כחלק מזה תמונות מסוימות שלא אמורות, שוקפו גם</span></li>
            </ul>
            <br/>
            <? foreach($templates as $template ): ?>

                    <div class='template'>
                            <a href="עיצובים_להורדה/<?=$template->id?>"><img src="/static/images/pixel.gif" alt="<?=e($template->name)?>"
                            title="http://ncdn.phpguide.co.il/templates/<?=urlencode($template->filename)?>/<?=urlencode($template->filename)?>.jpg"  /></a> <br/>
                            <?=e($template->name)?> <br/>
                            הורידו
                            <?=e($template->downloads)?>
                            פעמים
                    </div>

            <? endforeach; ?>

            <div class='clear:both'></div>

    </section> <!-- /content -->



    <!-- clear sidebar and content -->
    <div class='clear'></div>

</div> <!-- /main -->
    
<?php $this->renderPartial('//layouts/footer'); ?>