<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
	tbody tr td {
		position: relative;
	}

	tbody tr .icow-weibiaoti-- {
		visibility: hidden;
		display: inline-block;
		color: #fff;
		height: 18px;
		width: 18px;
		background: #e0e0e0;
		text-align: center;
		line-height: 18px;
		vertical-align: middle;
	}

	tbody tr:hover .icow-weibiaoti-- {
		visibility: visible;
	}

	tbody tr .icow-weibiaoti--.hidden {
		visibility: hidden !important;
	}

	.full .icow-weibiaoti-- {
		margin-left: 10px;
	}

	.full > span {
		display: -webkit-box;
		display: -webkit-flex;
		display: -ms-flexbox;
		display: flex;
		vertical-align: middle;
		align-items: center;
	}

	tbody tr .label {
		margin: 5px 0;
	}

	.goods_attribute a {
		cursor: pointer;
	}

	.newgoodsflag {
		width: 22px;
		height: 16px;
		background-color: #ff0000;
		color: #fff;
		text-align: center;
		position: absolute;
		bottom: 70px;
		left: 57px;
		font-size: 12px;
	}

	.modal-dialog {
		min-width: 720px !important;
		position: absolute;
		left: 0;
		right: 0;
		top: 50%;
	}

	.catetag {
		overflow: hidden;

		text-overflow: ellipsis;

		display: -webkit-box;

		-webkit-box-orient: vertical;

		-webkit-line-clamp: 2;
	}
</style>
<div class="page-header">
	当前位置：<span class="text-primary">预约列表</span>
</div>
<div class="page-content">
	<div class="fixed-header">
		<div style="width:25px;"></div>
		<div style="width:80px;text-align:center;">排序</div>
		<div style="width:80px;">商品</div>
		<div class="flex1">&nbsp;</div>
		<div style="width: 100px;">价格</div>
		<div style="width: 80px;">库存</div>
		<div style="width: 80px;">销量</div>
		<?php  if($goodsfrom!='cycle') { ?>
		<div style="width:80px;">状态</div>
		<?php  } ?>
		<div class="flex1">属性</div>
		<div style="width: 120px;">操作</div>
	</div>
	<form action="./index.php" method="get" class="form-horizontal form-search" role="form">
		<input type="hidden" name="c" value="site"/>
		<input type="hidden" name="a" value="entry"/>
		<input type="hidden" name="m" value="ewei_shopv2"/>
		<input type="hidden" name="do" value="web"/>
		<input type="hidden" name="r" value="goods.<?php  echo $goodsfrom;?>"/>
		<!--		<div class="page-toolbar">-->
		<!--			<span class="pull-left" style="margin-right:30px;">-->
		<!--				<a class='btn btn-sm btn-primary' href="<?php  echo webUrl('hospital/add')?>"><i class='fa fa-plus'></i> 添加医院</a>-->
		<!--			</span>-->
		<!--		</div>-->
	</form>

	<div class="row">
		<div class="col-md-12">
			<table class="table table-responsive">
				<thead class="navbar-inner">
				<tr>
					<th style="width:15%;">ID</th>
					<th style="width:25%;">姓名</th>
					<th style="width:20%;">电话</th>
					<th style="width:20%;">医院</th>
					<th style="width:20%;">状态</th>
				</tr>
				</thead>
				<tbody>
				<?php  if(is_array($list)) { foreach($list as $row) { ?>
				<tr>
					<td><?php  echo $row['id'];?></td>
					<td><?php  echo $row['name'];?></td>
					<td><?php  echo $row['phone'];?></td>
					<td><?php  echo $row['hospital_name'];?></td>
					<td>
						<a class='btn  btn-op btn-operation'
						   <?php if(cv($row['status'] < 4 && $row['status'] >= 1)) { ?>
						   data-toggle='ajaxRemove'
							<?php  } ?>
						   <?php if(cv($row['status'] < 4 && $row['status'] >= 1)) { ?>
								href="<?php  echo webUrl('hospital/reservation/edit', ['id' => $row['id'], 'status' => $row['status']])?>"
							<?php  } else { ?>
								href="javascript:;"
							<?php  } ?>
						   data-confirm='确认更改此状态?'>

								<span data-toggle="tooltip" data-placement="top" title="" data-original-title="编辑">
								<?php if(cv($row['status'] == 1)) { ?>已预约<?php  } ?>
								<?php if(cv($row['status'] == 2)) { ?>已就诊<?php  } ?>
								<?php if(cv($row['status'] == 3)) { ?>已付款<?php  } ?>
								<?php if(cv($row['status'] == 4)) { ?>已分润<?php  } ?>
							</span>
						</a>
					</td>
				</tr>
				<?php  } } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/batchcates', TEMPLATE_INCLUDEPATH)) : (include template('goods/batchcates', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<script>

</script>