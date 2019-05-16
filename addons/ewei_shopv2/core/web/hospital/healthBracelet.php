<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}


/**
 * 获取会员健康和定位信息
 * Class HealthBracelet_EweiShopV2Page
 */
class HealthBracelet_EweiShopV2Page extends WebPage
{
	/**
	 * 列表
	 */
	public function main()
	{
		global $_GPC;
		$mobile = $_GPC['mobile'];
		if (empty($mobile)) exit(show_json(0, '手机号码错误'));
		$imei = pdo_getcolumn('member_wristband', ['mobile' => $mobile], 'imei');
		if (is_ajax()) {
			$info = json_decode($this->requestApi($imei, 'http://api.jiai.pro:8080/jiai/location'), true);
			if ($info['code'] != '0000') {
				exit(show_json(0, $info['message']));
			}
			$res = pdo_fetch("select * from `ims_wristband_location` where imei = ". $imei ." order by id desc");
			exit(show_json(1, $res));
		}
		// 会员健康列表
		$health = pdo_fetch("select * from `ims_wristband_health` where imei = " . $imei . " order by id desc");
		$week_health = pdo_getall('wristband_health', ['imei' => $imei], [], '', 'id desc', [7]);
		sort($week_health);
		dump($week_health);
		include $this->template('hospital/health_bracelet/index');
	}

	public function health()
	{
		global $_GPC;
		$mobile = $_GPC['mobile'];
		if (empty($mobile)) exit(show_json(0, '手机号码错误'));
		$imei = pdo_getcolumn('member_wristband', ['mobile' => $mobile], 'imei');
		$info = json_decode($this->requestApi($imei, 'http://api.jiai.pro:8080/jiai/bloodPressure'), true);
		if ($info['code'] != '0000') {
			exit(show_json(0, $info['message']));
		}
		$res = pdo_fetch("select * from `ims_wristband_location` where imei = ". $imei ." order by id desc");
		exit(show_json(1, '获取成功'));
	}

	/**
	 * 请求第三方定位接口
	 * @param string $imei 串号
	 * @param string $url 地址
	 * @return bool|string
	 */
	public function requestApi($imei = '', $url = '')
	{
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_PORT           => "8080",
			CURLOPT_URL            => $url,
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