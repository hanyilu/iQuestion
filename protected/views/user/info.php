<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . "--个人资料";
if ($uid == Yii::app()->user->id) {
    $t = "我";
} else {
    $t = "TA";
}
?>

<div class="row" id="nav">
    <ul class="nav nav-pills">
        <li class="active">
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
        <li>
            <? echo CHtml::link($t . '的留言板', array('user/message', 'uid' => $uid)); ?>
        </li>
    </ul>
</div>
<div class="row  part-body">

    <div class="row">
        <div class="col-md-2 col-md-offset-1" style="padding: 10px 50px 10px 0;">
            <div class="icon <? echo 'icon_'.$user->icon; ?>"></div>
        </div>
        <div class="col-md-9">
            <table>
                <tr>
                    <td><small>用户名：</small></td>
                    <td><small><?echo $user->username;?></small></td>
                </tr>
                <tr>
                    <td><small>等级：</small></td>
                    <td><small><?echo $user->lv;?></small></td>
                </tr>
                <tr>
                    <td><small>经验值：</small></td>
                    <td><small><?echo $user->score;?></small></td>
                </tr>
                <tr>
                    <td><small>剩余积分：</small></td>
                    <td><small><?echo $user->credit;?></small></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row"><hr></div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1" style="text-align: center; padding: 10px 0 50px;">
<!--            <table class="table">-->
<!--                <tr class="info">-->
<!--                    <td>提过问题</td>-->
<!--                    <td>回答过问题</td>-->
<!--                    <td>赞过问题</td>-->
<!--                    <td>赞过回答</td>-->
<!---->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>--><?// echo CHtml::link($queCount, array('user/ownerQue', 'uid' => $uid)); ?><!--</td>-->
<!--                    <td>--><?// echo CHtml::link($ansCount, array('user/ownerAns', 'uid' => $uid)); ?><!--</td>-->
<!--                    <td>--><?// echo CHtml::link($likeQueCount, array('user/likeQue', 'uid' => $uid)); ?><!--</td>-->
<!--                    <td>--><?// echo CHtml::link($likeAnsCount, array('user/likeAns', 'uid' => $uid)); ?><!--</td>-->
<!--                </tr>-->
<!--            </table>-->
            <table class="panel-table">
                <tr>
                    <td>
                        <a href="<?php echo Yii::app()->createUrl('user/ownerQue', array('uid' => $uid)); ?>">
                            <div class="panel panel-success">
                                <div class="panel-body">
                                    <? echo $queCount; ?>
                                </div>
                                <div class="panel-footer">提过的问题</div>
                            </div>
                        </a>
                    </td>

                    <td>
                        <a href="<?php echo Yii::app()->createUrl('user/ownerAns', array('uid' => $uid)); ?>">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <? echo $ansCount; ?>
                                </div>
                                <div class="panel-footer">提交的回答</div>
                            </div>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo Yii::app()->createUrl('user/likeQue', array('uid' => $uid)); ?>">
                        <div class="panel panel-warning">
                            <div class="panel-body">
                                <? echo $likeQueCount; ?>
                            </div>
                            <div class="panel-footer">赞过的问题</div>
                        </div>
                    </td>
                    <td>
                        <a href="<?php echo Yii::app()->createUrl('user/likeAns', array('uid' => $uid)); ?>">
                        <div class="panel panel-danger">
                            <div class="panel-body">
                                <? echo $likeAnsCount; ?>
                            </div>
                            <div class="panel-footer">赞过的回答</div>
                        </div>
                    </td>


                </tr>
            </table>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('.dropdown-toggle').dropdown();
    })
</script>