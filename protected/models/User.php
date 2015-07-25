<?php

class User extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{user}}';
    }

    public function relations()
    {
        return array(
            'questions' => array(self::HAS_MANY, 'Question', 'userId'),
            'answers' => array(self::HAS_MANY, 'Answer', 'userId'),
            'like_ques' => array(self::HAS_MANY, 'LikeQue', 'userId'),
            'likes_anss' => array(self::HAS_MANY, 'LikeAns', 'userId'),
            'messages' => array(self::HAS_MANY, 'message', 'userId'),
            'messagesTo' => array(self::HAS_MANY, 'message', 'ownerId'),
        );
    }

    public function getLevel()
    {
        $level = 1;
        $sco = $this->score;
        while ($sco >= 8) {
            $level++;
            $sco /= 2;
        }
        return $level;
    }

    public function canPublish()
    {
        $level = $this->getLevel();
        if ($level >= 10)
            return true;
        $criteria = new CDbCriteria;
        $criteria->addCondition('userId=' . $this->id);
        $criteria->addCondition('TO_DAYS(createTime)=TO_DAYS(NOW())');
        $count = Question::model()->count($criteria);

        if ($count < $level) {
            return true;
        }
        return false;
    }
}