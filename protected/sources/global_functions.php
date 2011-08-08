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
    return htmlSpecialChars($data, ENT_QUOTES, 'UTF-8');
}

/**
 * This is the shortcut to Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function bu($url=null) 
{
    static $baseUrl;
    if ($baseUrl===null)
        $baseUrl=Yii::app()->getRequest()->getBaseUrl();
    return $url===null ? $baseUrl : $baseUrl.'/'.ltrim($url,'/');
}