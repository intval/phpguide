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
    return htmlSpecialChars($data, ENT_QUOTES | ENT_DISALLOWED | ENT_HTML5, 'UTF-8');
}

/**
 * Returns baseUrl for given url if any, otherwise returns Yii::app()->baseUrl
 * @param string $relativePath the path to return relatively to the base url
 * @param bool $prependHost - shall add http://hostname/ to url ?
 * @param string $subDomain
 * @return string Yii::app()->baseUrl + $url
 */
function bu($relativePath = null, $prependHost = true, $subDomain = '')
{
    $url = Yii::app()->getRequest()->getBaseUrl($prependHost || $subDomain);
    
    if($relativePath)
        $url .= '/'.ltrim($relativePath,'/');

    if($subDomain)
        $url = str_replace('://', '://' . $subDomain . '.', $url);

    return $url;
}