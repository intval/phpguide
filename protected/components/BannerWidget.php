<?php
class BannerWidget extends CWidget
{
	public $type;
	
	public function run()
	{
		if(defined('YII_DEBUG') && YII_DEBUG) return;
		echo '<br/>', $this->sidebanners[array_rand($this->sidebanners, 1)];
	}
	
	
	private $sidebanners = array
	(
			'<object type="application/x-shockwave-flash" data="http://banners.clickon.co.il/1111111111111111111111111111111111111111111111111111111/swf/flights_eilat_wallatours300x250.swf?url=http://www.wallatours.co.il?coId=0WRlwDYlKqVJVb1_7wVv62lVZ0aCDzX_Ts0WRlwDYlKqVJVb1tS" width="300" height="250">
				<param name="movie" value="http://banners.clickon.co.il/1111111111111111111111111111111111111111111111111111111/swf/flights_eilat_wallatours300x250.swf?url=http://www.wallatours.co.il?coId=0WRlwDYlKqVJVb1_7wVv62lVZ0aCDzX_Ts0WRlwDYlKqVJVb1tS" />
				<param name="scale" value="exactfit" />
				<param name="wmode" value="transparent" />
			</object>',
			
			'<object type="application/x-shockwave-flash" data="http://banners.clickon.co.il/LOVELY2_banners/swf/meetPre_300X250_5612.swf?url=http://aff.clickon.co.il/click/0WRlwDYlKqVJVb1/bJuJ8SlRJxszZ3G/Ts0WRlwDYlKqVJVb1tS" width="300" height="250">
				<param name="movie" value="http://banners.clickon.co.il/LOVELY2_banners/swf/meetPre_300X250_5612.swf?url=http://aff.clickon.co.il/click/0WRlwDYlKqVJVb1/bJuJ8SlRJxszZ3G/Ts0WRlwDYlKqVJVb1tS" />
				<param name="scale" value="exactfit" />
				<param name="wmode" value="transparent" />
			</object>',
			
			'<object type="application/x-shockwave-flash" data="http://banners.clickon.co.il/1111111111111111111111111111111111111111111111111111111/swf/Group_1_300X250_caller.swf?url=http://aff.clickon.co.il/click/0WRlwDYlKqVJVb1/nPY1X6z4nEvPPdF/Ts0WRlwDYlKqVJVb1tS" width="300" height="250">
				<param name="movie" value="http://banners.clickon.co.il/1111111111111111111111111111111111111111111111111111111/swf/Group_1_300X250_caller.swf?url=http://aff.clickon.co.il/click/0WRlwDYlKqVJVb1/nPY1X6z4nEvPPdF/Ts0WRlwDYlKqVJVb1tS" />
				<param name="scale" value="exactfit" />
				<param name="wmode" value="transparent" />
			</object>',
			
			'<object type="application/x-shockwave-flash" data="http://banners.clickon.co.il/11/swf/tamibar_300x250B.swf?url=http://aff.clickon.co.il/click/0WRlwDYlKqVJVb1/yH3gTTEjlA7Zcz5/Ts0WRlwDYlKqVJVb1tS" width="300" height="250">
			<param name="movie" value="http://banners.clickon.co.il/11/swf/tamibar_300x250B.swf?url=http://aff.clickon.co.il/click/0WRlwDYlKqVJVb1/yH3gTTEjlA7Zcz5/Ts0WRlwDYlKqVJVb1tS" />
					<param name="scale" value="exactfit" />
				<param name="wmode" value="transparent" />
			</object>',
			
			'<object type="application/x-shockwave-flash" data="http://banners.clickon.co.il/LOVELY2_banners/swf/datingPre_300X250_23412.swf?url=http://aff.clickon.co.il/click/0WRlwDYlKqVJVb1/Yv1AFvr3A41tZKq/Ts0WRlwDYlKqVJVb1tS" width="300" height="250">
			<param name="movie" value="http://banners.clickon.co.il/LOVELY2_banners/swf/datingPre_300X250_23412.swf?url=http://aff.clickon.co.il/click/0WRlwDYlKqVJVb1/Yv1AFvr3A41tZKq/Ts0WRlwDYlKqVJVb1tS" />
					<param name="scale" value="exactfit" />
				<param name="wmode" value="transparent" />
			</object>',
			
			'<object type="application/x-shockwave-flash" data="http://banners.clickon.co.il/1111111111111111111111/swf/300x250.swf?url=http://aff.clickon.co.il/click/0WRlwDYlKqVJVb1/g0fWSyNb7EQ0y4P/Ts0WRlwDYlKqVJVb1tS" width="300" height="250">
			<param name="movie" value="http://banners.clickon.co.il/1111111111111111111111/swf/300x250.swf?url=http://aff.clickon.co.il/click/0WRlwDYlKqVJVb1/g0fWSyNb7EQ0y4P/Ts0WRlwDYlKqVJVb1tS" />
					<param name="scale" value="exactfit" />
				<param name="wmode" value="transparent" />
			</object>',
			
			'<object type="application/x-shockwave-flash" data="http://banners.clickon.co.il/LOVELY2_banners/swf/prof2Pre_300X250.swf?url=http://aff.clickon.co.il/click/0WRlwDYlKqVJVb1/YmK8lkFdCvKA0bz/Ts0WRlwDYlKqVJVb1tS" width="300" height="250">
			<param name="movie" value="http://banners.clickon.co.il/LOVELY2_banners/swf/prof2Pre_300X250.swf?url=http://aff.clickon.co.il/click/0WRlwDYlKqVJVb1/YmK8lkFdCvKA0bz/Ts0WRlwDYlKqVJVb1tS" />
					<param name="scale" value="exactfit" />
				<param name="wmode" value="transparent" />
			</object>',
			
			'<object type="application/x-shockwave-flash" data="http://banners.clickon.co.il/nuqxApDCby522Xl/swf/ista_packages_300x250.swf?url=http://www.issta.co.il/?utm_source=clickon%26utm_medium=banner%26utm_campaign=abroad%26campid=4008%26coID=0WRlwDYlKqVJVb1_taMNsrqeSsXTqVb_Ts0WRlwDYlKqVJVb1tS" width="300" height="250">
				<param name="movie" value="http://banners.clickon.co.il/nuqxApDCby522Xl/swf/ista_packages_300x250.swf?url=http://www.issta.co.il/?utm_source=clickon%26utm_medium=banner%26utm_campaign=abroad%26campid=4008%26coID=0WRlwDYlKqVJVb1_taMNsrqeSsXTqVb_Ts0WRlwDYlKqVJVb1tS" />
				<param name="scale" value="exactfit" />
				<param name="wmode" value="transparent" />
			</object>'
	);
	
	
}