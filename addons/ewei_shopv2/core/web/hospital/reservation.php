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
		$reservation = pdo_get('ewei_reservation', ['id' => $id]);
		if ($status >= 1 && $status < 3) {
			$res = pdo_update('ewei_reservation', ['status' => $status + 1], ['id' => $id]);
			if (!$res) show_json(0, '修改失败');
			show_json(1, '修改成功');
		}
		if ($status == 3) {
			$res = pdo_update('ewei_reservation', ['status' => $status + 1], ['id' => $id]);
			if (!$res) show_json(0, '修改失败');
			if ($res) {
				$divided = pdo_get('ewei_hospital_divided', ['id' => 1]);
				$member = pdo_get('ewei_shop_member', ['id' => $reservation['mid']]);
				if ($member['fid'] > 0) {
					$f_member = pdo_get('ewei_shop_member', array('id' => $member['fid']), array('id', 'level', 'invite', 'brokerage', 'fid'));
					if ($f_member['level'] >= 5) {
						$custodian = ($divided['manager'] / 100) * $reservation['price'];
						$referrer = ($divided['recommender'] / 100) * $reservation['price'];
						$brokerage = $f_member['brokerage'] + $custodian + $referrer;
						$a = pdo_update('ewei_shop_member', array('brokerage' => $brokerage), array('id' => $member['fid']));
					} else {
						$referrer = ($divided['recommender'] / 100) * $reservation['price'];
						$brokerage = $f_member['brokerage'] + $referrer;
						$a = pdo_update('ewei_shop_member', array('brokerage' => $brokerage), array('id' => $member['fid']));
						if ($f_member['level'] < 5) {
							$this->acquire($f_member, $reservation, $divided);
						}
					}
				}
			}
			show_json(1, '修改成功');
		}
	}

	public function acquire($fid, $in, $sha)
	{
		// 判断父类中是否有上级
		if ($fid['fid'] > 0) {
			// 获取父类上的上级
			$f_f_member = pdo_get('ewei_shop_member', array('id' => $fid['fid']), array('id', 'level', 'invite', 'brokerage', 'fid'));
			// 计算父类上级的推荐人数

			// 判断父类的上级是否为管理人
			if ($f_f_member['level'] >= 5) {
				$custodian = ($sha['manager'] / 100) * $in['price'];
				$brokerage = $f_f_member['brokerage'] + $custodian;
			} else {
				// 不是就不加
				$brokerage = $f_f_member['brokerage'];
			}
			// 更新操作
			$a = pdo_update('ewei_shop_member', array('brokerage' => $brokerage), array('id' => $fid['fid']));
			// 判断更新操作是否成功  并且 当前父类的上级是否存在上级  并且 当前父类的上级是否为管理人
			if ($f_f_member['fid'] > 0 && $f_f_member['level'] < 5) {
				$fid = $f_f_member;
				$this->acquire($fid, $in, $sha);
			}
		} else {
			// 获取父类上的上级
			$f_f_member = pdo_get('ewei_shop_member', array('id' => $fid['fid']), array('id', 'level', 'invite', 'brokerage', 'fid', ''));

			// 判断父类的上级是否为管理人
			if ($f_f_member['level'] >= 5) {
				// 是管理员就 +100 元的推荐佣金
				$custodian = ($sha['manager'] / 100) * $in['price'];
				$brokerage = $f_f_member['brokerage'] + $custodian;
			} else {
				// 不是就不加
				$brokerage = $f_f_member['brokerage'];
			}
			// 更新操作
			$a = pdo_update('ewei_shop_member', array('brokerage' => $brokerage), array('id' => $fid['fid']));
		}
	}
}

?>