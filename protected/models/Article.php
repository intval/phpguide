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
 * @property string $pub_date
 * @property string $keywords
 * @property string $description
 * @property integer $approved
 * @property integer $author_id
 */
class Article extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
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
			array('title, url, image, html_desc_paragraph, html_content, pub_date, keywords, description, author_id', 'required'),
			array('approved, author_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>150),
			array('url, image', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, url, image, html_desc_paragraph, html_content, pub_date, keywords, description, approved, author_id', 'safe', 'on'=>'search'),
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
                    'author'     => array(self::BELONGS_TO, 'User',     'author_id'),
                    'comments'   => array(self::HAS_MANY,   'Comment',  'blogid'),
                    'categories' => array(self::MANY_MANY,  'Category', 'blog_ost2cat(postid, catid)')
		);
	}


	
        
        
        
        
        
        
        
        
  
        
        
        
        
        
        public function defaultScope()
        {
            return array
            ( 
                'condition' =>  'approved=1' ,
                'order'     =>  'pub_date DESC',
                'with'      => array
                (
                    'author' => array
                    (
                        'select'   => array('full_name','member_name', 'avatar')
                    )
                )
            );
        }

        
        public function newest($count = 5)
        {
           $this->getDbCriteria()->mergeWith( array('limit' => $count) );
           return $this;
            
        }
  
        
        public function by_cat($name)
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
                'select'    => array('description', 'title', 'url'),
                'condition' => "MATCH(html_desc_paragraph, html_content) AGAINST(:url)",
                'params'    => array('url' => $url),
                'limit'     => 8
            ));
            
            return $this;
        }

        
}