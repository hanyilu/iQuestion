<?php

class Answer extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{answer}}';
    }

    public function relations()
    {
        return array(
            'question' => array(self::BELONGS_TO, 'Question', 'questionId'),
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
            'likes' => array(self::HAS_MANY, 'LikeAns', 'answerId'),
        );
    }

    public function rules()
    {
        return array(
            array('content', 'required', 'message' => '内容不能为空'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'content' => '我来回答',
        );
    }
}