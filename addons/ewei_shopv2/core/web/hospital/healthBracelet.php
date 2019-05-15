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
		if (is_ajax()) {

		}
		include $this->template('hospital/health_bracelet/index');
	}

	public function health()
	{
				
	}
}