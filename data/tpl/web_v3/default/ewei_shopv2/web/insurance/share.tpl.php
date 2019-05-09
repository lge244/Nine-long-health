<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>


<div class="page-header">

    当前位置：<span class="text-primary"><?php  if(!empty($level['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>会员等级<?php  if(!empty($level['id'])) { ?>(<?php  echo $level['levelname'];?>)<?php  } ?></span>

</div>


<div class="page-content">

    <div class="page-sub-toolbar">

        <span class=''>
        </span>

    </div>
    <input type="hidden" name="id" value="<?php  echo $level['id'];?>"/>
    <div class="form-group">

        <label class="col-lg control-label">保单分润</label>

        <div class="col-sm-9 col-xs-12">
            <div class='input-group fixsingle-input-group'>
                <span class='input-group-addon'>管理者分润比例</span>
                <input type="number" name="custodian_ratio" id="custodian_ratio" class="form-control" value="<?php  echo $ratio['custodian_ratio'];?>"/>
                <span class='input-group-addon'>%</span>
            </div>
            <div class='input-group fixsingle-input-group' style="margin-top: 5px;">
                <span class='input-group-addon'>推荐人分润比例</span>
                <input type="number" name="referrer_ratio" id="referrer_ratio" class="form-control" value="<?php  echo $ratio['referrer_ratio'];?>"/>
                <span class='input-group-addon'>%</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg control-label"></label>
        <div class="col-sm-9 col-xs-12">
            <input type="submit" value="保存" class="btn btn-primary submit"/>
        </div>
    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<script>
    $('.submit').click(function () {
        var custodian_ratio = $('#custodian_ratio').val();
        var referrer_ratio = $('#referrer_ratio').val();

        if (referrer_ratio == 0 || custodian_ratio == 0){
            tip.msgbox.suc("分润比例不能为零！");
            return false;
        }

        $.post("<?php  echo webUrl('insurance/share/add')?>",{
            "custodian_ratio":custodian_ratio,
            "referrer_ratio":referrer_ratio,
        },function (res) {
           if(res.code == 0){
               tip.msgbox.suc(res.msg)
               window.location.reload();
           }else{
               tip.msgbox.suc(res.msg)
           }
        },'json')
    })
</script>
