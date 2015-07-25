<?php
$this->pageTitle = Yii::app()->name."发布问题";
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/assets/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript">
    window.UEDITOR_HOME_URL = "<?php echo Yii::app()->request->baseUrl ?>/assets/ueditor/";
    window.onload = function(){
        UE.getEditor('content');
    }
</script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/assets/ueditor/ueditor.config.js"></script>

<div class="row  part-body" style="border: none">
    <div class="form-horizontal">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => "publish-form",
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        )); ?>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'title', array('class' => "col-md-2 control-label",)); ?>
            <div class="col-md-7">
                <?php echo $form->textField($model, 'title', array('class' => "form-control",)); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->error($model, 'title'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'tags', array('class' => "col-md-2 control-label",)); ?>
            <div class="col-md-7" id="tags-tooltip" data-toggle="tooltip" data-placement="right" title="输入完一个标签后，按回车以继续添加标签。">
                <?php echo $form->textField($model, 'tags', array('class' => "tagsinput", 'data-role' => "tagsinput", 'value' => "", )); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->error($model, 'tags'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'content', array('class' => "col-md-2 control-label",)); ?>
            <div class="col-md-9">
                <?php echo $form->textArea($model,'content',array('id' => 'content',)); ?>
            </div>
            <div class="col-md-2 col-md-offset-2">
                <?php echo $form->error($model, 'content'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'credit', array('class' => "col-md-2 control-label",)); ?>
            <div class="col-md-2">
                <?php echo $form->textField($model, 'credit', array('class' => "form-control")); ?>
            </div>
            <div class="col-md-3">
                <?php echo $form->error($model, 'credit'); ?>
            </div>
            <div class="col-md-3 col-md-offset-1">
                <?php echo CHtml::submitButton('提交', array('class' => "btn btn-info btn-block")); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script type="text/javascript">
    $('input.tagsinput').tagsinput();
</script>
