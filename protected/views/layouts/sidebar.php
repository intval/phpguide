<section id="search_box">
    <form method="get" action="http://www.google.co.il/search" id="search_form">
    
        <input type="hidden" name="hl" value="iw" />
        <input type="checkbox"  name="sitesearch" style="display:none" value="phpguide.co.il" checked />
        
        <input type="text" class="search_form" placeholder="חיפוש" name="q" id="search_field"/>
        <input type="submit" value="" title="לחפש"> 
        
    </form>
</section>
    
    
<? $this->widget('application.components.LoginBox') ?>

<? $this->widget('application.components.RatingWidget'); ?>
			
<? $this->widget('application.components.RecentEvents'); ?>

<section class="logos">
	<a href="https://github.com/intval/phpguide" title='phpguide is open source. Help us!' class='github'></a>
	<a href="http://feeds.feedburner.com/phpguideblog" title='All new blog posts via RSS' class='rss'></a>
</section>