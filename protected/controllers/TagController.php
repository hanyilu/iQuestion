<?php
class TagController extends Controller
{

    public function actionIndex()
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'frequency DESC';
        $criteria->limit = 100;
        $tags = Tag::model()->findAll($criteria);
        $this->render('index', array('tags' => $tags));
    }

    public function actionView($tid)
    {
        $criteria = new CDbCriteria();
        $criteria->with = 'questions';
        $criteria->addCondition('t.id=' . $tid);
        $tag = Tag::model()->find($criteria);
        $myLike = LikeQue::model()->findAll('userId=:uid', array(':uid' => Yii::app()->user->id));
        $this->render('view', array('tag' => $tag, 'myLike' => $myLike));
    }
}