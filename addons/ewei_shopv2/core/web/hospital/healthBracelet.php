<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}

/**
 * 医院列表管理
 * Class Index_EweiShopV2Page
 */
class HealthBracelet_EweiShopV2Page extends WebPage
{
	/**
	 * 列表
	 */
	public function main()
	{
		global $_GPC;
		if (is_ajax()) {
			$mobile = $_GPC['mobile'];
			if (empty($mobile)) exit(show_json(0, '手机号码错误'));
			$imei = pdo_getcolumn('member_wristband', ['mobile' => $mobile], 'imei');
			$info = json_decode($this->requestApi('357190489608372'), true);
			if ($info['code'] != '0000') {
				exit(show_json(0, $info['message']));
			}
			$res = pdo_fetch("select * from `ims_wristband_location` where imei = '357190489608372' order by id desc");
			exit(show_json(1, $res));
		}
		// 会员健康列表
		$list = pdo_fetchall("SELECT a.id,a.openid,c.realname,b.heartRate,b.dbp,b.sdp,b.bloodSugar,b.oxygen
									FROM `ims_member_wristband` a
									LEFT JOIN `ims_wristband_health` b
									ON a.imei = b.imei
									LEFT JOIN `ims_ewei_shop_member` c
									ON a.openid = c.openid");
		include $this->template('hospital/health_bracelet/index');
	}

	/**
	 * 请求第三方定位接口
	 * @param string $imei 串号
	 * @return bool|string
	 */
	public function requestApi($imei = '')
	{
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_PORT           => "8080",
			CURLOPT_URL            => "http://api.jiai.pro:8080/jiai/location",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => "PUT",
			CURLOPT_POSTFIELDS     => "{\n\"imei\":\"$imei\"\n}",
			CURLOPT_HTTPHEADER     => [
				"Accept: */*",
				"Cache-Control: no-cache",
				"Connection: keep-alive",
				"Content-Type: application/json",
				"Host: api.jiai.pro:8080",
				"Postman-Token: 23c75434-21d4-4bf1-acbb-7aa44aeed63e,a68977e1-64d5-459a-9963-c3a132694c3c",
				"User-Agent: PostmanRuntime/7.11.0",
				"accept-encoding: gzip, deflate",
				"cache-control: no-cache",
				"content-length: 28",
				"cpid: 424",
				"imei: $imei",
				"key: d0041f5e674aebd6b645fbdca5885644"
			],
		]);
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			return "cURL Error #:" . $err;
		} else {
			return $response;
		}
	}
}