<?php

class Helpers
{
    public static function date2heb(DateTime $date, $long = false)
    { 
        return self::translateDate( $date->format('d לM Y' . ($long ? ' H:i' : '')) );
    }
    
    public static function date2rfc(DateTime $date)
    {
        return $date->format('Y-m-d\TH:i:sP');
    }

    public static function dateStr2heb($date, $long = false)
    {
        return self::date2heb(new DateTime($date), $long);
    }

    public static  function dateStr2rfc($date)
    {
        return self::date2rfc(new DateTime($date));
    }

    public static function translateDate($strDate)
    {
	static $months = Array("ינואר", "פברואר", "מרץ", "אפריל", "מאי", "יוני", "יולי", "אוגוסט", "ספטמבר", "אוקטובר", "נובמבר", "דצמבר");
        static $eng_months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct','Nov', 'Dec');
	return str_replace($eng_months, $months, $strDate);
    }


    public static function anchorize_urls_in_text($string_containing_urls)
    {
            // clear url
            $string_containing_urls  =    str_replace("\\r","\r",$string_containing_urls);
            $string_containing_urls  =    str_replace("\\n","\n<br />",$string_containing_urls);
            $string_containing_urls  =    str_replace("\\n\\r","\n\r",$string_containing_urls);

            $pattern = '@(https?://(?:idea\.)?phpguide\.co\.il\S+[[:alnum:]]/?)@si';
            return preg_replace_callback($pattern, array('static', 'decodeurls') ,$string_containing_urls);
    }

    private static function decodeurls(array $regexp_matches)
    {
            return '<span dir="ltr"><a href="'.$regexp_matches[1].'">'.urldecode($regexp_matches[1]).'</a></span>';
    }
    
    
    
    /**
     * @param int $length length of the desired string
     * @return string string of randomly positioned letters and digits
     */
    public static function randString($length = 4)
    {
        static $dictionary = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $result = '';
        
        for($i = 0; $i < $length; $i++)
        {
            $result .= $dictionary[rand(0, 60)];
        }
        return $result;
    }
    
    
    /**
     * Sends an email with proper headers
     * @param string $to recipient's email
     * @param string $subject mail's subject
     * @param string $content mail's html content
     */
    public static function sendMail($to, $subject, $content)
    {
    	$headers = "From: PHPGuide <noreply@phpguide.co.il>\r\n";
    	$headers .= "MIME-Version: 1.0\r\n";
    	$headers .= "Content-type: text/html; charset=utf-8\r\n";
    	
    	@mail($to, "=?utf-8?B?".base64_encode($subject)."?=", $content, $headers);

    }
}