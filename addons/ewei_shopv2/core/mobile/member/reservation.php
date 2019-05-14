<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}

class Reservation_EweiShopV2Page extends MobileLoginPage
{
	/**
	 * 预约页面
	 */
	public function main()
	{
		global $_W;
		global $_GPC;
		// 医院列表
		$hospital_list = pdo_getall('ewei_hospital');
		include $this->template();
	}

	/**
	 * 添加预约
	 */
	public function add()
	{
		global $_GPC;
		global $_W;
		$data = [
			'name'        => $_GPC['name'],
			'phone'       => $_GPC['phone'],
			'hospital_id' => intval($_GPC['hospital_id']),
			//默认为1=>已预约状态
			'status'      => 1,
			// 当前用户id
			'mid'         => $_W['mid']
		];
		if (empty($data['name']) || empty($data['phone']) || empty($data['hospital_id'])) {
			exit(show_json(0, ['msg' => '请将预约信息填写完整']));
		}
		if (!preg_match("/^1[3456789]\d{9}$/", $data['phone'])) exit(show_json(0, ['msg' => '请填写正确的手机号码']));
		$res = pdo_insert('ewei_reservation', $data);
		if (!$res) exit(show_json(0, ['msg' => '预约失败']));
		exit(show_json(1, ['msg' => '预约成功']));
	}
	
	/**
	 * 预约记录
	 */
	public function record()
	{
		global $_W;
		$list = pdo_getall('ewei_reservation', ['mid' => $_W['mid']]);
		include $this->template();
	}

	/**
	 * 关闭预约
	 */
	public function close()
	{
		global $_GPC;
		global $_W;
		$id = $_GPC['id'];
		$info = pdo_get('ewei_reservation', ['id' => $id]);
		// 当预约记录为已预约状态
		if ($info['status'] == 1) {
			$res = pdo_delete('ewei_reservation', ['id' => $id]);
			if (!$res) exit(show_json(0, ['msg' => '关闭失败']));
			exit(show_json(1, ['msg' => '关闭成功']));
		}
		exit(show_json(0, ['msg' => '当前预约已进行，无法关闭']));
	}

	/**
	 * 反馈
	 */
	public function backFill()
	{
		global $_GPC;
		global $_W;
		$id = $_GPC['id'];
		if (is_post()) {
			$id = $_GPC['id'];
			$price = $_GPC['price'];
			$price = pdo_getcolumn('ewei_reservation', ['id' => $id], 'price');
			if ($price) exit(show_json(1, '已经反馈过，不可再次反馈'));
			if (empty($id) || empty($price)) exit(show_json(0, '操作异常'));
			$res = pdo_update('ewei_reservation', ['price' => $price], ['id' => $id]);
			if (!$res) exit(show_json(0, '反馈失败'));
			exit(show_json(1, '反馈成功'));
		}
		include $this->template();
	}
}

?>