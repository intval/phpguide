<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="/static/styles/style.css" />
    <style>
        /************************** 404 LUck pages *******************/
         
        div.luck-page
        {
           
            margin-top:50px;
            background:#fff0f0;
            margin:2em auto;
            width:700px;
         
         
            -moz-border-radius:11px;
            -khtml-border-radius:11px;
            -webkit-border-radius:11px;
            border-radius:11px;
            border:1px solid #dfdfdf;
            padding: 0 25px;
        }
        div.luck-page p{font-size:12px;line-height:18px;margin:25px 0 20px;text-align:center;}
        body.luck-page
        {
                background:white;
                color:#333;
                padding:1em 2em;
                font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
                border:none;
                font-size:14px;
        }
        ol.luck-read-more
        {
            width:400px;
            margin-right:350px;
            margin-top:-50px;
        }
        ol.luck-read-more li
        {
            margin-bottom:10px;
        }
        .luck-forum
        {
            padding-top:30px;
            color:red;
        }
     
     
        .luck-homepage-link
        {
            display:block;
            margin:0 auto;
            width:750px;
            margin-bottom:-30px;
        }
    </style>
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
        <?php foreach($alternatives as $article): ?>
        <li style="margin-top:20px;">
            <a href="/<?=urlencode($article->url)?>.htm" title="<?=e($article->description)?>" rel="details" >
            <?=e($article->title)?></a> <br/> <?=e($article->description)?>
        </li>
        <?php endforeach; ?>
        </ol>
        
    </div>
</body>
</html>
