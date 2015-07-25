<?php
class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex($tab = 'new')
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->url);
        $cri = new CDbCriteria();
        switch ($tab) {
            case 'new':
                $cri->with = array('user', 'tags');
                $cri->order = 'createTime DESC';
                break;
            case 'dayHot':
                $cri->with = array('user', 'tags');
                $cri->addCondition('createTime>=NOW()-INTERVAL 1 day');
                $cri->order = 'answerCount+likeCount DESC';
                $cri->limit = 100;
                break;
            case 'weekHot':
                $cri->with = array('user', 'tags');
                $cri->addCondition('createTime>=NOW()-INTERVAL 7 day');
                $cri->order = 'answerCount+likeCount DESC';
                $cri->limit = 100;
                break;
            case 'monthHot':
                $cri->with = array('user', 'tags');
                $cri->addCondition('createTime>=NOW()-INTERVAL 30 day');
                $cri->order = 'answerCount+likeCount DESC';
                $cri->limit = 100;
                break;
            case 'unsolved':
                $cri->with = array('user', 'tags');
                $cri->addCondition('bestAnsId=0');
                $cri->order = 't.credit DESC';
                break;
            case 'all':
                $cri->with = array('user', 'tags');
                break;
        }
        $viewModel = Question::model()->findAll($cri);
        $myLike = LikeQue::model()->findAll('userId=:uid', array(':uid' => Yii::app()->user->id));
        $this->render('index', array('viewModel' => $viewModel, 'myLike' => $myLike));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
}