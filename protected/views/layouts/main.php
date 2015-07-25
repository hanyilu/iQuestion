<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/flat-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>

    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/js/flat-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/js/application.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/value.js"></script>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand"
                   href="<?php echo $this->createUrl('site/index'); ?>"><?php echo Yii::app()->name . ","; ?></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse-01">
                <form class="navbar-form navbar-left" role="search" action="" method="post" name="searchform">
                    <div class="form-group">
                        <div class="input-group">
							<span class="input-group-btn">
								<select class="btn form-control" id="search-select" name="type">
                                    <option value="0">问题</option>
                                    <option value="1">用户</option>
                                </select>
							</span>
                            <input class="form-control" id="search-input" type="search" name="input" placeholder="...">
							<span class="input-group-btn">
								<button type="submit" class="btn" onclick="search()">
                                    <i class="icon-search"></i>
                                </button>
							</span>
                        </div>
                    </div>
                </form>


                <ul class="nav navbar-nav">
                    <li><? echo CHtml::link("首页", array('site/index')) ?></li>
                    <li><? echo CHtml::link("个人中心", array('user/index')) ?></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    if (!Yii::app()->user->isGuest) {
                        echo "<li><a href='" . $this->createUrl("user/logout") . "'><small>退出登录</small></a></li>";
                    }?>
                </ul>
            </div>
        </div>
    </nav>
</div>


<div class="container">
    <div class="row" style="margin: 0 auto; padding-bottom: 60px;">
        <div class="col-md-9" id="left-col">
            <?php echo $content; ?>
        </div>
        <div class="col-md-3">
            <div id="right-col">
                <?php
                if (Yii::app()->user->isGuest) {
                    ?>
                    <div class="row a-button">
                        <a href="<?php echo $this->createUrl('user/login'); ?>">
                            <button class="btn btn-info btn-block"><i class="icon-user">&nbsp;&nbsp;登录</i></button>
                        </a>
                    </div>
                    <div class="row a-button">
                        <a href="<?php echo $this->createUrl('user/signup'); ?>">
                            <button class="btn btn-info btn-block"><i class="icon-spinner">&nbsp;&nbsp;注册</i></button>
                        </a>
                    </div>
                <?
                } else {
                    $user = User::model()->findByPk(Yii::app()->user->id);?>
                    <div class="row">
                        <div class="col-md-5" style="margin-left: -15px;">
                            <div class="icon <? echo 'icon_'.$user->icon; ?>"></div>
                        </div>
                        <div class="col-md-7" style="margin-left: 15px;">
                            <?
                            echo Yii::app()->user->name . "（Lv." . $user->lv . "）";
                            echo "<br>";
                            echo "<small>经验值：" . $user->score.'</small>';
                            echo "<br>";
                            echo "<small>剩余积分：" . $user->credit.'</small>';
                            ?>
                        </div>
                    </div>
                <? } ?>
                <div class="row">
                    <hr>
                </div>
                <div class="row">
                    <?php if (Yii::app()->user->hasFlash('publish-fail')) { ?>
                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span
                                    aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <small
                                style="font-size:0.5em;"><? echo Yii::app()->user->getFlash('publish-fail'); ?></small>
                        </div>
                    <? } ?>
                </div>
                <div class="row a-button">
                    <a href="<?php echo $this->createUrl('question/publish'); ?>">
                        <button class="btn btn-info btn-block"><i class="icon-file-alt">&nbsp;&nbsp;我要提问</i></button>
                    </a>
                </div>
                <div class="row a-button">
                    <a href="<?php echo $this->createUrl('tag/index'); ?>">
                        <button class="btn btn-info btn-block"><i class="icon-th-large">&nbsp;&nbsp;话题广场</i></button>
                    </a>
                </div>
                <div class="row a-button">
                    <a href="<?php echo $this->createUrl('question/all'); ?>">
                        <button class="btn btn-info btn-block"><i class="icon-list-ul">&nbsp;&nbsp;所有问题</i></button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.pin.min.js"></script>
<script type="text/javascript">
    $("#right-col").pin({
        containerSelector: ".container",
        minWidth: 940
    });
</script>
<script type="text/javascript">
    function search(){
        if(document.getElementById("search-input").value != "")
            document.searchform.action = "index.php?r=search/index";
        else
            document.searchform.action = "";
    }
</script>
</body>
</html>
