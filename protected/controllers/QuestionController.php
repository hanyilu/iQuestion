<?php
class QuestionController extends Controller
{

    public function actionPublish()
    {
        if (Yii::app()->user->isGuest)
            Yii::app()->user->loginRequired();
        else {
            $user = User::model()->findByPk(Yii::app()->user->id);
            if (!$user->canPublish()) {
                Yii::app()->user->setFlash('publish-fail', '当前等级' . $user->getLevel() . '，每日能提' . $user->getLevel() . '个问题。<br>今日已达上限。');
                $this->redirect(Yii::app()->request->urlReferrer);
            }
            $model = new Question();
            if (isset($_POST['Question'])) {
                $model->attributes = $_POST['Question'];
                if ($model->validate() && $model->publish()) {
                    $criteria = new CDbCriteria;
                    $criteria->addCondition("userId=" . Yii::app()->user->id);
                    $criteria->order = "createTime DESC";
                    $question = Question::model()->find($criteria);
                    $this->redirect(array('view', 'qid' => $question->id));
                }
            }
            $this->render('publish', array('model' => $model));
        }
    }

    public function actionView($qid)
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->urlReferrer);
        if (Yii::app()->user->isGuest)
            Yii::app()->user->loginRequired();
        else {
            $questionInfo = Question::model()->with('answers', 'user', 'tags')->findByPk($qid, array('order' => 'answers.likeCount DESC, answers.time ASC',));
            $bestAns = Answer::model()->findByPk($questionInfo->bestAnsId);
            $criteria = new CDbCriteria;
            $criteria->addCondition("userId=" . Yii::app()->user->id);
            $criteria->addCondition("questionId=" . $qid);
            if (LikeQue::model()->find($criteria) != NULL) {
                $ifLike = 1;
            } else {
                $ifLike = 0;
            }
            $myLike = LikeAns::model()->findAll('userId=:uid', array(':uid' => Yii::app()->user->id));
            $answerModel = new Answer();
            $data = array(
                'question' => $questionInfo,
                'bestAns' => $bestAns,
                'answerModel' => $answerModel,
                'ifLike' => $ifLike,
                'myLike' => $myLike,
            );
            if (isset($_POST['Answer'])) {
                $success = '回答成功~';
                $answerModel->attributes = $_POST['Answer'];
                $answerModel->questionId = $qid;
                $answerModel->userId = Yii::app()->user->id;
                $answerModel->time = date("Y-m-d H:i:s");
                $questionInfo->answerCount++;
                $answerModel->save();
                $questionInfo->save();

                if ($questionInfo->userId != Yii::app()->user->id) {
                    $userInfo = User::model()->findByPk(Yii::app()->user->id);
                    $userInfo->score += 2;
                    $userInfo->lv = $userInfo->getLevel();
                    $userInfo->save();
                    $success = $success . '积分+2~';
                }
                Yii::app()->user->setFlash('success', $success);
                $this->redirect(array('view', 'qid' => $qid));

            }
            $this->render('view', $data);
        }
    }

    public function actionLike($type, $id)
    {
        if (Yii::app()->user->isGuest)
            Yii::app()->user->loginRequired();
        else {

            if ($type == 'question') {
                $info = Question::model()->findByPk($id);
                $like = new LikeQue;
                $like->questionId = $id;
            } else if ($type == 'answer') {
                $info = Answer::model()->findByPk($id);
                $like = new LikeAns;
                $like->answerId = $id;
            }
            $info->likeCount++;
            $info->save();

            $like->userId = Yii::app()->user->id;
            $like->time = date("Y-m-d H:i:s");
            $like->save();
        }
    }

    public function actionDislike($type, $id)
    {
        if ($type == 'question') {
            $info = Question::model()->findByPk($id);
            $like = LikeQue::model()->findAll('userId=:uid', array(':uid' => Yii::app()->user->id));
            foreach ($like as $key => $l) {
                if ($id == $l->questionId) {
                    $l->delete();
                }
            }
        } else if ($type == 'answer') {
            $info = Answer::model()->findByPk($id);
            $like = LikeAns::model()->findAll('userId=:uid', array(':uid' => Yii::app()->user->id));
            foreach ($like as $key => $l) {
                if ($id == $l->answerId) {
                    $l->delete();
                }
            }
        }
        $info->likeCount--;
        $info->save();
    }

    public function actionEditQuestion($qid)
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->url);
        $questionInfo = Question::model()->findByPk($qid);
        $tags = $questionInfo->tags;
        if (isset($_POST['Question'])) {
            if ($questionInfo->edit()) {
                $this->redirect(array('view', 'qid' => $qid));
            }
        }
        $this->render('editQuestion', array('questionInfo' => $questionInfo, 'tags' => $tags));
    }

    public function actionDelQuestion($qid)
    {
        $question = Question::model()->with('tags')->findByPk($qid);
        foreach ($question->tags as $key => $tag) {
            $tag->frequency--;
            $tag->save();
        }
        Question::model()->deleteByPk($qid);
        QueTag::model()->deleteAll("questionId=:qid", array(':qid' => $qid));
        $answers = Answer::model()->findAll("questionId=:qid", array(':qid' => $qid));
        foreach ($answers as $key => $ans) {
            LikeAns::model()->deleteAll("answerId=:aid", array(':aid' => $ans->id));
            $ans->delete();
        }
        LikeQue::model()->deleteAll("questionId=:qid", array(':qid' => $qid));
        $userInfo = User::model()->findByPk(Yii::app()->user->id);
        $userInfo->score -= 5;
        $userInfo->lv = $userInfo->getLevel();
        if ($userInfo->save()) {
            Yii::app()->user->setFlash('success', '问题删除成功~积分-5~');
        }
        $this->redirect(Yii::app()->user->getReturnUrl());
    }

    public function actionEditAnswer($aid)
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->url);
        $answer = Answer::model()->with('question')->findByPk($aid);
        if (isset($_POST['Answer'])) {
            $answer->attributes = $_POST['Answer'];
            if ($answer->save()) {
                Yii::app()->user->setFlash('success', '回答修改成功~');
                $this->redirect(array('view', 'qid' => $answer->questionId));
            }
        }
        $this->render('editAnswer', array('answer' => $answer));
    }

    public function actionDelAnswer($aid, $qid)
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->urlReferrer);
        Answer::model()->deleteByPk($aid);
        LikeAns::model()->deleteAll("answerId=:aid", array(':aid' => $aid));
        $question = Question::model()->findByPk($qid);
        $question->answerCount--;
        $question->save();
        Yii::app()->user->setFlash('success', '回答删除成功~');
        $this->redirect(array('view', 'qid' => $qid));
    }

    public function actionSetBest($aid, $qid)
    {
        $question = Question::model()->findByPk($qid);
        $question->bestAnsId = $aid;

        $answer = Answer::model()->findByPk($aid);
        $user = User::model()->findByPk($answer->userId);
        $user->credit += $question->credit;
        $user->score += 10;
        if ($question->save() && $user->save()) {
            Yii::app()->user->setFlash('success', '回答采纳成功~');
            $this->redirect(array('view', 'qid' => $qid,));
        }
    }

    public function actionAll()
    {
        Yii::app()->user->setReturnUrl(Yii::app()->request->url);
        $viewModel = Question::model()->with('user', 'tags')->findAll();
        $myLike = LikeQue::model()->findAll('userId=:uid', array(':uid' => Yii::app()->user->id));
        $this->render('all', array('viewModel' => $viewModel, 'myLike' => $myLike));
    }
}









