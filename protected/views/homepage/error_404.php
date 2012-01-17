<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="/static/styles/style.css" />
    <title>HTTP/1.1 404 Page Not Found</title>
</head>

<body class='luck-page' dir="rtl">

    <a href="/" title="לעמוד הראשי" class="luck-homepage-link">
        <img src="http://ncdn.phpguide.co.il/blogimages/minilogo.jpg" alt="עמוד הבית" title="לעמוד הראשי"/>
    </a>

    <div class='luck-page'><p>HTTP/1.1 404 Page Not Found</p></div>

    <div style="width:750px; margin:0 auto;">
        <img src="http://ncdn.phpguide.co.il/blogimages/404.png" style="display:block; float:right;" alt="wheel of luck"/>
        <div style="display:block; float: right; margin-right:70px; width:420px; line-height:22px;">
            <h1 style="color:#FF5BBB;">עמוד האושר</h1>
            <br/>
            העמוד הזה — מזל שאסוף מכל רחבי העולם. ג'ון קארלוס הקליד בשורת הכתובת של הדפדפן
            <span dir="ltr" >phpguide.co.il/<b>ןמגקס</b>.php</span> במקום <b>index</b>.php והגיע לעמוד הזה.
            מר לוי כתב <b>/form/</b> במקום <b>/forum/</b> וגם הוא הגיע לעמוד הזה.
            מאוחר יותר שניהים נהיו מאושרים. המזל לא יפספס גם אתכם.
            <br/><br/>
אם הגעתם לעמוד האושר דרך קישור באתר, התחלקו במזל הזה עם עשרה חברים
ואם חיפשתם משהו מסוים, יכול להיות שזה מחכה לכם כאן:

        </div>
        <div class="clear"></div>
        <div class="clear"></div>
        <br/><br/><br/><br/>
        <ol class="luck-read-more">
        <? foreach($alternatives as $article): ?>
        <li style="margin-top:20px;">
            <a href="/<?=urlencode($article->url)?>.htm" title="<?=e($article->description)?>" rel="details" >
            <?=e($article->title)?></a> <br/> <?=e($article->description)?>
        </li>
        <? endforeach; ?>
        </ol>
        
    </div>
</body>
</html>
