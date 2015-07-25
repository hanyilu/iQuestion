<?php
$this->pageTitle = "搜索：".$input;
?>

<div class="row part-body" style="border: none;">
    <div class="row">
        <h3>
            <i class="icon-search"><? echo "&nbsp&nbsp".$input."搜索结果"; ?></i>
        </h3>
        <hr>
    </div>
    <div class="row">
        <?php foreach($result as $key=>$user){ ?>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h6><? echo CHtml::link($user->username, array('user/info', 'uid' => $user->id))?></h6>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-2">
                    <div class="row"><? echo "等级：".$user->lv; ?></div>
                    <div class="row"><? echo "经验值：".$user->score; ?></div>
                    <div class="row"><? echo "积分：".$user->credit; ?></div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <? echo CHtml::link("有".count($user->questions)."个问题", array('user/ownerQue', 'uid' => $user->id))?>
                    </div>
                    <div class="row">
                        <? echo CHtml::link("有".count($user->answers)."个回答", array('user/ownerAns', 'uid' => $user->id))?>
                    </div>
                </div>
            </div>
            <hr>
        <? } ?>
    </div>
</div>
