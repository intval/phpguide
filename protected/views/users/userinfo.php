<div class="viewing_profile">
	
	<div class='nick_and_ava'>
		<?php $this->widget('GravatarWidget', array('size' => 85, 'email' => $user->email)); ?>
		<div class='right nick_and_rating'>
			<div class='nick'><?=e($user->login)?></div>
			<div class='name'><?/*=e($user->name) /* Should ask user's permission to display this */?></div>
			<div class='points'>רייטינג: <span><?=e($user->points)?></span></div>
		</div>
		<div class='clear'></div>
	</div>
	
	<div class='tabs'>
		<ul class="nav nav-tabs">
		  <li class='active'><a href="#whois" data-toggle="tab">Whois</a></li>
		  <li><a href="#posts" data-toggle="tab">מה כתב<?if($user->gender === 'female') echo 'ה';?></a></li>
		  <li><a href="#about" data-toggle="tab"><?= $user->gender === 'male' ? 'מספר על עצמו' : 'מספרת על עצמה' ?></a></li>
		</ul>
		
		<div class="tab-content">
		  <div class="tab-pane active" id="whois">
		  
			<table class='whois_info'>
				<tr>
					<td>מין:</td>
					<td><?=$user->gender === 'male' ? 'גבר' : 'בחורה מקסימה'?></td>
				</tr>
				<tr>
					<td>יום הולדת:</td>
					<td><?=e($user->birthdate)?></td>
				</tr>
				<tr>
					<td>עיר:</td>
					<td><?=e($user->city)?></td>
				</tr>
				<tr>
					<td>אתר:</td>
					<td><?=e($user->site)?></td>
				</tr>
				<tr>
					<td>נרשם:</td>
					<td><?if($user->reg_date != null) echo e($user->reg_date->date2heb(1))?></td>
				</tr>
				<tr>
					<td>ביקר:</td>
					<td><? if($user->last_visit != null) echo e($user->last_visit->date2heb(1))?></td>
				</tr>
			</table>
		  
		  
		  
		  </div>
		  <div class="tab-pane" id="posts">
		  
		  	<? foreach($user->blogposts as $post): ?>
		  	
		  		<a href="<?=bu(e(urlencode($post->url)));?>.htm" title='<?=str_replace( "'", "#39;", $post->html_desc_paragraph)?>'><?=e($post->title)?></a><br/>
		  		
		  		
		  		<br/>
		  	
		  	
		  	<? endforeach; ?>
		  
		  </div>
		  <div class="tab-pane" id="about"><?=e($user->about)?></div>
		</div>
		 
		 
	</div>
	
</div>