<?php

class LikeQue extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{like_question}}';
    }

    public function relations()
    {
        return array(
            'question' => array(self::BELONGS_TO, 'Question', 'questionId'),
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
        );
    }
}