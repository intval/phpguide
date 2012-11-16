<?php

/**
 * This is the model class for table "qna_subscriptions".
 *
 * The followings are the available columns in table 'qna_subscriptions':
 * @property string $userid
 * @property string $qid
 *
 * The followings are the available model relations:
 * @property QnaQuestion $qna
 * @property User $user
 */
class QnaSubscription extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return QnaSubscription the static model class
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
		return 'qna_subscriptions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, qid', 'required'),
			array('userid, qid', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('userid, qid', 'safe', 'on'=>'search'),
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
			'qna' => array(self::BELONGS_TO, 'QnaQuestion', 'qid'),
			'user' => array(self::BELONGS_TO, 'User', 'userid'),
		);
	}















    const ACTION_SUBSCRIBE = 1;
    const ACTION_UNSUBSCRIBE = 2;
    const NOTIFICATION_EMAIL_SUBJECT = "תגובה חדשה בשאלה %s";






    /**
     * @param int $userid userid to subscribe
     * @param int $questionid the qna id to subscribe to
     * @throws \InvalidArgumentException
     */
    public static function subscribe($userid, $questionid)
    {
        self::subscribeUser($userid, $questionid, self::ACTION_SUBSCRIBE);
    }



    /**
     * @param int $userid userid to unsubscribe
     * @param int $questionid the qna id to unsubscribe from
     * @throws \InvalidArgumentException
     */
    public static function unsubscribe($userid, $questionid)
    {
        self::subscribeUser($userid, $questionid, self::ACTION_UNSUBSCRIBE);
    }


    private static function subscribeUser($userid, $questionid, $action)
    {
        $uid = intval($userid);
        $qid = intval($questionid);

        if(0 === $qid || 0 === $uid)
            throw new \InvalidArgumentException("Neither authorid nor question id
            can be zero or non int. Author: ". $userid. ", Qid: ". $questionid);


        $pk = ['qid' => $qid, 'userid' => $uid];
        $existingSubscription = QnaSubscription::model()->findByPk($pk);

        if($action === self::ACTION_UNSUBSCRIBE || null !== $existingSubscription)
        {
            QnaSubscription::model()->deleteByPk($pk);
        }
        elseif($action === self::ACTION_SUBSCRIBE && null === $existingSubscription)
        {
            $subs = new QnaSubscription();
            $subs->qid = $qid;
            $subs->userid = $uid;
            $subs->save();
        }
    }


    /**
     * @param $userid
     * @param $questionid
     * @return bool
     * @throws \InvalidArgumentException
     */
    public static function isSubscribed($userid, $questionid)
    {
        $uid = intval($userid);
        $qid = intval($questionid);

        if(0 === $qid || 0 === $uid)
            throw new \InvalidArgumentException("Neither authorid nor question id
            can be zero or non int. Author: ". $userid. ", Qid: ". $questionid);


        $pk = ['qid' => $qid, 'userid' => $uid];
        return null !== QnaSubscription::model()->findByPk($pk);
    }


    /**
     * @param QnaQuestion $question notify subscribers about
     * @param array $excludeUsers
     */
    public static function notifySubscribers(QnaQuestion $question, array $excludeUsers = [])
    {
        $UsersToNotifyCriteria = new CDbCriteria([
            'with'=> 'user',
            'select' => 'userid, email as m',
            'condition' => 'qid = :qid',
            'params' => ['qid' => $question->qid]
        ]);

        $UsersToNotifyCriteria->addNotInCondition('userid', $excludeUsers);
        $usersToNotify = QnaSubscription::model()->findAll($UsersToNotifyCriteria);


        $subject = sprintf(self::NOTIFICATION_EMAIL_SUBJECT, $question->subject);

        foreach($usersToNotify as $user)
        {
            /** @var User $user->user  */
            $content = self::getThreadNotificationContent($question, $user->user);
            $user->user->sendEmail($subject, $content);
        }

    }



    private static function getThreadNotificationContent(QnaQuestion $question,
        User $receiver)
    {
        $criteria = new CDbCriteria([
            'condition' => 'qid='.$question->qid,
            'limit' => 1,
            'order' => 'time DESC',
        ]);

        /** @var QnaComment $lastAnswer  */
        $lastAnswer = QnaComment::model()->find($criteria);

        $data = [
            'subject' => $question->subject,
            'qid'   => $question->qid,
            'answerText' => $lastAnswer->bb_text,
            'author' => $lastAnswer->author->login,
            'url' => $question->getUrl(),
            'curUserId' => $receiver->id,
            'curUserHash' => self::getUserIdHash($receiver->id)
        ];

        return Yii::app()->controller->
                renderPartial('//emails/qna_subscription', $data, true, false);
    }


    private static function getUserIdHash($id)
    {
        return crypt('abcdefghij'.$id, '$2y$07$U9C8sBjqp8I90dH6hi87Qe$');
    }



    public static function unsubscribeAll($userid, $hash)
    {
        $userid = intval($userid);

        if(empty($hash) || 0 === $userid)
            throw new \InvalidArgumentException("userid or hash could not be empty");

        $expectedHash = self::getUserIdHash($userid);

        if($hash !== $expectedHash)
            return false;

        QnaSubscription::model()->deleteAll('userid = :uid', ['uid' => $userid]);
        return true;
    }




}