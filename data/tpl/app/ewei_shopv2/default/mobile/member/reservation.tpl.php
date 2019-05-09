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
		<div class="title">申请预约</div>
		<div class="fui-header-right">&nbsp;</div>
	</div>
	<div class="fui-content ">
		<div class="fui-cell-group">
			<div class="fui-cell applyradio">
				<div class="fui-cell-label" style="width: 120px;">姓名</div>
				<div class="fui-cell-info">
					<input type="text" id="name" placeholder="请填写姓名" name="name" class="fui-input" value=""
					       max="25">
				</div>
			</div>
			<div class="fui-cell applyradio">
				<div class="fui-cell-label" style="width: 120px;">手机号码</div>
				<div class="fui-cell-info">
					<input type="text" id="phone" placeholder="请填写手机号码" name="phone" class="fui-input" value=""
					       max="25">
				</div>
			</div>
			<div class="fui-cell applyradio">
				<div class="fui-cell-label" style="width: 120px;">选择医院</div>
				<select id="hospital_id" name="hospital_id" class="form-control">
					<option value="0">请选择医院</option>
					<?php  if(is_array($hospital_list)) { foreach($hospital_list as $v) { ?>
					<option value="<?php  echo $v['id'];?>"><?php  echo $v['name'];?></option>
					<?php  } } ?>
				</select>
			</div>
		</div>
		<a class="btn btn-danger block " id="withdraw">申请预约</a>
	</div>
</div>
<script>
	$('#withdraw').click(function () {
		var name = $('#name').val();
		var phone = $('#phone').val();
		var hospital_id = $('#hospital_id').val();
		// var myreg = /^[1][3,4,5,7,8][0-9]{9}$/;
		// if (name == '' || phone == '' || hospital_id == '') {
		// 	alert('预约的个人信息不能缺少');
		// 	return false;
		// }
		// if (!myreg.test(phone)) {
		// 	tip.msgbox.err('请填写正确的手机号!');
		// 	return false;
		// }

		$.ajax({
			type : 'post',
			url : '<?php  echo mobileUrl("member/reservation/add")?>',
			data : {
				name : name,
				phone : phone,
				hospital_id : hospital_id
			},
			dataType : 'json',
			success : function (data) {
				if (data.status == 1) {
					alert(data.result.msg);
					window.location = "<?php  echo mobileUrl('member/reservation/record')?>";
				} else {
					alert(data.result.msg);
				}
			}
		});
	})
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>