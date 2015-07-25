<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . "--赞过的回答";
if ($uid == Yii::app()->user->id) {
    $t = "我";
} else {
    $t = "TA";
}
?>

<?php
function isLike($myLike, $aid)
{
    foreach ($myLike as $key => $like) {
        if ($like->answerId == $aid) {
            return true;
        }
    }
    return false;
}

?>

<div class="row" id="nav">
    <ul class="nav nav-pills">
        <li>
            <? echo CHtml::link($t . '的资料', array('user/info', 'uid' => $uid)); ?>
        </li>
        <li>
            <? echo CHtml::link($t . '的问题', array('user/ownerQue', 'uid' => $uid)); ?>
        </li>
        <li>
            <? echo CHtml::link($t . '的回答', array('user/ownerAns', 'uid' => $uid)); ?>
        </li>
        <li class="dropdown active">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><? echo $t . "赞过的" ?><span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <? echo CHtml::link('问题', array('user/likeQue', 'uid' => $uid)); ?>
                </li>
                <li class="active">
                    <? echo CHtml::link('回答', array('user/likeAns', 'uid' => $uid)); ?>
                </li>
            </ul>
        </li>
        <li>
            <? echo CHtml::link($t . '的留言板', array('user/message', 'uid' => $uid)); ?>
        </li>
    </ul>
</div>

<div class="row part-body">
    <?php foreach ($viewModel as $key => $likeAns) {
        $answer = $likeAns->answer;?>
        <div class="row">
            <div class="col-md-2 heart">
                <? if (isLike($myLike, $answer->id)) { ?>
                    <i class="icon-heart icon-2x" id="<? echo 'answer' . $answer->id ?>"
                       onclick="value('answer',<? echo $answer->id ?>, 1, 0)"></i>
                <? } else { ?>
                    <i class="icon-heart-empty icon-2x" id="<? echo 'answer' . $answer->id ?>"
                       onclick="value('answer',<? echo $answer->id ?>, 0,0)"></i>
                <? } ?>
                <span>×</span>
                <span class="likeCount"
                      id="<? echo 'likeanswerCount' . $answer->id ?>"><? echo $answer->likeCount; ?></span>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12">
                        <a class="quetitle"
                           href="<?php echo Yii::app()->createUrl('question/view', array('qid' => $answer->question->id)); ?>">
                            <i class="icon-double-angle-right"></i><? echo '&nbsp' . $answer->question->title; ?>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div style="max-height: 88px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            <i class="icon-angle-right"></i>
                            <? echo $answer->content; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="text-align:right;">
                        <? if ($answer->id == $answer->question->bestAnsId) { ?>
                            <small style="color:#F75C2F">已被采纳</small>
                        <? } else { ?>
                            <small>未被采纳</small>
                        <? } ?>
                        <small><? echo '&nbsp&nbsp回答者：' . CHtml::link(CHtml::encode($answer->user->username),
                                    array('user/info', 'uid' => $answer->userId)) . '&nbsp&nbsp&nbsp&nbsp' . '收藏时间：' . $likeAns->time; ?></small>
                    </div>
                </div>
            </div>
        </div>

        <hr>
    <?php } ?>
</div>


<script>
    $(function () {
        $('.dropdown-toggle').dropdown();
    })
</script>