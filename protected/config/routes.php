<?php
return array
(
    'http://jobs.<zone:(local\.)?>phpguide.co.il' => 'jobs/default/index',
    'http://jobs.<zone:(local\.)?>phpguide.co.il/<controller:[a-z]+>/<action:\w+>' => 'jobs/<controller>/<action>',

    'qna'                                                       => 'forum/qna/index',
	'q<id:\d+>/<subj:[-_\+\sA-Za-z0-9א-ת]+>.htm'                => 'forum/qna/view',
    'qna/<action:\w+>'                                          => 'forum/qna/<action>',

    ''                                                          => 'homepage/index',
	'<article_url:[-_\+\sA-Za-z0-9א-ת]+>\.htm'                  => 'Article/index',
	'cat/<cat_url:[-_\+\sA-Za-z0-9א-ת]+>\.htm'                  => 'Category/index',
	'users/<username:[-_\+\sA-Za-z0-9א-ת\.]+>/<action:\w+>'		=> 'Users/<action>',
	'users/<username:[-_\+\sA-Za-z0-9א-ת\.]+>'		            => 'Users/user',
    '<controller:[a-z]+>/<action:\w+>'                          => '<controller>/<action>',
    'rss'                                                       => 'Homepage/rss'
);
