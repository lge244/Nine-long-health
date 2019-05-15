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
		$info = pdo_get('ewei_hospital_divided');
		include $this->template('hospital/divided/index');
	}

	/**
	 * 保存信息
	 */
	public function save()
	{
		global $_GPC;
		$data = [
			'manager'     => $_GPC['manager'],
			'recommender' => $_GPC['recommender'],
		];
		$id = $_GPC['divided_id'];
		if (empty($data['manager']) || empty($data['recommender'])) {
			exit(show_json(0,'请将信息填写完整'));
		}
		$res = pdo_update('ewei_hospital_divided', $data, ['id' => $id]);
		if (!$res) exit(show_json(0,'更新失败'));
		exit(show_json(1,'更新成功'));
	}
}