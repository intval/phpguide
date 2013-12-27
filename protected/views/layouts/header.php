<!DOCTYPE html>
<html lang="he" itemscope itemtype="http://schema.org/<?=e($this->metaType)?>" ng-app="phpg">
<head>
    <base href="<?=bu()."/"?>" />
    <meta charset="utf-8" />
    
    <meta name="description" content="<?=e($this->description)?>" />
    <meta name="keywords" content="<?=e($this->keywords)?>" />
    <meta name="author" content="<?=e($this->pageAuthor)?>" />
    
    <?php if ($this->facebook): ?>
    <meta property="og:title" content="<?=e($this->pageTitle)?>" />
    <meta property="og:description" content="<?=e($this->description)?>" />
    <meta property="og:type" content="<?=e($this->facebook['type'])?>" />
    <meta property="og:image" content="<?=e($this->facebook['image'])?>" />
    <meta property="og:url" content="<?=e($this->facebook['current_page_url'])?>" />
    <meta property="og:site_name" content="<?=e($this->facebook['site_name'])?>" />
    <meta property="fb:admins" content="<?=e($this->facebook['admins'])?>" />
    <meta property="fb:app_id" content="<?=e($this->facebook['app_id'])?>" />
    <meta name="medium" content="blog" />
    <?php endif; ?>

    <link rel="shortcut icon" href="<?=bu("static/images/favicon.ico")?>" />
    <?php Yii::app()->clientScript->registerCssFile($this->getAssetsBase().'/styles/allstyles.compiled.css'); ?>

    <link rel="alternate" type="application/rss+xml" title="הירשם לעידכונים ב-RSS" href="http://feeds.feedburner.com/phpguideblog" /> 
    <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    
    <title><?=e($this->pageTitle)?></title>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php $this->addScripts('scripts.compiled','plugins', 'ui', 'analytics'); ?>
	
	<meta itemprop="name" content="<?=e($this->pageTitle)?>">
	<meta itemprop="description" content="<?=e($this->description)?>">
</head>

<body dir='rtl' >
<div class='page-container'>
    
    <section id='header' >

        <div class="topRowHolder">
            <a style="float:left;" href="/"><img src="/static/images/logo.backup.jpg" /></a>
            <nav class="main" style="float:right;">
                <ul>
                    <li><a href="/" class="active">
                            פוסטים
                    </a></li>
                    <li><a href="/qna">
                            פורום
                    </a></li>
                    <li><a href="/events">
אירועים
                    </a></li>
                    <li><a href="<?=bu(null, true, 'market')?>">
                            מארקט
                    </a></li>
                    <li><a href="/qna">
קריירה
                    </a></li>

                </ul>
                <div class="clear" ></div>
            </nav>
            <div class="clear" ></div>
        </div>


        <nav class="sub">
            <ul>
                <li><a href="#">
                        פוסטים
                    </a></li>
                <li><a href="#">
                        פורום
                    </a></li>

            </ul>
            <div class="clear" ></div>
        </nav>

    </section> <!-- /header -->

