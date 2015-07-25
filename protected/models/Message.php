<?php

class Message extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{message}}';
    }

    public function relations()
    {
        return array(
            'owner' => array(self::BELONGS_TO, 'User', 'userId'),
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
            'content' => '我要留言',
        );
    }
}