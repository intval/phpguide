<?php

class PostsController extends \PHPGController
{
    /** @const string[] */
    private static $allowedBestScopes = ['alltime', 'month', 'day', 'week', 'year'];

    public function actionIndex()
    {
        $posts_per_page = 10;
        $page = 0;

        if(isset($_GET['page']))
        {
            $page = intval($_GET['page']) - 1;
            if($page < 0) $page = 0;
            if($page > 100000) $page = 0;
        }

        $this->mainNavSelectedItem = MainNavBarWidget::POSTS;
        $this->subNavSelectedItem = SubNavBarWidget::POSTS_NEWEST;

        $totalPages = ceil( Article::model()->count() / $posts_per_page );

        $this->render('postsList' ,
            [
                'articles'     => Article::model()->byPage($page, $posts_per_page)->findAll(),
                'paginationTotalPages' => $totalPages,
                'paginationCurrentPage' => $page+1
            ]
        );
    }

    public function actionBest($scope)
    {
        $posts_per_page = 10;
        $page = 0;

        if(isset($_GET['page']))
        {
            $page = intval($_GET['page']) - 1;
            if($page < 0) $page = 0;
            if($page > 100000) $page = 0;
        }

        if(!in_array($scope, self::$allowedBestScopes, true))
            $scope = 'alltime';

        $this->mainNavSelectedItem = MainNavBarWidget::POSTS;
        $this->subNavSelectedItem = SubNavBarWidget::POSTS_BEST_ALLTIME;

        switch($scope)
        {
            case 'alltime':
            default:
                $start = new \DateTimeImmutable('1970-01-01');
                $end = new \DateTimeImmutable('now');
                break;
        }

        $postsDal = new \RedisDao\PostDAL(Yii::app()->redis);
        $postIds = $postsDal->GetPostIdsByRating($start, $end);
        $totalPages = ceil(count($postIds) / $posts_per_page);

        if($page+1 > $totalPages)
            throw new \CHttpException(404);

        $postIds = array_slice($postIds, $page * $posts_per_page, $posts_per_page);

        $this->render('postsList' ,
           [
               'articles'     => Article::model()->orderByField('blog.id', $postIds)->findAllByPk($postIds),
               'paginationTotalPages' => $totalPages,
               'paginationCurrentPage' => $page+1
           ]
        );
    }

    public function actionChangeRating($postid)
    {
        if(Yii::app()->user->isGuest)
            throw new \CHttpException(401);

        $score = intval(Yii::app()->request->getPost('score', 0));

        if($score !== 1 && $score !== -1)
            throw new \CHttpException(403);

        $post = Article::model()->findByPk($postid);
        if(null === $post)
            throw new \CHttpException(404);

        $postsDal = new \RedisDao\PostDAL(Yii::app()->redis);
        echo $postsDal->IncrementPostRating($postid, $score, Yii::app()->user->id);
    }

    public function actionRedirectById($id)
    {
        $article = Article::model()->findByPk($id);
        if(null === $article)
            throw new \CHttpException(404);

        $this->redirect('/'.urlencode($article->url).'.htmx');
    }
} 