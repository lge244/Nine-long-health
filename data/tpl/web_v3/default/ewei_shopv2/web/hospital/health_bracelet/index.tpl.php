<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<link href="<?php  echo EWEI_SHOPV2_LOCAL?>static/css/swiper-3.2.7.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://a.amap.com/jsapi_demos/static/demo-center/css/demo-center.css" />
<script src="<?php  echo EWEI_SHOPV2_LOCAL?>static/js/dist/swiper/swiper-3.4.0.jquery.min.js"></script>
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
<style>
	.container {
		width: 100%;
		border: 1px solid #ccc;
	}
	.swiper1 {
		width: 100%;
	}
	.swiper1 .selected {
		color: #ec5566;
		border-bottom: 2px solid #ec5566;
	}
	.swiper1 .swiper-slide {
		text-align: center;
		font-size: 16px;
		height: 50px;
		/* Center slide text vertically */
		display: -webkit-box;
		display: -ms-flexbox;
		display: -webkit-flex;
		display: flex;
		-webkit-box-pack: center;
		-ms-flex-pack: center;
		-webkit-justify-content: center;
		justify-content: center;
		-webkit-box-align: center;
		-ms-flex-align: center;
		-webkit-align-items: center;
		align-items: center;
		cursor: pointer;
	}
	.swiper2 {
		width: 100%;
	}
	.swiper2 .swiper-slide {
		height: calc(100vh - 50px);
		background-color: #ccc;
		color: #fff;
		text-align: center;
		box-sizing: border-box !important;
		overflow-x: hidden !important;
	}
	#container {
		width: 100%;
		height: 100%;
	}
</style>
<div class="page-header">
	当前位置：<span class="text-primary"><?php  echo $_GPC['mobile'];?>的健康情况</span>
</div>
<div class="page-content">
	<div class="container">
		<div class="swiper-container swiper1">
			<div class="swiper-wrapper">
				<div class="swiper-slide selected">会员定位</div>
				<div class="swiper-slide">会员健康</div>
			</div>
		</div>
		<!-- swiper2 -->
		<div class="swiper-container swiper2">
			<div class="swiper-wrapper">
				<div class="swiper-slide swiper-no-swiping">
					<div style="height: 40px; background: white; padding-top: 10px;">
						<a class="btn btn-primary acquire"  href="javascript:;" >获取会员当前位置</a>
					</div>
					<div id="container"></div>
				</div>
				<div class="swiper-slide swiper-no-swiping">
					<div style="height: 40px; background: white; padding-top: 10px;">
						<a class="btn btn-primary acquire2"  href="javascript:;" >获取会员当前健康情况</a>
					</div>
					<div id="container2" style=""></div>
					<div id="container3" style="margin-top: 10%"></div>
				</div>
				<!--<div class="swiper-slide swiper-no-swiping" style="background: #fff;">
					<table class="table table-responsive">
						<thead class="navbar-inner">
						<tr>
							<th style="width:15%;">ID</th>
							<th style="width:25%;">姓名</th>
							<th style="width:20%;">心率</th>
							<th style="width:20%;">低压</th>
							<th style="width:20%;">高压</th>
							<th style="width:20%;">血糖</th>
							<th style="width:20%;">血氧</th>
						</tr>
						</thead>
						<tbody style="text-align: left;">
						<?php  if(is_array($list)) { foreach($list as $v) { ?>
						<tr>
							<td><?php  echo $v['id'];?></td>
							<td><?php  echo $v['realname'];?></td>
							<td><?php  echo $v['heartRate'];?></td>
							<td><?php  echo $v['dbp'];?></td>
							<td><?php  echo $v['sdp'];?></td>
							<td><?php  echo $v['bloodSugar'];?></td>
							<td><?php  echo $v['oxygen'];?></td>
						</tr>
						<?php  } } ?>
						</tbody>
					</table>
				</div>-->
			</div>
		</div>
	</div>
</div>
<script src="https://webapi.amap.com/maps?v=1.4.14&key=9b8c7adbb647c3c22f9cb6fbca625cac"></script>
<script>
	var map = new AMap.Map('container', {
		resizeEnable: true, //是否监控地图容器尺寸变化
		zoom:11, //初始化地图层级
		center: [116.397428, 39.90923], //初始化地图中心点
	});
	
	$(function() {
		function setCurrentSlide(ele, index) {
			$(".swiper1 .swiper-slide").removeClass("selected");
			ele.addClass("selected");
			//swiper1.initialSlide=index;
		}

		var swiper1 = new Swiper('.swiper1', {
//					设置slider容器能够同时显示的slides数量(carousel模式)。
//					可以设置为number或者 'auto'则自动根据slides的宽度来设定数量。
//					loop模式下如果设置为'auto'还需要设置另外一个参数loopedSlides。
			slidesPerView: 2,
			paginationClickable: true,//此参数设置为true时，点击分页器的指示点分页器会控制Swiper切换。
			spaceBetween: 5,//slide之间的距离（单位px）。
			freeMode: true,//默认为false，普通模式：slide滑动时只滑动一格，并自动贴合wrapper，设置为true则变为free模式，slide会根据惯性滑动且不会贴合。
			loop: false,//是否可循环
			onTab: function(swiper) {
				var n = swiper1.clickedIndex;
			}
		});
		swiper1.slides.each(function(index, val) {
			var ele = $(this);
			ele.on("click", function() {
				setCurrentSlide(ele, index);
				swiper2.slideTo(index, 500, false);
				//mySwiper.initialSlide=index;
			});
		});

		var swiper2 = new Swiper('.swiper2', {
			//freeModeSticky  设置为true 滑动会自动贴合
			direction: 'horizontal',//Slides的滑动方向，可设置水平(horizontal)或垂直(vertical)。
			loop: false,
			effect : 'fade',//淡入
			// effect : 'cube',//方块
			// effect : 'coverflow',//3D流
			// 		effect : 'flip',//3D翻转
			autoHeight: true,//自动高度。设置为true时，wrapper和container会随着当前slide的高度而发生变化。
			onSlideChangeEnd: function(swiper) {  //回调函数，swiper从一个slide过渡到另一个slide结束时执行。
				var n = swiper.activeIndex;
				setCurrentSlide($(".swiper1 .swiper-slide").eq(n), n);
				swiper1.slideTo(n, 500, false);
			}
		});
	});
	function getQueryString(name) {
		var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
		var r = window.location.search.substr(1).match(reg);
		if (r != null) {
			return unescape(r[2]);
		}
		return null;
	}

	$('.acquire').click(function () {
		var mobile = getQueryString('mobile');
		console.log(mobile);
		$.ajax({
			type : 'post',
			url : '<?php  echo webUrl("hospital/healthBracelet/main")?>',
			data : {mobile : mobile},
			dataType : 'json',
			success : function (data) {
				if (data.status){
					new AMap.Map('container', {
						resizeEnable: true, //是否监控地图容器尺寸变化
						zoom:11, //初始化地图层级
						center: [data.result.lon, data.result.lat] //初始化地图中心点
					});
				} else {
					tip.msgbox.err(data.result.message);
					return false;
				}
			}
		});
	})
</script>
<script>
	$('.acquire2').click(function () {
		var mobile = getQueryString('mobile');
		console.log(mobile);
		$.ajax({
			type : 'post',
			url : '<?php  echo webUrl("hospital/healthBracelet/health")?>',
			data : {mobile : mobile},
			dataType : 'json',
			success : function (data) {
				if (data.status){
					console.log(data.result);
				} else {
					tip.msgbox.err(data.result.message);
					return false;
				}
			}
		});
	});

	Highcharts.chart('container2', {
		chart: {
			type: 'column'
		},
		title: {
			text: '该会员最新健康数据'
		},
		subtitle: {
			text: '该数据通过用户上次测量得到'
		},
		xAxis: {
			type: 'category'
		},
		yAxis: {
			title: {
				text: '健康值'
			}
		},
		legend: {
			enabled: false
		},
		plotOptions: {
			series: {
				borderWidth: 0,
				dataLabels: {
					enabled: true,
					format: '{point.y:.1f}'
				}
			}
		},

		series: [{
			name: '浏览健康数据',
			colorByPoint: true,
			data: [
				{
					name: '心率',
					y: <?php  echo $health['heartRate']?>,
				},
				{
					name: '低压',
					y: <?php  echo $health['dbp']?>,
				},
				{
					name: '高压',
					y: <?php  echo $health['sdp']?>,
				},
				{
					name: '血糖',
					y:<?php  if($health['bloodSugar'] == '')echo 0; else echo $health['bloodSugar']?>,
				},
				{
					name: '血氧',
					y: <?php  echo $health['oxygen']?>,
				}
			]
		}]
	});

</script>
<script>
	var chart = Highcharts.chart('container3', {
		title: {
			text: '该会员一周的健康情况'
		},
		subtitle: {
			text: '数据来源：九久健康运动手环'
		},
		yAxis: {
			title: {
				text: '健康值'
			}
		},
		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle'
		},
		plotOptions: {
			series: {
				label: {
					connectorAllowed: false
				},
				pointStart: 1
			}
		},
		series: [{
			name: '心率',
			data: [<?php  echo  $heartRate['0'] ?>, <?php  echo  $heartRate['1'] ?>, <?php  echo  $heartRate['2'] ?>, <?php  echo  $heartRate['3'] ?>, <?php  echo  $heartRate['4'] ?>, <?php  echo  $heartRate['5'] ?>, <?php  echo  $heartRate['6'] ?>]
		}, {
			name: '低压',
			data: [<?php  echo  $dbp['0'] ?>, <?php  echo  $dbp['1'] ?>, <?php  echo  $dbp['2'] ?>, <?php  echo  $dbp['3'] ?>, <?php  echo  $dbp['4'] ?>, <?php  echo  $dbp['5'] ?>, <?php  echo  $dbp['6'] ?>]
		}, {
			name: '高压',
			data:  [<?php  echo  $sdp['0'] ?>, <?php  echo  $sdp['1'] ?>, <?php  echo  $sdp['2'] ?>, <?php  echo  $sdp['3'] ?>, <?php  echo  $sdp['4'] ?>, <?php  echo  $sdp['5'] ?>, <?php  echo  $sdp['6'] ?>]
		}, {
			name: '血糖',
			data:  [<?php  echo  $bloodSugar['0'] ?>, <?php  echo  $bloodSugar['1'] ?>, <?php  echo  $bloodSugar['2'] ?>, <?php  echo  $bloodSugar['3'] ?>, <?php  echo  $bloodSugar['4'] ?>, <?php  echo  $bloodSugar['5'] ?>, <?php  echo  $bloodSugar['6'] ?>]
		}, {
			name: '血氧',
			data:  [<?php  echo  $oxygen['0'] ?>, <?php  echo  $oxygen['1'] ?>, <?php  echo  $oxygen['2'] ?>, <?php  echo  $oxygen['3'] ?>, <?php  echo  $oxygen['4'] ?>, <?php  echo  $oxygen['5'] ?>, <?php  echo  $oxygen['6'] ?>]
		}],
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						layout: 'horizontal',
						align: 'center',
						verticalAlign: 'bottom'
					}
				}
			}]
		}
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/batchcates', TEMPLATE_INCLUDEPATH)) : (include template('goods/batchcates', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>