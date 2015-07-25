<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . '--登录';
?>
<div class="form-horizontal">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => "login-form",
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    )); ?>

    <div class="form-group">
        <div class="col-md-3 text-right">
            <?php echo $form->labelEx($model, 'username', array('class' => "control-label",)); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->textField($model, 'username', array('class' => "form-control",)); ?>
        </div>
        <div class="col-md-3" style="margin-top: 10px;">
            <?php echo $form->error($model, 'username'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-3 text-right">
            <?php echo $form->labelEx($model, 'password', array('class' => "control-label",)); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->passwordField($model, 'password', array('class' => "form-control",)); ?>
        </div>
        <div class="col-md-3" style="margin-top: 10px;">
            <?php echo $form->error($model, 'password'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <?php echo $form->checkBox($model, 'rememberMe'); ?>
            <?php echo $form->label($model, 'rememberMe'); ?>
            <?php echo $form->error($model, 'rememberMe'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class=" col-md-6 col-md-offset-3">
            <?php echo CHtml::submitButton('登录', array('class' => "btn btn-info form-btn")); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div>

