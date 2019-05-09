<?php defined('IN_IA') or exit('Access Denied');?><?php  $no_left =true;?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>



<script type="text/javascript" src="../addons/ewei_shopv2/static/js/dist/area/cascade.js"></script>

<script type="text/javascript" src="../web/resource/js/lib/moment.js"></script>

<link rel="stylesheet" href="../web/resource/components/datetimepicker/jquery.datetimepicker.css">

<link rel="stylesheet" href="../web/resource/components/daterangepicker/daterangepicker.css">

<style type='text/css'>

    .tabs-container .form-group {overflow: hidden;}

    .tabs-container .tabs-left > .nav-tabs {}

    .tab-goods .nav li {float:left;}

    .spec_item_thumb {position: relative; width: 30px; height: 20px; padding: 0; border-left: none;}

    .spec_item_thumb i {position: absolute; top: -5px; right: -5px;}

    .multi-img-details, .multi-audio-details {margin-top:.5em;max-width: 700px; padding:0; }

    .multi-audio-details .multi-audio-item {width:155px; height: 40px; position:relative; float: left; margin-right: 5px;}

    .region-goods-details {

        background: #f8f8f8;

        margin-bottom: 10px;

        padding: 0 10px;

    }

    .region-goods-left{

        text-align: center;

        font-weight: bold;

        color: #333;

        font-size: 14px;

        padding: 20px 0;

    }

    .region-goods-right{

        border-left: 3px solid #fff;

        padding: 10px 10px;

    }

    <?php  if($item['type']==4) { ?>

    .type-4 {display: none;}

    <?php  } ?>

</style>

<div class="page-header">

    当前位置：

    <span class="text-primary">
        添加上课信息
    </span>

</div>

<div class="page-content">

    <form method="post">

        <input type="hidden" id="tab" name="tab" value="#tab_basic" />

        <div class="tabs-container tab-goods">

            <div class="tabs-left">

                <ul class="nav nav-tabs" id="myTab">
                    <li  <?php  if(empty($_GPC['tab']) || $_GPC['tab']=='basic') { ?>class="active"<?php  } ?>><a href="#tab_basic">基本</a></li>
                </ul>

                <div class="tab-content  ">
                    <div class="region-goods-details row">
                        <div class="region-goods-left col-sm-2">
                            课程信息
                        </div>
                        <div class="region-goods-right col-sm-10">
                            <input type="hidden" name="uid" id="uid" class="form-control" value="<?php  echo $item['uid'];?>" data-rule-required="true" />

                            <div class="form-group dispatch_info">
                                <label class="col-sm-2 control-label">学员信息</label>
                                <div class="col-sm-5">
                                    <select class="form-control tpl-category-parent select2" id="member" name="member"  data-rule-required="true" >
                                        <?php  if(is_array($member)) { foreach($member as $row) { ?>
                                        <option value="<?php  echo $row['openid'];?>"  ><?php  echo $row['nickname'];?></option>
                                        <?php  } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group dispatch_info">
                                <label class="col-sm-2 control-label">课程信息</label>
                                <div class="col-sm-5">
                                    <select class="form-control tpl-category-parent select2" id="goods" name="goods"  data-rule-required="true" >
                                        <?php  if(is_array($goods)) { foreach($goods as $row) { ?>
                                        <option value="<?php  echo $row['id'];?>"  ><?php  echo $row['title'];?></option>
                                        <?php  } } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group dispatch_info" >
                            <label class="col-lg control-label">上课状态</label>
                            <div class="col-sm-9 col-xs-12">
                                <label class='radio-inline'>
                                    <input type='radio' name='status' value='1'  /> 已上课
                                </label>
                                <label class='radio-inline'>
                                    <input type='radio' name='status' value='0'  /> 未上课
                                </label>
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
                <a id="submit" class="btn btn-primary">保存管理</a>
                <a class="btn btn-default" href="<?php  echo webUrl('training')?>">返回列表</a>
            </div>
        </div>
    </form>
</div>



<script type="text/javascript">

    $('#submit').click(function () {
        var status = $("input[name='status']:checked").val();
        var member = $("#member option:selected").val();
        var goods = $("#goods option:selected").val();
        var good = $("#goods option:selected").text();
        console.log(good)
        if (member == '') {
            tip.msgbox.err('请选择学员!');
            return false;
        }
        if (goods == '') {
            tip.msgbox.err('请选择课程!');
            return false;
        }

        $.post("<?php  echo webUrl('training/post')?>", {
            "openid":member,
            "goodsid":goods,
            "title":good,
            "status":status
        }, function (res) {
            if (res.code == 0) {
                tip.msgbox.suc(res.msg);
            }else{
                tip.msgbox.err(res.msg);
            }
        },'json')


    });

</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

