<?php

class SubNavBarWidget extends \PHPGWidget
{


    public $subNavItem;
    public $mainNavItem;


    const POSTS_NEWEST = 'posts';
    const POSTS_BEST_ALLTIME = 'posts/best/alltime';
    const POSTS_BEST_MONTH = 'posts/best/month';
    const POSTS_CATEGORIES = 'category/list';

    const FORUM_LIST = 'qna';
    const FORUM_NEW = 'qna/listnew';

    const EVENTS_UPCOMING = 'events';
    const EVENTS_PASSED = 'events/passed';

    /** @const array */
    private static $items = [
        \MainNavBarWidget::POSTS => [
            self::POSTS_NEWEST => 'חדשים',
            self::POSTS_BEST_ALLTIME => 'הכי טובים',
            self::POSTS_CATEGORIES => 'לפי קטגוריה'
        ],
        \MainNavBarWidget::FORUM => [
            self::FORUM_LIST => 'כל הפורומים',
            self::FORUM_NEW => 'דיונים אחרונים'
        ],
        \MainNavBarWidget::EVENTS => [],
        \MainNavBarWidget::MARKET => []
    ];

    public function run()
    {
        $items = [];
        if(isset(self::$items[$this->mainNavItem]))
            $items = & self::$items[$this->mainNavItem];

        $this->render('subNavBar', ['items' => & $items, 'active' => $this->subNavItem]);
    }
} 