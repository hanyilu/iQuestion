<?php

class Question extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{question}}';
    }

    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
            'tags' => array(self::MANY_MANY, 'Tag',
                'ique_que_tag(questionId, tagId)'),
            'answers' => array(self::HAS_MANY, 'Answer', 'questionId'),
            'likes' => array(self::HAS_MANY, 'LikeQue', 'questionId'),
        );
    }

    public function rules()
    {
        return array(
            array('title', 'required', 'message' => '标题不能为空'),
            array('content', 'required', 'message' => '内容不能为空'),
            array('credit', 'numerical', 'integerOnly' => true, 'message' => '悬赏分必须是整数'),
            array('credit', 'check_credit'),

        );
    }

    public function attributeLabels()
    {
        return array(
            'title' => '标题',
            'tags' => '标签',
            'content' => '具体内容',
            'credit' => '悬赏分',
        );
    }

    public function check_credit()
    {
        $userInfo = User::model()->findByPk(Yii::app()->user->id);
        if ($this->credit < 0) {
            $this->addError('credit', '您的悬赏分不能为负');
        } else if ($userInfo->credit < $this->credit) {
            $this->addError('credit', '您的积分不够');
        }
    }

    public function publish()
    {
        $this->userId = Yii::app()->user->id;
        $this->createTime = date("Y-m-d H:i:s");
        if (!$this->save())
            return false;

        $userInfo = User::model()->findByPk(Yii::app()->user->id);
        $userInfo->credit -= $this->credit;
        $userInfo->score += 5;
        $userInfo->lv = $userInfo->getLevel();
        if (!$userInfo->save())
            return false;
        $_tagArray = explode(',', $_POST['Question']['tags']);
        $tagModel = Tag::model();
        foreach ($_tagArray as $key => $name) {
            $tag = $tagModel->find('name=:n', array(':n' => $name));
            if ($tag == NULL) {
                $tag = new Tag;
                $tag->name = $name;
            } else {
                $tag->frequency++;
            }
            if (!$tag->save())
                return false;
            $queTag = new QueTag;
            $queTag->questionId = $this->id;
            $queTag->tagId = $tag->id;
            if (!$queTag->save())
                return false;
        }

        Yii::app()->user->setFlash('success', '提问成功！经验值+5，积分-' . $this->credit . '~');
        return true;
    }

    public function edit()
    {
        $userInfo = User::model()->findByPk(Yii::app()->user->id);
        $userInfo->credit += $this->credit;

        $this->attributes = $_POST['Question'];
        $this->updateTime = date("Y-m-d H:i:s");
        if (!$this->validate() || !$this->save()) {
            return false;
        }

        $userInfo->credit -= $this->credit;
        if (!$userInfo->save())
            return false;
        $_old = QueTag::model()->findAll('questionId=:qid', array(':qid' => $this->id));
        $_oldTags = array();
        foreach ($_old as $key => $quetag) {
            $_oldTags[] = Tag::model()->findByPk($quetag->tagId)->name;
        }
        $_tagArray = explode(',', $_POST['Question']['tags']);
        $_delTags = array_diff($_oldTags, $_tagArray);
        $_newTags = array_diff($_tagArray, $_oldTags);
        $tagModel = Tag::model();
        foreach ($_newTags as $key => $name) {
            $tag = $tagModel->find('name=:n', array(':n' => $name));
            if ($tag == NULL) {
                $tag = new Tag;
                $tag->name = $name;
            } else {
                $tag->frequency++;
            }
            if (!$tag->save())
                return false;
            $queTag = new QueTag;
            $queTag->questionId = $this->id;
            $queTag->tagId = $tag->id;
            if (!$queTag->save())
                return false;
        }
        foreach ($_delTags as $key => $name) {
            $tag = Tag::model()->find('name=:name', array(':name' => $name));
            $tag->frequency--;
            if (!$tag->save())
                return false;
            $queTag = QueTag::model()->find('questionId=:qid and tagId=:tid', array(':qid' => $this->id, ':tid' => $tag->id));
            if (!$queTag->delete())
                return false;
        }
        Yii::app()->user->setFlash('success', '问题修改成功~');
        return true;
    }
}