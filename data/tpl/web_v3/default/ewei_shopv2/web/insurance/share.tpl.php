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
                <input type="number" name="ordermoney" class="form-control" value="<?php  echo $level['ordermoney'];?>"/>
                <span class='input-group-addon'>%</span>
            </div>
            <div class='input-group fixsingle-input-group' style="margin-top: 5px;">
                <span class='input-group-addon'>推荐人分润比例</span>
                <input type="number" name="ordernum" class="form-control" value="<?php  echo $level['ordercount'];?>"/>
                <span class='input-group-addon'>%</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg control-label"></label>
        <div class="col-sm-9 col-xs-12">
            <input type="submit" value="提交" class="btn btn-primary"/>
            <input type="button" name="back" onclick='history.back()' <?php if(cv('member.level.add|member.level.edit')) { ?>style='margin-left:10px;'<?php  } ?> value="返回列表" class="btn btn-default" />
        </div>

    </div>


</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

