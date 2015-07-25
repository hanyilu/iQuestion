<?php
$this->pageTitle = Yii::app()->name."编辑回答";
$question = $answer->question;
?>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/assets/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript">
    window.UEDITOR_HOME_URL = "<?php echo Yii::app()->request->baseUrl ?>/assets/ueditor/";
    window.onload = function(){
        UE.getEditor('content');
    }
</script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/assets/ueditor/ueditor.config.js"></script>

<div class="row  part-body">
    <div class="row">
        <div class="col-md-12">
            <h5><i class="icon-double-angle-right"></i><?php echo "&nbsp&nbsp" . $question->title; ?></h5>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo $question->content; ?>
        </div>
    </div>
    <div class="row tag-row">
        <div class="col-md-12">
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
        <div class="col-md-4">

        </div>
    </div>
    <div class="row">
        <div class="col-md-12 info-col">
            <small><? echo '提问者：' . CHtml::link(CHtml::encode($question->user->username),
                        array('user/info', 'uid' => $question->userId)) . '&nbsp&nbsp&nbsp&nbsp' . '提问时间：' . $question->createTime; ?>
            </small>
            <small><? echo '&nbsp&nbsp&nbsp&nbsp悬赏分：' . $question->credit; ?></small>
        </div>
    </div>

    <hr>
</div>


<div class="form-horizontal row  part-body">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    )); ?>
    <div class="form-group">



            <div class="col-md-12"><h6><i class="icon-angle-right"></i><? echo '&nbsp&nbsp我来回答'; ?></h6>
                <?php echo $form->textArea($answer,'content',array('id' => 'content',)); ?>
            </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 col-md-offset-7">
            <?php echo $form->error($answer, 'content'); ?>
        </div>
        <div class="col-md-3">
            <?php echo CHtml::submitButton('回答', array('class' => "btn btn-info btn-block")); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>