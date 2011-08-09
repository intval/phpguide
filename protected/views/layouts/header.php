<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="utf-8" />
    <title><?=e($this->vars['title'])?></title>

    <meta name="description" content="<?=e($this->vars['description'])?>" />
    <meta name="keywords" content="<?=e($this->vars['keywords'])?>" />
    <meta name="author" content="<?=e($this->vars['page_author'])?>" />
    <? if ($this->facebook): ?>
    <meta property="og:title" content="<?=e($this->vars['title'])?>"/>
    <meta property="og:description" content="<?=e($this->vars['description'])?>"/>
    <meta property="og:type" content="<?=e($this->facebook['type'])?>"/>
    <meta property="og:image" content="<?=e($this->facebook['image'])?>"/>
    <meta property="og:url" content="<?=e($this->facebook['current_page_url'])?>"/>
    <meta property="og:site_name" content="<?=e($this->facebook['site_name'])?>" />
    <meta property="fb:admins" content="<?=e($this->facebook['admins'])?>"/>
    <meta property="fb:app_id" content="<?=e($this->facebook['app_id'])?>"/>
    <? endif; ?>

    <link rel="shortcut icon" href="<?=bu("static/images/favicon.ico")?>" />
    <link href="<?=bu("static/styles/style.css")?>" rel="stylesheet" />
    <link rel="alternate" type="application/rss+xml" title="הירשם לעידכונים ב-RSS" href="http://feeds.feedburner.com/phpguideblog" /> 
    <!--[if lte IE 7]><link href="<?=bu("/static/styles/ie_style.css")?>" rel="stylesheet" /><![endif]-->
    <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
</head>

<body dir='rtl'>
<div id='header'>
	
	
    <a href='index.php' title="מדריך לימוד PHP" class='homepage-link' rel="start"></a>
    <div class="social-buttons" id="social_buttons"><!-- populated on page load complete with js --></div>
    <nav>
       <ul class='header' id="headernav">
            <li><a href='/forum/' title='פורום PHP' style="color:orangered;font-weight:bold;" class='forum' >פורום PHP</a></li>
            <li><a href="/עיצובים_להורדה" title="עיצובים מימין לשמאל חינם" class="templates">עיצובים להורדה</a></li> 
            <li><a href='/phplive' class="phplive" title='הפעלת קוד PHP און ליין' >php און-ליין</a></li>
	</ul>
    </nav>
    <div class='clear'></div>

</div> <!-- /header -->
