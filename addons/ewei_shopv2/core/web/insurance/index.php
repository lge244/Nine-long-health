<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $insurance = pdo_getall('ewei_shop_insurance');
        foreach ($insurance as $k => $v) {
            $insurance[$k]['member'] = pdo_get('ewei_shop_member', array('id' => $v['uid']), 'nickname');
        }
        include $this->template();
    }

    public function relation()
    {
        global $_W;
        global $_GPC;

        $insurance = pdo_get('ewei_shop_insurance', array('id' => $_GPC['id']));
        if ($insurance['status'] == 2 || $insurance['status'] == 3) {
            exit(json_encode(array('code' => 1, 'msg' => '保单已生效！')));
        }
        $a = pdo_update('ewei_shop_insurance', array('status' => 1), array('id' => $_GPC['id']));

        if ($a) {
            exit(json_encode(array('code' => 0, 'msg' => '联系成功！')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '网络错误！请稍后重试！')));
    }

    public function insure()
    {
        global $_W;
        global $_GPC;
        $insurance = pdo_get('ewei_shop_insurance', array('id' => $_GPC['id']));
        if (!empty($insurance['price'])) {
            exit(json_encode(array('code' => 1, 'msg' => '保单已生效！')));
        }
        $a = pdo_update('ewei_shop_insurance', array('status' => 2), array('id' => $_GPC['id']));

        if ($a) {
            exit(json_encode(array('code' => 0, 'msg' => '交易成功！')));
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
            exit(json_encode(array('code' => 0, 'msg' => '关闭成功！')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '网络错误！请稍后重试！')));
    }

    public function confirm()
    {
        global $_W;
        global $_GPC;
        $insurance = pdo_get('ewei_shop_insurance', array('id' => $_GPC['id']));
        if ($insurance['status'] == 2) {
            exit(json_encode(array('code' => 1, 'msg' => '保单已生效！无法关闭~')));
        }
        $a = pdo_update('ewei_shop_insurance', array('status' => 3), array('id' => $_GPC['id']));

        if ($a) {
            exit(json_encode(array('code' => 0, 'msg' => '关闭成功！')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '网络错误！请稍后重试！')));
    }

}