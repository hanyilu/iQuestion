<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name."--首页";
?>

<script type="text/javascript">
    $(document).ready(function () {
        var tab;
        var url = window.location.search;
        var i = url.indexOf("&");
        if (i == -1) {
            tab = "new"
        } else {
            var subUrl = url.substring(i + 1, url.length)
            tab = subUrl.split("=")[1];
        }
        if (tab.indexOf("H") != -1) {
            tab += ",#hot"
        }
        $("#" + tab).addClass("active")
    });
</script>


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
        <li id="new">
            <? echo CHtml::link('最新问题', array('site/index', 'tab' => 'new')); ?>
        </li>
        <li class="dropdown" id="hot">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">热门问题<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li id="dayHot">
                    <? echo CHtml::link('24小时最热', array('site/index', 'tab' => 'dayHot')); ?>
                </li>
                <li id="weekHot">
                    <? echo CHtml::link('7天最热', array('site/index', 'tab' => 'weekHot')); ?>
                </li>
                <li id="monthHot">
                    <? echo CHtml::link('30天最热', array('site/index', 'tab' => 'monthHot')); ?>
                </li>
            </ul>
        </li>
        <li id="unsolved">
            <? echo CHtml::link('未解决问题', array('site/index', 'tab' => 'unsolved')); ?>
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
                        <i class="icon-comments icon-2x"></i>
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
                    <div class="col-md-8 info-col">
                        <small><? echo '提问者：' . CHtml::link(CHtml::encode($question->user->username),
                                    array('user/info', 'uid' => $question->userId), array('class' => "username")) .
                                '&nbsp&nbsp&nbsp&nbsp' . '提问时间：' . $question->createTime; ?>
                        </small>
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