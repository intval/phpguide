<?php

namespace RedisDao;


interface IPostDAL
{
    public function GetPostIdsByRating(\DateTimeInterface $since, \DateTimeInterface $till);

    public function IncrementPostRating($postid, $incr, $userid);

    public function GetPostRating($postid);

    public function SetPostDate($postid, \DateTimeInterface $date);

    public function IncrementPostViewsCount($postid);

    public function GetPostViewsCount($postid);

    public function HasUserVoted($postid, $userid);
} 