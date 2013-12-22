<?php

/**
 * This is the model class for table "qna_questions".
 *
 * The followings are the available columns in table 'qna_questions':
 * @property string $qid
 * @property string $subject
 * @property string $bb_text
 * @property string $html_text
 * @property integer $authorid
 * @property SDateTime $time
 * @property SDateTime $last_activity
 * @property integer $views
 * @property integer $answers
 * @property integer $categoryid
 *
 * The followings are the available model relations:
 * @property User $author
 */
class QnaQuestion extends DTActiveRecord
{


    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return QnaQuestion the static model class
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
		return 'qna_questions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject', 'required'),
			array('subject', 'length', 'max'=>255, 'min'=>5),
            array('categoryid', 'numerical', 'integerOnly' => true, 'allowEmpty' => false),
            array('categoryid', 'validatorExistingCategory'),
			array('bb_text', 'length', 'min'=>5, 'allowEmpty' => false)
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
		    'author' => array(self::BELONGS_TO, 'User', 'authorid'),
		    'comments' =>  array(self::HAS_MANY, 'QnaComment', 'qid'),
            'category' => [self::BELONGS_TO, 'QnaCategory', 'categoryid']
		);
	}
    
    
    public function byPage($page = 0, $per_page = 15)
    {
        $this->getDbCriteria()->mergeWith( array('limit' => $per_page, 'offset' => $page * $per_page) );
        return $this;
    }

    public function inCategory($id)
    {
        $this->getDbCriteria()->mergeWith(['condition' => 'categoryid = :catid', 'params' => [':catid' => $id]]);
        return $this;
    }

    public function defaultScope()
    {
        return array
        (
            'condition' =>  'status!="hidden"' ,
            'order'     =>  'last_activity DESC',
            'with'      => array
            (
                'author' => array
                (
                    'select'   => array('real_name','login', 'email')
                )
            )
        );
    }


    public function categoriesWithLastPost()
    {
        $where = Yii::app()->db->createCommand()
            ->select('max(qid)')
            ->from(QnaQuestion::model()->tableName(). ' subquery')
            ->where('t.categoryid = subquery.categoryid');

        $this->with('category');
        $this->getDbCriteria()->mergeWith([
            'condition' => 'qid = ('.$where->getText().')',
            'order' => 'categoryid ASC'
        ]);
        return $this;
    }

   public function getUrl()
   {
   		$url = str_pad( preg_replace("/[^a-z0-9_\s".'א-ת'."]/ui", '', $this->subject), '2', 'x');
   		return Yii::app()->createUrl('/forum/qna/view', array('id' => $this->qid, 'subj' => $url));
   }



    public function validatorExistingCategory($attribute, $params)
    {
        $allCategories = QnaCategory::model()->findAll();

        /** @var $category QnaCategory */
        foreach($allCategories as $category)
            if($this->$attribute === $category->catid)
                return true;

        $this->addError($attribute, 'Invalid category id ;/');
    }

}