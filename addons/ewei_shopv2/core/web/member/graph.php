<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Graph_EweiShopV2Page extends WebPage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        @$uid = $_GPC['id'];
        if (!$uid){
            $list = pdo_getall('ewei_shop_member',array('fid'=>0,'mobile !=' =>''),array('id','fid','level','nickname'));
            $list_arr = array_chunk($list,9);
        }else{
            $list = pdo_getall('ewei_shop_member',array('fid'=>$uid,'mobile !=' =>'','level >='=>1),array('id','fid','level','nickname'));
            $list_arr = array_chunk($list,9);
        }

        include $this->template();
    }
}