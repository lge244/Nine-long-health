<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $fitness = pdo_getall('ewei_shop_fitness');
        foreach ($fitness as $k => $v) {
            $fitness[$k]['member'] = pdo_get('ewei_shop_member', array('openid' => $v['openid']));
        }
        include $this->template();
    }

    public function health()
    {
        global $_W;
        global $_GPC;

        include $this->template();
    }
}