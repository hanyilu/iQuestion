<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name."--话题广场";
?>
<div class="row part-body" style="border: none">
    <div class="row" id="nav">
        <h6>
            <i class="icon-th-large">&nbsp;&nbsp;话题广场</i>
        </h6>
        <hr>
    </div>

    <div class="row">

        <div class="row">
            <? foreach ($tags as $key => $tag) {
            if ($tag->name == NULL || $tag->frequency == 0) continue;?>
            <div class="col-md-3" style="text-align:center;height: 80px;">
                <a href="<? echo Yii::app()->createUrl('tag/view', array('tid' => $tag->id)); ?>">
                    <span class="label label-info" style="font-size:0.8em;">
						<i class="icon-tag"><? echo " " . $tag->name; ?></i>
					</span>
                </a>
                <span style="font-size:0.6em;"><? echo "&nbsp&nbsp×" . $tag->frequency; ?></span>
            </div>
            <? } ?>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/value.js"></script>
<script>
    $(function () {
        $('.dropdown-toggle').dropdown();
    })
</script>