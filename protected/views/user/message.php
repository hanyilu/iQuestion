<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . "--留言板";

if ($uid == Yii::app()->user->id) {
    $t = "我";
} else {
    $t = "TA";
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
        <li class="active">
            <? echo CHtml::link($t . '的留言板', array('user/message', 'uid' => $uid)); ?>
        </li>
    </ul>
</div>

<?php $count = count($viewModel);?>
<div class="row part-body">
    <div class="row message">
        <a href="#msg">我要留言</a>
    </div>
    <? foreach ($viewModel as $key => $msg) { ?>
        <div class="row">
            <div class="col-md-2" style="text-align: center">
                <div class="icon <? echo 'icon_'.$msg->user->icon;?>"></div>
                <? echo CHtml::link(CHtml::encode($msg->user->username),
                    array('user/info', 'uid' => $msg->userId), array('class' => "username"))?>
            </div>
            <div class="col-md-10" style="padding-left: 40px;">
                <p><? echo $msg->content; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2 info-col" style="padding-left: 40px;">
                <small><? echo '时间：' . $msg->time; ?></small>
            </div>
            <div class="col-md-2" style='text-align:right;'>
                <? echo $count-- . '楼'; ?>
            </div>
        </div>
        <div class="row">
            <hr>
        </div>
    <? } ?>
</div>

<div class="row part-body" id="msg">
    <div class="form-horizontal">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        )); ?>
        <div class="form-group">
            <div class="col-md-3">
                <h6>我要留言：</h6>
            </div>
<!--            --><?php //$this->Widget('ext.ckeditor.CKkceditor', array(
//                "model" => $msgModel, // Data-Model
//                "attribute" => 'content', // Attribute in the Data-Model
//                "height" => '200px',
//                "width" => '100%',
//                "config" => array(
//                    "config.toolbar" => 'Full',
//                    "config.toolbar_Full" => "[
//				                ['Source','-','Save','NewPage','Preview','-','Templates'],
//				                ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
//				                ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
//				                ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
//				                '/',
//				                ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
//				                ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
//				                ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
//				                ['BidiLtr', 'BidiRtl'],
//				                ['Link','Unlink','Anchor'],
//				                ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'],
//				                '/',
//				                ['Styles','Format','Font','FontSize'],
//				                ['TextColor','BGColor'],
//				                ['Maximize', 'ShowBlocks']
//			                ]",
//                ),
//                "filespath" => Yii::app()->basePath . '/../upload',
//                "filesurl" => Yii::app()->baseUrl . '/upload',
//            ));?>
            <div class="col-md-12">
                <?php echo $form->textArea($msgModel,'content',array('id' => 'content',)); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3 col-md-offset-9">
                <?php echo CHtml::submitButton('提交', array('class' => "btn btn-info btn-block")); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script>
    $(function () {
        $('.dropdown-toggle').dropdown();
    })
</script>