<?php

class Helpers
{
    public static function date2heb(DateTime $date, $long = false)
    { 
        return self::translateDate( $date->format('d לM Y' . ($long ? ' H:i' : '')) );
    }
    
    public static function date2rfc(DateTime $date)
    {
        return $date->format('Y-m-dTH:i:s');
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
            $string_containing_urls  =    str_replace("\\n","\n<BR>",$string_containing_urls);
            $string_containing_urls  =    str_replace("\\n\\r","\n\r",$string_containing_urls);

            $pattern = '@(https?://(?:idea\.)?phpguide\.co\.il\S+[[:alnum:]]/?)@si';
            return preg_replace_callback($pattern, array('self', 'decodeurls') ,$string_containing_urls);
    }

    private static function decodeurls(array $regexp_matches)
    {
            return '<span dir="ltr"><a href="'.$regexp_matches[1].'">'.urldecode($regexp_matches[1]).'</a></span>';
    }
    
    
    /**
     * Sends an message to 
     * @param type $message 
     */
    public static function jabber($message, $to = 'alex.raskin@jabber.ru')
    {
        @file_get_contents
        (
            'http://phpguide.co.il/tools/jabber/index.php?no_proxy&m='.urlencode($message).'&to='.  urlencode($to), 
            false, 
            stream_context_create(array('http' => array('timeout' => 0.3)))
        );
    }



    /**
     * Gets user's ip address from environment and server variables
     * @return string $ip — user's IP adderss
     */
    public static function getip()
    {
        static $ip;
        if( $ip !== null) return $ip;
        
        if( getenv("HTTP_CLIENT_IP"))              $ip = getenv("HTTP_CLIENT_IP");
        elseif( getenv("HTTP_X_FORWARDED_FOR"))    $ip = getenv("HTTP_X_FORWARDED_FOR");
        elseif( getenv("REMOTE_ADDR"))             $ip = getenv("REMOTE_ADDR");
        elseif(isset($_SERVER['REMOTE_ADDR']))     $ip = $_SERVER['REMOTE_ADDR'];
        
        return $ip;
    }
    
    
    /**
     * @param int $length length of the desired string
     * @return string string of randomly positioned letters and digits
     */
    public static function randString($length = 4)
    {
        return substr(str_shuffle('abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890') , 0, $length);
    }
    
}