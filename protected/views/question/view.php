<?php
$this->pageTitle = $question->title;
?>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/assets/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript">
    window.UEDITOR_HOME_URL = "<?php echo Yii::app()->request->baseUrl ?>/assets/ueditor/";
    window.onload = function(){
        UE.getEditor('content');
    }
</script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/assets/ueditor/ueditor.config.js"></script>

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

<div class="row part-body" style="border: none">
    <div class="row">
        <div class="col-md-12">
            <h6><i class="icon-double-angle-right"></i><?php echo "&nbsp&nbsp" . $question->title; ?></h6>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <p><?php echo $question->content; ?></p>
        </div>
    </div>
    <div class="row tag-row">
        <div class="col-md-8">
            <? foreach ($question->tags as $key => $tag) {
                if ($tag->name != NULL) {
                    ?>
                    <a href="<? echo Yii::app()->createUrl('tag/view', array('tid' => $tag->id)) ?>">
                        <span class="label label-info"><i class="icon-tag"><? echo " " . $tag->name ?></i></span>
                    </a>
                <?
                }
            } ?>
        </div>
        <div class="col-md-4" style="text-align:right;">
            <small><? echo '悬赏分：' . $question->credit; ?></small>
            <? if ($bestAns == NULL) { ?>
                <small style="color:#F75C2F"><? echo '&nbsp&nbsp未解决'; ?></small>
            <? } else { ?>
                <small><? echo '&nbsp&nbsp已解决'; ?></small>
            <? } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 info-col">
            <small><? echo '提问者：' . CHtml::link(CHtml::encode($question->user->username),
                        array('user/info', 'uid' => $question->userId), array('class' => "username")) . '&nbsp&nbsp&nbsp&nbsp' . '提问时间：' . $question->createTime; ?>
            </small>
        </div>
        <div class="col-md-4" style="text-align:right;">
            <? if ($question->userId == Yii::app()->user->id && $bestAns == NULL) { ?>
                <a href="<? echo Yii::app()->createUrl('question/editQuestion', array('qid' => $question->id,)); ?>">
                    <i class="icon-edit"></i>
                </a>
                <? echo "&nbsp&nbsp"; ?>
                <a href="<? echo Yii::app()->createUrl('question/delQuestion', array('qid' => $question->id,)); ?>">
                    <i class="icon-trash"></i>
                </a>
            <? } ?>
            <? echo "&nbsp&nbsp&nbsp&nbsp"; ?>
            <span class="heart">
					<? if ($ifLike) { ?>
                        <i class="icon-heart" id="<? echo 'question' . $question->id ?>"
                           onclick="value('question',<? echo $question->id ?>, 1, 1)"></i>
                    <? } else { ?>
                        <i class="icon-heart-empty" id="<? echo 'question' . $question->id ?>"
                           onclick="value('question',<? echo $question->id ?>, 0, 1)"></i>
                    <? } ?>
                <span class="likeCount"
                      id="<? echo 'likequestionCount' . $question->id ?>"><? echo ' ' . $question->likeCount; ?></span>
			</span>
            <? echo "&nbsp&nbsp"; ?>
            <a href="#answer">
                <span class="answer">
				    <i class="icon-comments"></i><span><? echo ' ' . $question->answerCount; ?></span>
			    </span>
            </a>
        </div>
    </div>
</div>

<? if ($bestAns != NULL) { ?>
    <div class="row part-body">
        <div class="row">
            <div class="col-md-12">
                <h6><i class="icon-angle-right"></i>&nbsp;&nbsp;最佳答案</h6>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2" style="text-align: center">
                <div class="icon <? echo 'icon_'.$bestAns->user->icon;?>"></div>
                <small><? echo CHtml::link(CHtml::encode($bestAns->user->username),
                        array('user/info', 'uid' => $bestAns->userId)); ?>
                </small>
            </div>
            <div class="col-md-10" style="padding-left: 40px;">
                <?php echo $bestAns->content; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-2 info-col" style="padding-left: 40px;">
                <small><? echo '回答时间：' . $bestAns->time; ?></small>
            </div>
            <div class="col-md-4" style="text-align:right;">
                <span class="heart">
                    <? if (islike($myLike, $bestAns->id)) { ?>
                        <i class="icon-heart" id="<? echo 'answer' . $bestAns->id ?>"
                           onclick="value('answer',<? echo $bestAns->id ?>, 1, 1)"></i>
                    <? } else { ?>
                        <i class="icon-heart-empty" id="<? echo 'answer' . $bestAns->id ?>"
                           onclick="value('answer',<? echo $bestAns->id ?>, 0, 1)"></i>
                    <? } ?>
                    <span class="likeCount"
                          id="<? echo 'likeanswerCount' . $bestAns->id ?>"><? echo ' ' . $bestAns->likeCount; ?></span>
                </span>
            </div>
        </div>
    </div>
<? } ?>

<? $count = $bestAns == NULL ? count($question->answers) : count($question->answers) - 1;
$str = $bestAns == NULL ? "全部回答" : "其他回答";
if ($count) { ?>
<div class="row part-body">
    <div class="row">
        <div class="col-md-12">
            <h6><i class="icon-angle-right"></i><? echo '&nbsp&nbsp' . $str; ?></h6>
            <hr>
        </div>
    </div>
    <?php foreach ($question->answers as $key => $answer) {
        if ($answer->id != $question->bestAnsId) {
            ?>
            <div class="row">
                <div class="col-md-2" style="text-align: center">
                    <div class="icon <? echo 'icon_'.$answer->user->icon;?>"></div>
                    <small><? echo CHtml::link(CHtml::encode($answer->user->username),
                                array('user/info', 'uid' => $answer->userId)); ?>
                    </small>
                </div>
                <div class="col-md-10" style="padding-left: 40px;">
                    <?php echo $answer->content; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-2 info-col" style="padding-left: 40px;">
                    <small><? echo '回答时间：' . $answer->time; ?></small>
                </div>
                <div class="col-md-4" style="text-align:right;">
                    <? if ($answer->userId == Yii::app()->user->id && $bestAns == NULL) { ?>
                        <a href="<? echo Yii::app()->createUrl('question/editAnswer', array('aid' => $answer->id,)); ?>">
                            <i class="icon-edit"></i>
                        </a>
                        <? echo "&nbsp&nbsp"; ?>
                        <a href="<? echo Yii::app()->createUrl('question/delAnswer', array('aid' => $answer->id, 'qid' => $answer->questionId)); ?>">
                            <i class="icon-trash"></i>
                        </a>
                        <? echo "&nbsp&nbsp"; ?>
                    <?
                    }
                    if ($question->userId == Yii::app()->user->id && $bestAns == NULL && $answer->userId != Yii::app()->user->id) {
                        ?>
                        <a href="<? echo Yii::app()->createUrl('question/setBest', array('aid' => $answer->id, 'qid' => $answer->questionId)); ?>">
                            <i class="icon-ok">采纳</i>
                        </a>
                        <? echo "&nbsp&nbsp"; ?>
                    <? } ?>
                    <span class="heart">
                        <? if (islike($myLike, $answer->id)) { ?>
                            <i class="icon-heart" id="<? echo 'answer' . $answer->id ?>"
                               onclick="value('answer',<? echo $answer->id ?>, 1, 1)"></i>
                        <? } else { ?>
                            <i class="icon-heart-empty" id="<? echo 'answer' . $answer->id ?>"
                               onclick="value('answer',<? echo $answer->id ?>, 0, 1)"></i>
                        <? } ?>
                        <span class="likeCount"
                              id="<? echo 'likeanswerCount' . $answer->id ?>"><? echo ' ' . $answer->likeCount; ?></span>
                    </span>
                </div>
            </div>
            <hr>
        <?
        }
    }?>
</div>
<? } ?>



<div class="row part-body" id="answer">
    <div class="form-horizontal">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        )); ?>
        <div class="form-group">
            <div class="col-md-12">
                <h6><i class="icon-angle-right"></i><? echo '&nbsp&nbsp我来回答'; ?></h6>
            </div>
            <div class="col-md-12">
<!--                    --><?php //$this->Widget('ext.ckeditor.CKkceditor', array(
//                        "model" => $answerModel, // Data-Model
//                        "attribute" => 'content', // Attribute in the Data-Model
//                        "height" => '200px',
//                        "width" => '100%',
//                        "config" => array(
//                            "config.toolbar" => 'Full',
//                            "config.toolbar_Full" => "[
//						                ['Source','-','Save','NewPage','Preview','-','Templates'],
//						                ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
//						                ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
//						                ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
//						                '/',
//						                ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
//						                ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
//						                ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
//						                ['BidiLtr', 'BidiRtl'],
//						                ['Link','Unlink','Anchor'],
//						                ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'],
//						                '/',
//						                ['Styles','Format','Font','FontSize'],
//						                ['TextColor','BGColor'],
//						                ['Maximize', 'ShowBlocks']
//					                ]",
//                        ),
//                        "filespath" => Yii::app()->basePath . '/../upload',
//                        "filesurl" => Yii::app()->baseUrl . '/upload',
//
//                    ));?>
                    <?php echo $form->textArea($answerModel,'content',array('id' => 'content',)); ?>
                </div>
        </div>
        <div class="form-group">
            <div class="col-md-2 col-md-offset-7">
                <?php echo $form->error($answerModel, 'content'); ?>
            </div>
            <div class="col-md-3">
                <?php echo CHtml::submitButton('回答', array('class' => "btn btn-info btn-block")); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

