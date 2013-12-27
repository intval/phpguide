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

<?php if($this->beginCache('RecentEventsFragmentCache', $recentEventsCacheParams)) { ?>

    <?php $this->widget('application.components.RecentEvents'); ?>

<?php $this->endCache(); } ?>

<section class="logos">
	<a href="https://github.com/intval/phpguide" title='This site is open source!' class='github'></a>
	<a href="http://feeds.feedburner.com/phpguideblog" title='All new blog posts via RSS' class='rss'></a>
</section>