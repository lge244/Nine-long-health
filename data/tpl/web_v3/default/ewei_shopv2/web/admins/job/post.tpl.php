<?php defined('IN_IA') or exit('Access Denied');?><?php  $no_left =true;?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>


<script type="text/javascript" src="../addons/ewei_shopv2/static/js/dist/area/cascade.js"></script>

<script type="text/javascript" src="../web/resource/js/lib/moment.js"></script>

<link rel="stylesheet" href="../web/resource/components/datetimepicker/jquery.datetimepicker.css">

<link rel="stylesheet" href="../web/resource/components/daterangepicker/daterangepicker.css">

<style type='text/css'>

    .tabs-container .form-group {
        overflow: hidden;
    }

    .tabs-container .tabs-left > .nav-tabs {
    }

    .tab-goods .nav li {
        float: left;
    }

    .spec_item_thumb {
        position: relative;
        width: 30px;
        height: 20px;
        padding: 0;
        border-left: none;
    }

    .spec_item_thumb i {
        position: absolute;
        top: -5px;
        right: -5px;
    }

    .multi-img-details, .multi-audio-details {
        margin-top: .5em;
        max-width: 700px;
        padding: 0;
    }

    .multi-audio-details .multi-audio-item {
        width: 155px;
        height: 40px;
        position: relative;
        float: left;
        margin-right: 5px;
    }

    .region-goods-details {

        background: #f8f8f8;

        margin-bottom: 10px;

        padding: 0 10px;

    }

    .region-goods-left {

        text-align: center;

        font-weight: bold;

        color: #333;

        font-size: 14px;

        padding: 20px 0;

    }

    .region-goods-right {

        border-left: 3px solid #fff;

        padding: 10px 10px;

    }

    {
        if $ item [ 'type' ] = = 4
    }

    .type-4 {
        display: none;
    }

    {
    /
    if
    }

</style>

<div class="page-header">

    当前位置：

    <span class="text-primary">

    <?php  if(!empty($item['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>权限 <small><?php  if(!empty($item['id'])) { ?>修改【<span
            class="text-info"><?php  echo $item['title'];?></span>】<?php  } ?><?php  if(!empty($merch_user['merchname'])) { ?>商户名称:【<span
            class="text-info"><?php  echo $merch_user['merchname'];?></span>】<?php  } ?></small>

    </span>

</div>

<div class="page-content">

    <form method="post">

    <input type="hidden" id="tab" name="tab" value="#tab_basic"/>

    <div class="tabs-container tab-goods">

        <div class="tabs-left">

            <div class="tab-content  ">
                <div class="region-goods-details row">
                    <div class="region-goods-left col-sm-2">
                        权限信息
                    </div>
                    <div class="region-goods-right col-sm-10">
                        <div class="form-group">
                            <label class="col-sm-2 control-label must">权限名称</label>
                            <div class="col-sm-5" style="padding-right:0;">
                                <input type="text" name="jobtitle" id="jobtitle" class="form-control" value=""
                                       data-rule-required="true"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">权限描述</label>
                            <div class="col-sm-9 subtitle">
                                <textarea name="jobdesc" id="jobdesc" rows="5" class="form-control"
                                          data-parent=".subtitle" maxlength="100" data-rule-maxlength="100"></textarea>
                                <div class="help-block">权限描述的越详细越好</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-9 subtitle">
            <input type="submit" value="保存信息" class="btn btn-primary"/>
            <a class="btn btn-default"
               href="<?php  echo webUrl('admins/job')?>">返回列表</a>
        </div>
    </div>
    </form>
</div>


<script type="text/javascript">
    window.type = "<?php  echo $item['type'];?>";
    window.virtual = "<?php  echo $item['virtual'];?>";
    require(['bootstrap'], function () {
        $('#myTab a').click(function (e) {
            $('#tab').val($(this).attr('href'));
            e.preventDefault();
            $(this).tab('show');
        })
    });

    window.optionchanged = false;

    $('form').submit(function () {
        var check = true;
        var jobtitle = $('#jobtitle').val();
        var jobdesc = $('#jobdesc').val();

        if (jobtitle == '') {
            tip.msgbox.err('请填写权限名称!');
            return false;
        }
        $.post("<?php  echo webUrl('admins/job/post')?>", {
            jobtitle: jobtitle,
            jobdesc: jobdesc
        }, function (res) {
            if (res.code == 0) {
               tip.msgbox.err(res.msg);
            }else{
                tip.msgbox.err(res.msg);
            }
        },'json')
    });

</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

