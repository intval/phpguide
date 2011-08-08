  <div class="events-list">
   
    
        <? foreach($events as $event): ?>
        <div class="event">
            <span><?=e($event['hour']);?></span> <?=e($event['author']);?> <br/>
            <? if($event['is_blog'] === '1'): ?>
            <a href="<?=bu(e($event['location']).".htm#comment".e($event['eventid']));?>"><?=e(urldecode($event['text']));?>&mldr;</a>
            <? elseif($event['is_blog'] === '2'): ?>
            <a href="<?=e(bu("/qna/".$event['eventid']));?>><?=e($event['text']);?></a>
            <? elseif($event['is_blog'] === '3'): ?>
            <a href="/forum/index.php/topic,<?=e($event['location']);?>.0.html" ><?=e(urldecode($event['text']));?>&mldr;</a>
            <? endif; ?>
        </div>
        <? endforeach; ?>
    </div>