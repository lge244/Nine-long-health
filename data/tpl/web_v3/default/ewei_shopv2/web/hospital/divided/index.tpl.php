<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>


<div class="page-header">

	当前位置：<span class="text-primary"><?php  if(!empty($level['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>会员等级<?php  if(!empty($level['id'])) { ?>(<?php  echo $level['levelname'];?>)<?php  } ?></span>

</div>


<div class="page-content">

	<div class="page-sub-toolbar">

		<span class=''></span>

	</div>
	<input type="hidden" name="id" value="<?php  echo $level['id'];?>"/>
	<div class="form-group">
		<label class="col-lg control-label">保单分润</label>
		<div class="col-sm-9 col-xs-12">
			<div class='input-group fixsingle-input-group'>
				<span class='input-group-addon'>管理者分润比例</span>
				<input type="number" name="manager" id="manager" class="form-control" value="<?php  echo $info['manager'];?>"/>
				<input type="hidden" id="divided_id" value="<?php  echo $info['id'];?>">
				<span class='input-group-addon'>%</span>
			</div>
			<div class='input-group fixsingle-input-group' style="margin-top: 5px;">
				<span class='input-group-addon'>推荐人分润比例</span>
				<input type="number" name="recommender" id="recommender" class="form-control"
				       value="<?php  echo $info['recommender'];?>"/>
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
		var manager = $('#manager').val();
		var recommender = $('#recommender').val();
		var divided_id = $('#divided_id').val();
		if (manager == 0 || recommender == 0) {
			tip.msgbox.suc("分润比例不能为零！");
			return false;
		}
		$.ajax({
			type: 'post',
			url: '<?php  echo webUrl("hospital/divided/save")?>',
			data: {
				divided_id: divided_id,
				manager: manager,
				recommender: recommender,
			},
			dataType: 'json',
			success: function (data) {
				if (data.status) {
					tip.msgbox.suc(data.result.message);
					// $('#manager').val(manager);
					// $('#recommender').val(recommender);
				} else {
					tip.msgbox.suc(data.result.message);
				}
			}
		});
	})
</script>