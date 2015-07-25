<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . "--问题";
if ($uid == Yii::app()->user->id) {
    $t = "我";
} else {
    $t = "TA";
}
?>

<?php
function isLike($myLike, $qid)
{
    foreach ($myLike as $key => $like) {
        if ($like->questionId == $qid) {
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
        <li class="active">
            <? echo CHtml::link($t . '的问题', array('user/ownerQue', 'uid' => $uid)); ?>
        </li>
        <li>
            <? echo CHtml::link($t . '的回答', array('user/ownerAns', 'uid' => $uid)); ?>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><? echo $t . "赞过的" ?><span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <? echo CHtml::link('问题', array('user/likeQue', 'uid' => $uid)); ?>
                </li>
                <li>
                    <? echo CHtml::link('回答', array('user/likeAns', 'uid' => $uid)); ?>
                </li>
            </ul>
        </li>
        <li>
            <? echo CHtml::link($t . '的留言板', array('user/message', 'uid' => $uid)); ?>
        </li>
    </ul>
</div>

<div class="row">
    <?php if (Yii::app()->user->hasFlash('success')) { ?>
        <div class="alert alert-success alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <small style="font-size:0.5em;"><? echo Yii::app()->user->getFlash('success'); ?></small>
        </div>
    <? } ?>
</div>

<div class="row  part-body">
    <? foreach ($viewModel as $key => $question) { ?>
        <div class="row">
            <div class="col-md-1 heart">
                <div class="row">
                    <? if (isLike($myLike, $question->id)) { ?>
                        <i class="icon-heart icon-2x" id="<? echo 'question' . $question->id ?>"
                           onclick="value('question',<? echo $question->id ?>, 1, 0)"></i>
                    <? } else { ?>
                        <i class="icon-heart-empty icon-2x" id="<? echo 'question' . $question->id ?>"
                           onclick="value('question',<? echo $question->id ?>, 0,0)"></i>
                    <? } ?>
                </div>
                <div class="row">
                    <span class="likeCount"
                          id="<? echo 'likequestionCount' . $question->id ?>"><? echo $question->likeCount; ?></span>
                </div>
            </div>
            <div class="col-md-1 answer">
                <div class="row">
                    <a href="<? echo '?r=question/view&qid='.$question->id.'#answer';?>">
                        <span class="answer"><i class="icon-comments icon-2x"></i></span>
                    </a>
                </div>
                <div class="row">
                    <span class="creditCount"><? echo $question->answerCount; ?></span>
                </div>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12">
                        <a class="quetitle"
                           href="<?php echo Yii::app()->createUrl('question/view', array('qid' => $question->id)); ?>">
                            <i class="icon-double-angle-right"></i><? echo '&nbsp' . $question->title; ?>
                        </a>
                    </div>
                </div>
                <div class="row tag-row">
                    <div class="col-md-12">
                        <? foreach ($question->tags as $key => $tag) {
                            if ($tag->name != NULL) {
                                ?>
                                <a href="<? echo Yii::app()->createUrl('tag/view', array('tid' => $tag->id)) ?>">
                                    <span class="label label-info"><i
                                            class="icon-tag"><? echo " " . $tag->name ?></i></span>
                                </a>
                            <?
                            }
                        }?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 info-col">
                        <small><? echo '提问时间：' . $question->createTime .
                                '&nbsp&nbsp&nbsp&nbsp悬赏分：' . $question->credit . '&nbsp&nbsp'; ?>
                        </small>
                        <? if ($question->bestAnsId == 0) { ?>
                            <small style="color:#F75C2F"><? echo '&nbsp&nbsp未解决'; ?></small>
                        <? } else { ?>
                            <small><? echo '&nbsp&nbsp已解决'; ?></small>
                        <? } ?>
                    </div>
                    <div class="col-md-2 button-col">
                        <? if ($uid == Yii::app()->user->id) { ?>
                            <small><a
                                    href="<? echo Yii::app()->createUrl('question/editQuestion', array('qid' => $question->id,)); ?>">
                                    <i class="icon-edit icon-large"></i>
                                </a>
                                <? echo "&nbsp&nbsp&nbsp&nbsp"; ?>
                                <a href="<? echo Yii::app()->createUrl('question/delQuestion', array('qid' => $question->id,)); ?>">
                                    <i class="icon-trash icon-large"></i>
                                </a>
                            </small>
                        <? } ?>
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