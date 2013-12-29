<?php


class RedisConnection extends \Redis {

    public $host = '127.0.0.1';

    public function init()
    {
        $this->connect($this->host);
        //$this->setOption( \Redis::OPT_SERIALIZER, \Redis::SERIALIZER_IGBINARY );
    }

} 