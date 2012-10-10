<?php

/**
 * DateTime with support for __toString() and few other usefull methods
 * @author Alex Raskin <Alex@phpguide.co.il>
 */
class SDateTime extends DateTime
{
	public function __toString()
	{
		return $this->format('Y-m-d H:i:s');
	}
	
	
	/**
	 * Returns dates string with hebrew month name in it
	 * @param string $strDate
	 */
	public static function translateDate($strDate)
	{
		static $months = Array("ינואר", "פברואר", "מרץ", "אפריל", "מאי", "יוני", "יולי", "אוגוסט", "ספטמבר", "אוקטובר", "נובמבר", "דצמבר");
		static $eng_months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct','Nov', 'Dec');
		return str_replace($eng_months, $months, $strDate);
	}
	
	
	/**
	 * Returns full date string with hebrew months' names
	 * @param bool $includeHoursAndMinutes or date only?
	 */
	public function date2heb($includeHoursAndMinutes = false)
	{
		return self::translateDate( $this->format('d לM Y' . ($includeHoursAndMinutes ? ' H:i' : '')) );
	}
	
	/**
	 * Returns date in RFC format expected by <time> tags
	 */
	public function date2rfc()
	{
		return $this->format('Y-m-d\TH:i:sP');
	}
	
}