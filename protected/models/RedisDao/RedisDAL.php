<?php

namespace RedisDao;


class RedisDAL {

    /**
     * @var \Redis $redis Redis connection
     */
    protected $redis = null;

    public function __construct(\Redis $redisInstance)
    {
        $this->redis = $redisInstance;
    }
} 