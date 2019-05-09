<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}

class Reservation_EweiShopV2Page extends WebPage
{
	public function main()
	{
		$list = pdo_fetchall("select a.*,b.name as hospital_name from `ims_ewei_reservation` a LEFT JOIN `ims_ewei_hospital` b ON a.hospital_id = b.id");
		include $this->template('hospital/reservation/index');
	}

	public function edit()
	{
		global $_GPC;
		$id = $_GPC['id'];
		$status = $_GPC['status'];
		if ($status >= 1 && $status < 4) {
			$res = pdo_update('ewei_reservation',['status' => $status + 1], ['id' => $id]);
			if (!$res) show_json(0, '修改失败');
			show_json(1, '修改成功');
		}
	}
}

?>