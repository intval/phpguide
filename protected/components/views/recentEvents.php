  <div class="events-list">
   
    
        <? foreach($events as $event): ?>
        <div class="event">
            <span><?=e($event['hour']);?></span> <?=e($event['author']);?> <br/>
            <? if($event['is_blog'] === '1'): // blog comment ?>
            <a href="<?=bu(urlencode($event['location']).".htm#comment".e($event['eventid']));?>"><?=e(urldecode($event['text']));?>&mldr;</a>

            <? elseif($event['is_blog'] === '3'): // forum post ?>
            <a href="/forum/index.php/topic,<?=urlencode($event['location']);?>.0.html" ><?=e(urldecode($event['text']));?>&mldr;</a>
            <? endif; ?>
        </div>
        <? endforeach; ?>
    </div>