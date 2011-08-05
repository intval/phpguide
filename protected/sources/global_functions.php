<?php

/**
 * This file contains shortcuts and golbal functions available in the entire project
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