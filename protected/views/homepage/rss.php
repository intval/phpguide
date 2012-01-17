<?='<?'?>xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
<channel>

    <title>בלוג ה-phpguide</title>
    <link><?=bu(null, true)?></link>
    <description><![CDATA[מדריך, חדשות, עדכונים ופרסומים בעולם ה-php]]></description>
    <language>he-IL</language>
    <managingEditor><?=Yii::app()->params['adminEmail']?></managingEditor>

    <generator><?=bu(null, true)?></generator>
    <pubDate><?=Helpers::date2rfc(new DateTime($articles[0]->pub_date))?></pubDate>
    <lastBuildDate><?=Helpers::date2rfc(new DateTime($articles[0]->pub_date))?></lastBuildDate>


    <? foreach( $articles as $item ): ?>
        <item>
            <title><![CDATA[<?=e($item->title)?>]]></title>
            <guid><?=e(bu(urlencode($item->url . '.htm'), true))?></guid>
            <link><?=e(bu(urlencode($item->url . '.htm'), true))?></link>
            <description><![CDATA[
                <div dir='rtl'>
                    <table>
                        <tr>
                            <td><img src="<?=e($item->image)?>" alt="image"/></td>
                            <td width="20"></td>
                            <td valign="top"> <?= $item->html_desc_paragraph ?> </td>
                        </tr>
                    </table>

                </div>]]></description>
            <pubDate><?=Helpers::date2rfc(new DateTime($item->pub_date))?></pubDate>
            <category><?=bu(null, true)?></category>
        </item>
    <? endforeach; ?>


</channel>
</rss>