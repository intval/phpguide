<?php

namespace RedisDao;

class PostDAL extends RedisDAL implements IPostDAL {

    const TTL = 30;
    const POSTS_BY_DATE_KEY = 'posts:bydate';
    const POSTS_RATINGS_KEY = 'posts:ratings';
    const POSTS_RATIGS = 'posts:rating:%d';
    const POSTS_VIEWS = 'posts:views:%d';
    const POSTS_USER_VOTES = 'posts:userRatingVotes:%d_%d';


    public function GetPostIdsByRating(\DateTimeInterface $since, \DateTimeInterface $till)
    {

        $start = floor($since->getTimestamp() / self::TTL) * self::TTL;
        $end = ceil($till->getTimestamp() / self::TTL) * self::TTL;
        $tempPostsByRatingAndDate = "posts:byRatingAndDate:{$start}_{$end}";

        if(!$this->redis->exists($tempPostsByRatingAndDate))
        {
            $postsInTimeRange = $this->redis->zRevRangeByScore(self::POSTS_BY_DATE_KEY, $end, $start, ['withscores' => true]);

            if(count($postsInTimeRange) < 1)
                return [];

            // workaround for missing zRevRangeByScoreStor https://github.com/antirez/redis/issues/678
            $tempPostsByDateKey = "posts:bydate:{$start}_{$end}";
            $this->redis->expire($tempPostsByDateKey, self::TTL);

            foreach($postsInTimeRange as $postid => $time)
                $this->redis->zAdd($tempPostsByDateKey, -$time, $postid);


            $this->redis->zInter
            (
                $tempPostsByRatingAndDate,
                ['posts:ratings', $tempPostsByDateKey],
                [1, 0]
            );
            $this->redis->expire($tempPostsByRatingAndDate, self::TTL);
        }

        return $this->redis->zRevRange($tempPostsByRatingAndDate, 0, -1);

    }

    public function IncrementPostRating($postid, $incr = 1, $userid = null)
    {
        $newRating = $this->redis->incrBy(sprintf(self::POSTS_RATIGS, $postid), $incr);
        $this->redis->zAdd(self::POSTS_RATINGS_KEY, $newRating, $postid);

        if(null !== $userid)
            $this->redis->set(sprintf(self::POSTS_USER_VOTES, $postid, $userid), (new \DateTime())->getTimestamp());

        return $newRating;
    }

    public function SetPostDate($postid, \DateTimeInterface $date)
    {
        return $this->redis->zAdd(self::POSTS_BY_DATE_KEY, $date->getTimestamp(), $postid);
    }

    public function GetPostRating($postid)
    {
        return $this->redis->get(sprintf(self::POSTS_RATIGS, $postid)) ?: 0;
    }

    public function IncrementPostViewsCount($postid, $incr = 1)
    {
        return $this->redis->incrBy(sprintf(self::POSTS_VIEWS, $postid), $incr);
    }

    public function GetPostViewsCount($postid)
    {
        return $this->redis->get(sprintf(self::POSTS_VIEWS, $postid)) ?: 0;
    }

    public function HasUserVoted($postid, $userid)
    {
        return $this->redis->exists(sprintf(self::POSTS_USER_VOTES, $postid, $userid));
    }
}