<?php

class MainNavBarWidget extends \PHPGWidget
{
    const POSTS = 'posts';
    const FORUM = 'qna';
    const EVENTS = 'events';
    const MARKET = 'market';
    const PHPLIVE = 'phplive';
    const CONTACT = 'contact';
    const CAREER = 'career';
    const FREELANCE = 'freelance';

    /*** @const */
    private static $mainBar = [
        self::POSTS => 'פוסטים',
        self::FORUM => 'פורום',
        //self::EVENTS => 'אירועים',
        self::PHPLIVE => 'PHP Live',
        self::MARKET => 'חנות',
        self::CONTACT => 'צור קשר'
    ];


    /** @var string $navItem Set in the controller and passed during rendering */
    public $navItem;


    public function run()
    {
        $this->render('mainNavBar', ['items' => self::$mainBar, 'active' => $this->navItem]);
    }
} 
