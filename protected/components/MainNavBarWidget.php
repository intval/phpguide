<?php

class MainNavBarWidget extends \PHPGWidget
{
    const POSTS = 'posts';
    const FORUM = 'qna';
    const EVENTS = 'events';
    const MARKET = 'market';
    const CAREER = 'career';
    const FREELANCE = 'freelance';

    /*** @const */
    private static $mainBar = [
        self::POSTS => 'פוסטים',
        self::FORUM => 'פורום',
        self::EVENTS => 'אירועים',
        self::MARKET => 'מארקט'
    ];


    /** @var string $navItem Set in the controller and passed during rendering */
    public $navItem;


    public function run()
    {
        $this->render('mainNavBar', ['items' => self::$mainBar, 'active' => $this->navItem]);
    }
} 