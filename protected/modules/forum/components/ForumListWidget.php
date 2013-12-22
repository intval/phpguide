<?php

Class ForumListWidget Extends CWidget
{
    public function run()
    {
        $this->render(
            'forum.views.forum.forumsList',
            ['questionsWithCategories' => QnaQuestion::model()->categoriesWithLastPost()->findAll()]
        );
    }
}