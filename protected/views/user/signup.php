<?php
/* @var $this SiteController */
/* @var $model SignupForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . '--注册';
?>

<div class="form-horizontal">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => "signup-form",
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
        <div class="col-md-3 text-right">
            <?php echo $form->labelEx($model, 'password1', array('class' => "control-label",)); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->passwordField($model, 'password1', array('class' => "form-control",)); ?>
        </div>
        <div class="col-md-3" style="margin-top: 10px;">
            <?php echo $form->error($model, 'password1'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-3 text-right">
            <?php echo $form->labelEx($model, 'icon', array('class' => "control-label",)); ?>
        </div>
        <div class="col-md-8">
            <div class="row">
                <?php for($i=0;$i<16;$i++){ ?>
                    <div class="col-md-3" style="margin-bottom: 7px">
                        <label>
                            <div class="icon icon_select <? echo 'icon_'.$i; ?>" id="<? echo 'icon'.$i; ?>">
                                <input type="radio" name="icon" value="<? echo $i; ?>" hidden="hidden" />
                            </div>
                        </label>
                    </div>
                <? }?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class=" col-md-6 col-md-offset-3">
            <?php echo CHtml::submitButton('注册并登录', array('class' => "btn btn-info")); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>

<script>
    $(document).ready(function () {
        $('input:radio:first').attr('checked', 'checked');
        $('#icon0').css("box-shadow", "0 0 30px red");
        $(".icon").click(function() {
            var i = $('input:radio:checked').val();
            $(".icon").css("box-shadow", "0 0 10px #888888");
            $("#icon"+i).css("box-shadow", "0 0 30px red");
        });
    });
</script>
