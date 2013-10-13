<?php
return array
(
	'' => 'homepage/index',
	'q<id:\d+>/<subj:[-_\+\sA-Za-z0-9א-ת]+>.htm' => 'qna/view',
	'<article_url:[-_\+\sA-Za-z0-9א-ת]+>\.htm'  => 'Article/index',
	'cat/<cat_url:[-_\+\sA-Za-z0-9א-ת]+>\.htm'  => 'Category/index',
	'users/<username:[-_\+\sA-Za-z0-9א-ת\.]+>/<action:\w+>'		=> 'Users/<action>',
	'users/<username:[-_\+\sA-Za-z0-9א-ת\.]+>'		=> 'Users/user', 	
	'<controller:[a-z]+>/<action:\w+>'          => '<controller>/<action>',
	'rss'                                       => 'Homepage/rss'     
);
