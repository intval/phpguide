<?php

/**
 * This is the model class for table "blog".
 *
 * The followings are the available columns in table 'blog':
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $html_content
 * @property string $pub_date
 * @property integer $approved
 * @property integer $author_id
 */
class Article extends DTActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
     * @param $className string of which model to create
	 * @return Article the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'blog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, html_content', 'required'),
			array('title', 'length', 'max'=>150),
			array('content', 'length', 'min'=>20)
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'author'        => array(self::BELONGS_TO, 'User',     'author_id'),
                    'comments'      => array(self::HAS_MANY,   'Comment',  'blogid'),
                    'categories'    => array(self::MANY_MANY,  'Category', 'blog_post2cat(postid, catid)'),
                    'commentsCount' => array(self::STAT,        'Comment',  'blogid')
		);
	}


        /** Provides a way to save the model with corresponding relationships
         * http://www.yiiframework.com/extension/esaverelatedbehavior */
        public function behaviors()
        {
            return array
            (
                'ESaveRelatedBehavior' => array('class' => 'application.components.ESaveRelatedBehavior')
            );
        }
        
        

        public function defaultScope()
        {
            $condition = 'blog.approved=1';
            
            // allow poster to see his post
            $userid = Yii::app()->user->id;
            (Yii::app()->user->isguest || null === $userid) ?: $condition .= " OR author_id = $userid";
            
            // admins can see anything
            if(!Yii::app()->user->isguest && Yii::app()->user->is_admin) $condition = '';
            
            return
            [
                'condition' =>  $condition  ,
                'order'     =>  'pub_date DESC',
            	'alias'		=> 'blog',
                'with'      =>
                [
                    'author' =>
                    [
                        'select'   => ['login','email']
                    ]
                ]
            ];
        }
        
        

        
        public function byPage($page = 0, $per_page = 8)
        {
            $condition = ['limit' => $per_page, 'offset' => $page * $per_page];
            $this->getDbCriteria()->mergeWith($condition);
            return $this;
        }
  
        
        public function byCat($name)
        {
            $this->getDbCriteria()->mergeWith
            (
                [
                    'condition' => "`id` IN
                        (
                            SELECT `postid` FROM `blog_post2cat`
                            WHERE `catid` = (SELECT `cat_id` FROM `blog_categories` WHERE `name` = :name)
                        )",

                    'params' => ['name' => $name]
                ]
            );
            
            return $this;
        }

}