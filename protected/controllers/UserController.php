<?php
class UserController extends Controller
{

    public function actionIndex()
    {
        if (Yii::app()->user->isGuest) {
            Yii::app()->user->loginRequired();
        }
        $this->redirect(array('info', 'uid' => Yii::app()->user->id));
    }

    public function actionInfo($uid)
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->url);
        if (Yii::app()->user->isGuest) {
            Yii::app()->user->loginRequired();
        } else {
            $user = User::model()->find('id=:uid', array(':uid' => $uid));
            $queCount = Question::model()->count('userId=:uid', array(':uid' => $uid));
            $ansCount = Answer::model()->count('userId=:uid', array(':uid' => $uid));
            $likeQueCount = LikeQue::model()->count('userId=:uid', array(':uid' => $uid));
            $likeAnsCount = LikeAns::model()->count('userId=:uid', array(':uid' => $uid));
            $data = array(
                'user' => $user,
                'uid' => $uid,
                'queCount' => $queCount,
                'ansCount' => $ansCount,
                'likeQueCount' => $likeQueCount,
                'likeAnsCount' => $likeAnsCount,
            );
            $this->render('info', $data);
        }
    }

    public function actionOwnerQue($uid)
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->url);
        if (Yii::app()->user->isGuest) {
            Yii::app()->user->loginRequired();
        } else {
            $cri = new CDbCriteria();
            $cri->addCondition('userId=' . $uid);
            $cri->order = 'createTime DESC';
            $viewModel = Question::model()->findAll($cri);
            $myLike = LikeQue::model()->findAll('userId=:uid', array(':uid' => Yii::app()->user->id));
            $this->render('ownerQue', array('viewModel' => $viewModel, 'uid' => $uid, 'myLike' => $myLike));
        }
    }

    public function actionOwnerAns($uid)
    {
        if (Yii::app()->user->isGuest)
            Yii::app()->user->loginRequired();
        else {
            $cri = new CDbCriteria();
            $cri->with = array('question');
            $cri->addCondition('t.userId=' . $uid);
            $cri->order = 'time DESC';
            $viewModel = Answer::model()->findAll($cri);
            $myLike = LikeAns::model()->findAll('userId=:uid', array(':uid' => Yii::app()->user->id));
            $this->render('ownerAns', array('viewModel' => $viewModel, 'uid' => $uid, 'myLike' => $myLike));
        }
    }

    public function actionLikeQue($uid)
    {
        if (Yii::app()->user->isGuest)
            Yii::app()->user->loginRequired();
        else {
            $cri = new CDbCriteria();
            $cri->with = array('question.tags');
            $cri->addCondition('t.userId=' . $uid);
            $cri->order = 'time DESC';
            $viewModel = LikeQue::model()->findAll($cri);
            $myLike = LikeQue::model()->findAll('userId=:uid', array(':uid' => Yii::app()->user->id));
            $this->render('likeQue', array('viewModel' => $viewModel, 'uid' => $uid, 'myLike' => $myLike));
        }
    }

    public function actionLikeAns($uid)
    {
        if (Yii::app()->user->isGuest)
            Yii::app()->user->loginRequired();
        else {
            $cri = new CDbCriteria();
            $cri->with = array('answer.question', 'answer.user');
            $cri->addCondition('t.userId=' . $uid);
            $cri->order = 't.time DESC';
            $viewModel = LikeAns::model()->findAll($cri);
            $myLike = LikeAns::model()->findAll('userId=:uid', array(':uid' => Yii::app()->user->id));
            $this->render('LikeAns', array('viewModel' => $viewModel, 'uid' => $uid, 'myLike' => $myLike));
        }
    }

    public function actionMessage($uid)
    {
        if (Yii::app()->user->isGuest)
            Yii::app()->user->loginRequired();
        else {
            $cri = new CDbCriteria();
            $cri->with = array('user');
            $cri->addCondition('t.ownerId=' . $uid);
            $cri->order = 't.time DESC';
            $viewModel = Message::model()->findAll($cri);
            $msgModel = new Message;
            if (isset($_POST['Message'])) {
                $msgModel->attributes = $_POST['Message'];
                $msgModel->time = date("Y-m-d H:i:s");
                $msgModel->ownerId = $uid;
                $msgModel->userId = Yii::app()->user->id;
                if ($msgModel->save()) {
                    $this->redirect(array('user/message', 'uid' => $uid,));
                }
            }
            $this->render('message', array('viewModel' => $viewModel, 'msgModel' => $msgModel, 'uid' => $uid));
        }
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model = new LoginForm;
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end;
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    public function actionSignup()
    {
        $model = new SignupForm;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'signup-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end;
        }
        if (isset($_POST['SignupForm'])) {
            $model->attributes = $_POST['SignupForm'];
            if ($model->validate() && $model->signup()) {
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        $this->render('signup', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}