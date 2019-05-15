<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
	.fui-cell-group .fui-cell .fui-cell-label{
		width:4.2rem;
	}
</style>
<div class='fui-page  fui-page-current'>
    <div class="fui-header">
		<div class="fui-header-left">
			<a class="back" onclick='location.back()'></a>
		</div>
		<div class="title"><?php  if(!empty($bind)) { ?>更换绑定手机号<?php  } else { ?>绑定手机号<?php  } ?></div>
		<div class="fui-header-right">&nbsp;</div>
	</div>

	<div class='fui-content' style='margin-top:5px;'>

		<div class="fui-cell-group">

			<div class="fui-cell must">
				<div class="fui-cell-label">手机号</div>
				<div class="fui-cell-info"><input type="tel" class='fui-input' id='mobile' name='mobile' placeholder="请输入您的手机号"  value="<?php  echo $member['mobile'];?>" maxlength="11" /></div>
			</div>

			<?php  if(!empty($wapset['smsimgcode'])) { ?>
			<div class="fui-cell must">
				<div class="fui-cell-label">图形验证码</div>
				<div class="fui-cell-info">
					<input type="tel" class="fui-input" value="" placeholder="请输入图形验证码" name="verifycode2" id="verifycode2" maxlength="4" />
				</div>
				<div class="remark noremark">
					<img src="../web/index.php?c=utility&a=code&r=<?php  echo time()?>" style="width: 3.5rem; height: 1.5rem; vertical-align: middle;" id="btnCode2">
				</div>
			</div>
			<?php  } ?>

			<div class="fui-cell must">
				<div class="fui-cell-label">短信验证码</div>
				<div class="fui-cell-info"><input type="tel" class='fui-input' id='verifycode' name='verifycode' placeholder="5位验证码"  value="" maxlength="5" /></div>
				<div class="fui-cell-remark noremark"><a class="btn btn-default btn-default-o btn-sm" id="btnCode">获取验证码</a></div>
			</div>
			<div class="fui-cell must">
				<div class="fui-cell-label">登录密码</div>
				<div class="fui-cell-info"><input type="password" class='fui-input' id='pwd' name='pwd' placeholder="请输入您的登录密码"  value="" /></div>
			</div>
			<div class="fui-cell must">
				<div class="fui-cell-label">确认密码</div>
				<div class="fui-cell-info"><input type="password" class='fui-input' id='pwd1' name='pwd1' placeholder="请输入确认登录密码"  value="" /></div>
			</div>

		</div>

		<a href='#' id='btnSubmit' class='btn btn-danger block mtop'>立即绑定</a>
	</div>
	<script language='javascript'>
		require(['biz/member/account'], function (modal) {
		  	modal.initBind({
				endtime: <?php  echo intval($endtime)?>,
				backurl: "<?php  echo $_GPC['backurl'];?>",
				imgcode: <?php  echo intval($wapset['smsimgcode'])?>
			});
		});
</script>

</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

