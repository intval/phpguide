<?='<'?>?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

<?php foreach($items as $item):
switch($item['type']):
	case 'qna': $url = Yii::app()->createUrl('qna/view', array('id' => $item['id'], 'subj' => $item['loc'])); break;
	case 'article': $url =  '/'. urlencode($item['loc']).'.html'; break;
endswitch;
?>
<url>
	<loc><?= bu($url, true) ?></loc>
	<lastmod><?= $item['lastmod']?></lastmod>
	<changefreq><?= $item['freq']?></changefreq>
	<priority><?= $item['priority']?></priority>
</url>
<?php endforeach; ?>

</urlset>