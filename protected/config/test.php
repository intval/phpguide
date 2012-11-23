<?php

function mergeArray($a,$b)
{
    $args=func_get_args();
    $res=array_shift($args);
    while(!empty($args))
    {
        $next=array_shift($args);
        foreach($next as $k => $v)
        {
            if(is_integer($k))
                isset($res[$k]) ? $res[]=$v : $res[$k]=$v;
            else if(is_array($v) && isset($res[$k]) && is_array($res[$k]))
                $res[$k]=mergeArray($res[$k],$v);
            else
                $res[$k]=$v;
        }
    }
    return $res;
}


return mergeArray
(
    require __DIR__.'/config.php',
    [
        'components'=>
        [
            'fixture'=>
            [
                'class'=>'system.test.CDbFixtureManager'
            ],

            'db' =>
            [
                'connectionString' => 'mysql:host=localhost;dbname=phpg_tests',
            ]
        ]
    ]
);
