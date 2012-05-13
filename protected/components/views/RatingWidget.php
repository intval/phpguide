<div class='ratingWidgetHeader'>
	<h5 class='right' id='ratingWidgetTableTitle' >רייטינג משתתפים</h5> 
</div>
<table dir="ltr" class="ratingTable">

<?php 

$icons = array('&#x265b;', '&#x265a;', '&#x2654;', '','');

for($i = 0; $i < $usersNum; $i++): 
?>

<tr>
	<td><?=$icons[$i];?></td>
	<td><span><?=e($users[$i]->login)?></span></td>
	<td><?=e($users[$i]->points)?></td>
</tr>

<?php endfor; ?>
</table>



<div id='ratingWidgetHelp' class='ratingWidgetHelp alert-message block-message info'>
	<b>רייטינג משתמשים</b><br/><br/>
	נקודות הרייטינג מתקבלות על ידי פעולות המשתמש באתר, <br/>
	עזרה לאחרים, שאלת שאלות וכתיבת מדריכים בצורה הבאה:
	
	<br/>
	
	<br/><b>1+</b> על שאלת שאלה
	<br/><b>1+</b> על תשובה לשאלה
	<br/><b>20+</b> על כתיבת מדריך
	<br/><b>2-</b> על שאלה או תשובה שתימחק על ידי המפקחים בתור ספאם
</div>