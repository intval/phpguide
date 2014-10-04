<?php
return array
(
    'qna'                                                       => 'forum/qna/index',
	'q<id:\d+>/<subj:[-_\+\sA-Za-z0-9א-ת]+>.htm'                => 'forum/qna/view',
    'qna/<action:\w+>'                                          => 'forum/qna/<action>',
    'forum/<categoryId:\d+>'                                    => 'forum/qna/category',

    'market'                                                    => 'market/market/index',
    'posts/best/<scope:(alltime)+>'                             => 'posts/best',
    'posts/changeRating/<postid:\d+>'                           => 'posts/changeRating',
    'posts/<id:\d+>'                                            => 'posts/redirectById',

    ''                                                          => 'homepage/index',
	'<article_url:[-_\+\sA-Za-z0-9א-ת]+>.htm'                   => 'Article/index',
	'cat/<cat_url:[-_\+\sA-Za-z0-9א-ת]+>.htm'                   => 'Category/index',
	'users/<username:[\w\.\'\+]+>/<action:\w+>'		            => 'Users/<action>',
	'users/<username:[\w\.\'\+]+>'		                        => 'Users/user',
    '<controller:[a-z]+>/<action:\w+>'                          => '<controller>/<action>',
    'rss'                                                       => 'Homepage/rss'
);
