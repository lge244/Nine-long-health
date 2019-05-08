<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Index_EweiShopV2Page extends MobileLoginPage
{
    public function main()
    {
        include $this->template();
    }

    public function add()
    {
        global $_W;
        global $_GPC;
        $diyform_data = $this->diyformData();
        extract($diyform_data);
        $returnurl = urldecode(trim($_GPC['returnurl']));
        $member = $this->member;
        $wapset = m('common')->getSysset('wap');
        $area_set = m('util')->get_area_config_set();
        $new_area = intval($area_set['new_area']);
        $show_data = 1;
        if (!empty($new_area) && empty($member['datavalue']) || empty($new_area) && !empty($member['datavalue'])) {
            $show_data = 0;
        }

        $area_set = m('util')->get_area_config_set();
        $new_area2 = intval($area_set['new_area']);
        $address_street = intval($area_set['address_street']);
        $pindex = intval($_GPC['page']);
        $psize = 20;
        $condition = ' and openid=:openid and deleted=0 and  `uniacid` = :uniacid  ';
        $params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
        $sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_member_address') . (' where 1 ' . $condition);
        $total = pdo_fetchcolumn($sql, $params);
        $sql = 'SELECT * FROM ' . tablename('ewei_shop_member_address') . ' where 1 ' . $condition . ' ORDER BY `id` DESC';

        if ($pindex != 0) {
            $sql .= 'LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
        }

        $list = pdo_fetchall($sql, $params);
        include $this->template();
    }

    public function post()
    {
        global $_W;
        global $_GPC;

        $data['creation_time'] = time();
        $data['birthday'] = strtotime($_GPC['birthday']);
        $data['uid'] = $_W['ewei_shopv2_member']['id'];
        $data['address'] = $_GPC['areas'] . $_GPC['site'];
        $data['phone'] = $_GPC['phone'];
        $data['username'] = $_GPC['username'];
        $res = pdo_insert('eweu_shop_insurance', $data);
        if ($res) {
            exit(json_encode(array('code' => 0, 'msg' => '保单提交成功！请等待客户联系！')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '网络错误！请稍后重试！')));

    }

    public function record()
    {
        global $_W;
        global $_GPC;

        $insurance = pdo_getall('ewei_shop_insurance', array('uid' => $_W['ewei_shopv2_member']['id'], 'status !=' => 3));
        include $this->template();
    }

    public function backfill()
    {


        include $this->template();
    }

    public function dobackfill()
    {
        global $_W;
        global $_GPC;

        $a = pdo_update('ewei_shop_insurance', array('price' => $_GPC['price']), array('id' => $_GPC['id']));

        if ($a) {
            exit(json_encode(array('code' => 0, 'msg' => '金额回填成功！')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '网络错误！请稍后重试！')));
    }

    public function close()
    {
        global $_W;
        global $_GPC;
        $insurance = pdo_get('ewei_shop_insurance', array('id' => $_GPC['id']));
        if ($insurance['status'] == 2) {
            exit(json_encode(array('code' => 1, 'msg' => '保单已生效！无法关闭~')));
        }
        $a = pdo_update('ewei_shop_insurance', array('status' => 3), array('id' => $_GPC['id']));
        if ($a) {
            exit(json_encode(array('code' => 0, 'msg' => '保单已关闭！')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '网络错误！请稍后重试！')));
    }
}