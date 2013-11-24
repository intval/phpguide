<?php

class Helpers
{
	  
	/**
	 * finds all urls in text and appends <a> tags to them
	 * @param string $string_containing_urls
     * @return string
	 */
    public static function anchorize_urls_in_text($string_containing_urls)
    {
            // clear url
            $string_containing_urls  =    str_replace("\\r","\r",$string_containing_urls);
            $string_containing_urls  =    str_replace("\\n","\n<br/>",$string_containing_urls);
            $string_containing_urls  =    str_replace("\\n\\r","\n\r",$string_containing_urls);

            $pattern = '@\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))@si';
            return preg_replace_callback($pattern, array('static', 'decodeurls') ,$string_containing_urls);
    }

    
    /**
     * Used as callback for the preg_replace_callback in the method above (anchorize_urls_in_text)
     * @param array $regexp_matches
     * @return string
     */
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
            $result .= $dictionary[mt_rand(0, 60)];
        }
        return $result;
    }


    /**
     * Sends an email with proper headers
     * @param array $to list of recipients
     * @param string $subject mail's subject
     * @param string $content mail's html content
     * @param string $attachmentPath
     * @return
     */
    public static function sendMail(array $to, $subject, $content, $attachmentPath = '')
    {
        $message = new YiiMailMessage($subject, $content, 'text/html', 'utf-8');

        /*** Swift_Message $msg */
        $msg = $message->message;

        $msg->setTo($to);
        $msg->setFrom(Yii::app()->params['emailFrom']);

        if($attachmentPath)
        {
            $msg->attach(Swift_Attachment::fromPath($attachmentPath));
        }

        return Yii::app()->mail->send($message);
    }

}