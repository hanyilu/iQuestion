<?php

class Tag extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{tag}}';
    }

    public function relations()
    {
        return array(
            'questions' => array(self::MANY_MANY, 'Question',
                'ique_que_tag(tagId, questionId)'),
        );
    }
}