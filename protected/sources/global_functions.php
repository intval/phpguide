<?php

/**
 * This file contains shortcuts and global functions available in the entire project
 * @author Alex Raskin (Alex@phpguide.co.il)
 */


/**
 * Shortuct for htmlspecialchars($x, ent_quotes, utf-8)
 * @param string $data string to escape
 * @return string escaped html
 */
function e($data)
{
    return htmlSpecialChars($data, ENT_QUOTES);
}

/**
 * Returns baseUrl for given url if any, otherwise returns Yii::app()->baseUrl
 * @staticvar string $baseUrl caches baseUrl instead of calculating it every function call
 * @param string $url postfix the baseUrl with this provided url
 * @param bool $prepend_host - shall add http://hostname/ to url ?
 * @return string Yii::app()->baseUrl + $url
 */
function bu($relativePath = null, $prepend_host = false)
{
    $url = '';
    
    if($prepend_host) 
    {
         $url .= Yii::app()->request->getHostInfo();
    }
    
    $url .= Yii::app()->getRequest()->getBaseUrl();
    
    if($relativePath)
    {
        $url .= '/'.ltrim($relativePath,'/');
    }
    
    return $url;
}