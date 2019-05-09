<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Share_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $ratio = pdo_get('ewei_insurance_share');
        include $this->template();
    }

    public function add()
    {
        global $_GPC;

        $data['custodian_ratio'] = (int)$_GPC['custodian_ratio'];
        $data['referrer_ratio'] = (int)$_GPC['referrer_ratio'];
        $res = pdo_update('ewei_insurance_share',$data);
        if($res){
            exit(json_encode(array('code'=>0,'msg'=>"分润比例保存成功")));
        }
        exit(json_encode(array('code'=>1,'msg'=>"网络错误！请稍后重试")));
    }
}