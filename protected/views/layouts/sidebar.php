<?php
/*** @var $this RecentEvents */

$recentEventsCacheParams = [
    'duration'=>3600,
    'dependency' =>
    [
        'class'=>'system.caching.dependencies.CDbCacheDependency',
        'sql'=>RecentEvents::getCacheDependencySql()
    ]
];

?>

<section id="search_box">
    <form method="get" action="http://www.google.co.il/search" id="search_form">
    
        <input type="hidden" name="hl" value="iw" />
        <input type="checkbox"  name="sitesearch" style="display:none" value="phpguide.co.il" checked />
        
        <input type="text" class="search_form" placeholder="חיפוש" name="q" id="search_field"/>
        <input type="submit" value="" title="לחפש"> 
        
    </form>
</section>
    
    
<?php $this->widget('application.components.LoginBox') ?>

<section class="rblock">
	<h3>
        <a href="/oopbook/" >
		הספר הכי פשוט על OOP
            </a>
	</h3>
    <p>
        סוף סוף הספר הראשון שמסביר oop בעברית פשוטה, בצורה מלאה עם הסברים ברורים ודוגמאות קוד קצרות מאפס
    </p>
	<br/>
</section>

<div class='rblock' style="padding:0 -50px; width:100%; background: white;">
    <a href='http://phpguide.co.il/oopbook/'>
        <img src="http://i.picresize.com/images/2013/12/09/LzjqY.png" alt="" />
    </a>
</div>

<?php $this->widget('application.components.RatingWidget'); ?>

<?php if($this->beginCache('RecentEventsFragmentCache', $recentEventsCacheParams)) { ?>

    <?php $this->widget('application.components.RecentEvents'); ?>

<?php $this->endCache(); } ?>

<section class="logos">
	<a href="https://github.com/intval/phpguide" title='phpguide is open source. Help us!' class='github'></a>
	<a href="http://feeds.feedburner.com/phpguideblog" title='All new blog posts via RSS' class='rss'></a>
</section>