<?php
$this->pageTitle = Yii::app()->name."编辑问题";

$tagString = '';
foreach ($tags as $key => $tag) {
    $tagString = $tagString . $tag->name . ",";
}
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
    <div class="form-horizontal">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => "publish-form",
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        )); ?>

        <div class="form-group">
            <?php echo $form->labelEx($questionInfo, 'title', array('class' => "col-md-2 control-label",)); ?>
            <div class="col-md-7">
                <?php echo $form->textField($questionInfo, 'title', array('class' => "form-control",)); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->error($questionInfo, 'title'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($questionInfo, 'tags', array('class' => "col-md-2 control-label",)); ?>
            <div class="col-md-7">
                <?php echo $form->textField($questionInfo, 'tags', array('class' => "tagsinput", 'data-role' => "tagsinput", 'value' => $tagString,)); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->error($questionInfo, 'tags'); ?>
            </div>
        </div>

        <div class="form-group">
                <?php echo $form->labelEx($questionInfo, 'content', array('class' => "col-md-2 control-label",)); ?>
                <div class="col-md-9">
                    <?php echo $form->textArea($questionInfo,'content',array('id' => 'content',)); ?>
                </div>
                <div class="col-md-2 col-md-offset-2">
                    <?php echo $form->error($questionInfo, 'content'); ?>
                </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($questionInfo, 'credit', array('class' => "col-md-2 control-label",)); ?>
            <div class="col-md-2">
                <?php echo $form->textField($questionInfo, 'credit', array('class' => "form-control")); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->error($questionInfo, 'credit'); ?>
            </div>
            <div class="col-md-3 col-md-offset-2">
                <?php echo CHtml::submitButton('提交', array('class' => "btn btn-info btn-block")); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script type="text/javascript">
    $('input.tagsinput').tagsinput();
</script>