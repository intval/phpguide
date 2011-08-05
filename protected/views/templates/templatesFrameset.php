<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="utf-8" />
    <title>עיצובים להורדה - <?=e($template->name)?></title>
    <meta name="robots" content="noindex, nofollow" />
    <link rel="shortcut icon" href="/static/images/favicon.ico" />
</head>
        <frameset rows="93,*">
                <frame scrolling="no" src="topframe/<?=$template->id?>" />
                <frame src="http://ncdn.phpguide.co.il/templates/<?=urlencode($template->filename)?>/" />
        </frameset>
</html>
