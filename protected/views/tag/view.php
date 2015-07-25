<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name."--".$tag->name;
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

<div class="row part-body">
<div class="row">
    <h3>
        <i class="icon-tags"><? echo "&nbsp&nbsp" . $tag->name; ?></i>
    </h3>
    <hr>
</div>

<div class="row">
    <? foreach ($tag->questions as $key => $question) { ?>
        <div class="row">
            <div class="col-md-1 heart">
                <? if (isLike($myLike, $question->id)) { ?>
                    <i class="icon-heart icon-2x" id="<? echo 'question' . $question->id ?>"
                       onclick="value('question',<? echo $question->id ?>, 1, 0)"></i>
                <? } else { ?>
                    <i class="icon-heart-empty icon-2x" id="<? echo 'question' . $question->id ?>"
                       onclick="value('question',<? echo $question->id ?>, 0,0)"></i>
                <? } ?>
                <span class="likeCount"
                      id="<? echo 'likequestionCount' . $question->id ?>"><? echo $question->likeCount; ?></span>
            </div>
            <div class="col-md-1 answer">
                <i class="icon-comments icon-2x"></i>
                <span class="creditCount"><? echo $question->answerCount; ?></span>
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
                <div class="row">
                    <div class="col-md-8">
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
                    <div class="col-md-4" style="text-align:right;">
                        <small><? echo '悬赏分：' . $question->credit . '&nbsp&nbsp'; ?></small>
                        <? if ($question->bestAnsId == 0) { ?>
                            <small style="color:#F75C2F"><? echo '&nbsp&nbsp未解决'; ?></small>
                        <? } else { ?>
                            <small><? echo '&nbsp&nbsp已解决'; ?></small>
                        <? } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align:right;">
                        <small><? echo '提问者：' . CHtml::link(CHtml::encode($question->user->username),
                                    array('user/info', 'uid' => $question->userId), array('class' => "username")) . '&nbsp&nbsp&nbsp&nbsp' . '提问时间：' . $question->createTime; ?></small>
                    </div>
                </div>
            </div>
        </div>

        <hr>
    <?php } ?>
</div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/value.js"></script>
<script>
    $(function () {
        $('.dropdown-toggle').dropdown();
    })
</script>