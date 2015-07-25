<?php

class LikeAns extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{like_answer}}';
    }

    public function relations()
    {
        return array(
            'answer' => array(self::BELONGS_TO, 'Answer', 'answerId'),
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
        );
    }
}