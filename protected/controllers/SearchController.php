<?php
class SearchController extends Controller
{
    public function actionIndex()
    {
        $type = $_POST['type'];
        $input = $_POST['input'];
        $search = $input;
        if ($type == 0) {
            $result = array_merge($this->search($search));
            while(count($result) == 0){
                $mid = strlen($search)/2;
                $sub1 = substr($search, 0, $mid);
                $sub2 = substr($search, $mid);
                $result = array_merge($this->search($sub1),$this->search($sub2));
            }
            $myLike = LikeQue::model()->findAll('userId=:uid', array(':uid' => Yii::app()->user->id));
            $this->render('question',array('result' => $result,'input' => $input, 'myLike' => $myLike));
        }
        else{
            $in = str_split($input);
            $search = '%';
            foreach($in as $key=>$c){
                $search .= $c.'%';
            }
            $result = User::model()->with('questions','answers')->
                    findAll(array('condition'=>'username LIKE "'.$search.'"'));
            $this->render('user',array('result' => $result,'input' => $input));
        }
    }

    private function search($search){
        $criteria = new CDbCriteria();
        $criteria->addSearchCondition('content',$search);
        $questions = Question::model()->with('user','tags')->findAll($criteria);
        return $questions;
    }
}