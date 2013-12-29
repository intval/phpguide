<?php

class m131228_213818_postsrating_redis extends CDbMigration
{
	public function up()
	{
        /** @var \RedisConnection $redis */
        $redis = Yii::app()->redis;
        $dal = new \RedisDao\PostDAL($redis);

        /** @var $post Article */
        foreach(Article::model()->resetScope()->findAll() as $post)
        {
            $dal->IncrementPostRating($post->id, 30);
            $dal->SetPostDate($post->id, $post->pub_date);
            $dal->IncrementPostViewsCount($post->id, 100);
        }

	}

	public function down()
	{
	}
}