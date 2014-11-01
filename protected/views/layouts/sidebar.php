<?php
/*** @var $this RecentEvents */

$recentEventsCacheParams = [
    'duration'=>3600,
    'dependency' =>
    [
        'class'=>'system.caching.dependencies.CDbCacheDependency',
        'sql'=>RecentEvents::getCacheDependencySql()
    ],
    'varyByExpression' => function(){
        return Yii::app()->user->isGuest;
    }
];

?>

<section id="search_box">
    <form method="get" action="http://www.google.co.il/search" id="search_form">
    
        <input type="hidden" name="hl" value="iw" />
        <input type="checkbox"  name="sitesearch" style="display:none" value="<?=bu(null, true)?>" checked />
        
        <input type="text" class="search_form" placeholder="חיפוש" name="q" id="search_field"/>
        <input type="submit" value="" title="לחפש"> 
        
    </form>
</section>
    
    
<?php $this->widget('application.components.LoginBox') ?>


<section>
	<br/><br/>
	<a href="//s.phpguide.co.il/mvcebook/" style="border:none;" border=0
	title="למד איך עובד MVC"
	onClick="Analytics.track('Promotion', 'click', 'GoToLanding', 'mvcebook-sidebar-banner1');"
	>

		<img title="http://s29.postimg.org/8r9adrhef/banner_1.png" 
		alt="למד איך ופעל MVC"
		/>
	</a>
</section>


<section class="rblock">
    <h3>
        <a href="//s.phpguide.co.il/oopbook/" style="color:rgb(255, 82, 0)">
            למד לבנות מערכות גדולות באמצעות תכנות מונחה עצמים
			&mdash;
			הספר
        </a>
    </h3>
    <p>
		
        סוף סוף תוכל להתקדם ברמה וללמוד תכנות מונחה עצמים בעברית פשוטה, בצורה מלאה עם הסברים ברורים ודוגמאות קוד קצרות מאפס
		
		
    </p>
	<!--
    <br/>

    <a class="price_only" href="//s.phpguide.co.il/oopbook/">
    <?= number_format(\Yii::app()->params['products']['oopbook']['price'], 2); ?>
    בלבד
    </a>
	-->
</section>

<div class='rblock' style="padding:0 -50px; width:100%; background: white;">
    <a href='http://s.phpguide.co.il/oopbook/'>
        <img src="http://i.picresize.com/images/2013/12/09/LzjqY.png" alt="" />
    </a>
</div>

<?php if($this->beginCache('RecentEventsFragmentCache', $recentEventsCacheParams)) { ?>

    <?php $this->widget('application.components.RecentEvents'); ?>

<?php $this->endCache(); } ?>

<section class="logos">
	<a href="https://github.com/intval/phpguide" title='This site is open source!' class='github'></a>
	<a href="http://feeds.feedburner.com/phpguideblog" title='All new blog posts via RSS' class='rss'></a>
</section>