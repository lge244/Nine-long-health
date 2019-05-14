<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
	.fui-cell-group .fui-cell .fui-cell-icon {
		width: auto;
	}

	.fui-cell-group .fui-cell .fui-cell-icon img {
		width: 1.3rem;
		height: 1.3rem;
	}

	.fui-cell-group .fui-cell.no-border {
		padding-top: 0;
	}

	.fui-cell-group .fui-cell.no-border .fui-cell-info {
		font-size: .6rem;
		color: #999;
	}

	.fui-cell-group .fui-cell.applyradio .fui-cell-info {
		line-height: normal;
	}
</style>
<div class='fui-page  fui-page-current'>
	<div class="fui-header">
		<div class="fui-header-left">
			<a class="back"></a>
		</div>
		<div class="title">回填金额</div>
		<div class="fui-header-right">&nbsp;</div>
	</div>
	<div class="fui-content ">
		<div class="fui-cell-group">
			<input type="hidden" name="id" id="id" value="">
			<div class="fui-cell applyradio">
				<div class="fui-cell-label" style="width: 120px;">医疗总金额</div>
				<div class="fui-cell-info">
					<input type="text" id="price" placeholder="请填写医疗总金额" name="price" class="fui-input" value="" max="25">
					<input type="hidden" id="reservation_id" name="reservation_id" class="fui-input" value="<?php  echo $id;?>">
				</div>
			</div>
		</div>
		<a class="btn btn-danger block " id="withdraw">确定</a>
	</div>
</div>
<script>
	$('#withdraw').click(function () {
		var price = $('#price').val();
		var reservation_id = $('#reservation_id').val();
		if (price == '') {
			alert('保单价格不能为空');
			return false;
		}
		$.ajax({
			type : 'post',
			url : '<?php  echo mobileUrl("member/reservation/backFill")?>',
			data : {
				id : reservation_id,
				price : price,
			},
			dataType : 'json',
			success : function (data) {
				if (data.status) {
					alert(data.result.message);
				} else {
					alert(data.result.message);
				}
			}
		});
	})
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>