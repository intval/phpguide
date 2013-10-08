<?php

/**
 * This is the model class for table "blog".
 *
 * The followings are the available columns in table 'blog':
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $image
 * @property string $html_desc_paragraph
 * @property string $html_content
 * @property SDateTime $pub_date
 * @property string $keywords
 * @property string $description
 * @property integer $approved
 * @property integer $author_id
 * @property Category[] $categories
 */
class Article extends DTActiveRecord
{

    const APPROVED_PUBLISHED = 2;
    const APPROVED_SANDBOX = 1;
    const APPROVED_NONE = 0;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
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
			array('title, keywords, description', 'required'),
            array('image', 'url', 'allowEmpty' => true),
			array('title', 'length', 'max'=>150),
			array('url, image', 'length', 'max'=>255)
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array
        (
            'author'        => array(self::BELONGS_TO, 'User',     'author_id'),
            'comments'      => array(self::HAS_MANY,   'Comment',  'blogid'),
            'plain'         => array(self::HAS_ONE,    'ArticlePlainText', 'id'),
            'categories'    => array(self::MANY_MANY,  'Category', 'blog_post2cat(postid, catid)'),
            'commentsCount' => array(self::STAT,       'Comment',  'blogid')
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
            $condition = 'blog.approved != '.self::APPROVED_NONE;
            
            // allow poster to see his post
            $userid = Yii::app()->user->id;
            (Yii::app()->user->isguest || null === $userid) ?: $condition .= " OR author_id = $userid";
            
            // admins can see anything
            if(!Yii::app()->user->isguest && Yii::app()->user->is_admin)
                $condition = '';
            
            return array
            ( 
                'condition' => $condition  ,
                'order'     => 'pub_date DESC',
            	'alias'		=> 'blog',
                'with'      => array
                (
                    'author' => array
                    (
                        'select'   => array('real_name','login','email')
                    )
                )
            );
        }
        
        

        
        public function byPage($page = 0, $per_page = 8)
        {
            $this->getDbCriteria()->mergeWith( array('limit' => $per_page, 'offset' => $page * $per_page) );
            return $this;
        }

        public function publishedOnly()
        {
            if(Yii::app()->user->isguest || !Yii::app()->user->is_admin)
                $this->getDbCriteria()->mergeWith(['condition' => "blog.approved = ".self::APPROVED_PUBLISHED]);

            return $this;
        }
        
        public function byCat($name)
        {
            $this->getDbCriteria()->mergeWith
            (
                    array('condition' => "`id` IN
                        (
                            SELECT `postid` FROM `blog_post2cat` 
                            WHERE `catid` = (SELECT `cat_id` FROM `blog_categories` WHERE `name` = :name)
                        )",
                            'params' => array('name' => $name)
                        )
            );
            
            return $this;
        }
        
        
        public function similarTo($url)
        {
            
            $this->getDbCriteria()->mergeWith(array(
            	'alias' => 'blog',
                'select'    => array('description', 'title', 'url'),
                'condition' => "blog.id IN 
                    (
                    SELECT id FROM blog_plain WHERE 
                    MATCH(plain_content, plain_description) AGAINST(:url)
                    )
                    ",
                'params'    => array('url' => $url),
                'limit'     => 8
            ));
            
            return $this;
        }

    public static function getCacheDependencySql()
    {
        return 'SELECT pub_date FROM '.self::model()->tableName().
               ' ORDER BY pub_date DESC LIMIT 1';
    }
        
}