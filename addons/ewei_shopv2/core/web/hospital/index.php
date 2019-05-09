<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}

/**
 * 医院列表管理
 * Class Index_EweiShopV2Page
 */
class Index_EweiShopV2Page extends WebPage
{
	/**
	 * 列表
	 */
	public function main()
	{
		$list = pdo_getall('ewei_hospital');
		include $this->template('hospital/index/index');
	}

	/**
	 * 保存信息
	 */
	public function save()
	{
		global $_GPC;
		$id = $_GPC['id'];
		$data = [
			'name'    => $_GPC['name'],
			'phone'   => $_GPC['phone'],
			'address' => $_GPC['address']
		];
		if (empty($data['name']) || empty($data['phone']) || empty($data['address'])) $this->message('请将信息填写完整');
		if (!preg_match("/^1[3456789]\d{9}$/", $data['phone'])) $this->message('请填写正确的手机号码');
		if (empty($id)) {
			// 添加
			$res = pdo_insert('ewei_hospital', $data);
			if (!$res) $this->message('添加失败');
			$this->message('添加成功', webUrl('hospital/index'));
		} else {
			// 修改
			$res = pdo_update('ewei_hospital', $data, ['id' => $id]);
			if (!$res) $this->message('更新失败');
			$this->message('更新成功', webUrl('hospital/index'));
		}
	}

	/**
	 * 添加
	 */
	public function add()
	{
		include $this->template('hospital/index/post');
	}

	/**
	 * 修改
	 */
	public function edit()
	{
		global $_GPC;
		$item = pdo_get('ewei_hospital', ['id' => $_GPC['id']]);
		include $this->template('hospital/index/post');
	}

	/**
	 * 删除
	 */
	public function del()
	{
		global $_GPC;
		$res = pdo_delete('ewei_hospital', ['id' => $_GPC['id']]);
		if (!$res) $this->message('删除失败');
		show_json(1, array('url' => referer()));
	}
}