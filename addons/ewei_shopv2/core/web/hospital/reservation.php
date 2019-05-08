<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
	public function main()
	{
		echo 1;
		include $this->template('web/hospital/index/index');
	}

	public function save()
	{
		
	}
	
	public function add()
	{
		
	}

	public function edit()
	{
		
	}

	public function del()
	{
		
	}
}

?>