<?php

/**
 * DateTime with support for __toString() and few other usefull methods
 * @author Alex Raskin <Alex@phpguide.co.il>
 */
class SDateTime extends DateTime implements JsonSerializable
{
	public function __toString()
	{
		return $this->format('Y-m-d H:i:s');
	}
	
	
	/**
	 * Returns dates string with hebrew month name in it
	 * @param string $strDate
     * @return string localized
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
     * @return string
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

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return $this->date2rfc();
    }
}