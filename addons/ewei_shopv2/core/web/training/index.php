<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
    public function main()
    {

        $member = pdo_getall('ewei_shop_curriculum');
        foreach ($member as $k=>$v){
            $member[$k]['member'] = pdo_get('ewei_shop_member',array('openid'=>$v['openid']));
        }

        include $this->template();
    }

    public function add(){
        $member = pdo_getall('ewei_shop_member',array('mobile !='=> ''),array('id','openid','nickname'));
        $goods = pdo_getall('ewei_shop_goods',array('pcate'=>1182),array('id','title'));
        include($this->template());
    }

    public function post()
    {
        global $_W;
        global $_GPC;
        $data=[];
       $data['openid'] = $_GPC['openid'];
       $data['goodsid'] = $_GPC['goodsid'];
       $data['title'] = $_GPC['title'];
       $data['status'] = $_GPC['status'];
       $data['schooltime'] = time();
       $res = pdo_insert('ewei_shop_curriculum',$data);
       $id = pdo_insertid();
       if ($data['status'] == 1){
           $curriculums = pdo_get('ewei_shop_curriculum',array('id'=>$id));

           $member = pdo_get('ewei_shop_member',array('openid'=>$curriculums['openid']));

           $order= pdo_getall('ewei_shop_order', array( "openid" => $curriculums['openid'],"status"=>3), array('id'));
           $order_Num = 0;
           foreach ($order as $k=>$v){
               $orderNum = pdo_getall('ewei_shop_order_goods',array('orderid'=>$v['id']),array('total'));
               foreach ($orderNum as $key=>$value){
                   $order_Num +=$value['total'];
               }
           }
           $goods = pdo_getall('ewei_shop_order_goods',array('openid'=>$curriculums['openid']),array('goodsid','total'));
           foreach ($goods as $k=>$v){
               $goods_list = pdo_get('ewei_shop_goods',array('id'=>$v['goodsid']));
               if ($goods_list['upgrade'] == 0){
                   $upgrade = 1;
               }
           }

           $curriculum = count(pdo_getall('ewei_shop_curriculum',array('status'=>1,'openid'=>$curriculums['openid'])));

           if ($order_Num >= 2 && $member['level'] == 0 && $curriculum >= 2 && $upgrade >= 1) {
               if($member['fid'] >0){
                   $f_member = pdo_get('ewei_shop_member', array('id' => $member['fid']), array('id', 'level', 'invite', 'brokerage', 'fid'));
                   if($f_member['level'] >= 5 ){
                       $invite = $f_member['invite'] + 1;
                       $brokerage = $f_member['brokerage'] + 200;
                       pdo_update('ewei_shop_member', array('level' => 1), array('id' => $member['id']));
                       $a = pdo_update('ewei_shop_member', array('invite' => $invite, 'brokerage' => $brokerage), array('id' => $member['fid']));
                   }else{
                       $invite = $f_member['invite'] + 1;
                       $brokerage = $f_member['brokerage'] + 100;
                       pdo_update('ewei_shop_member', array('level' => 1), array('id' => $member['id']));
                       $a = pdo_update('ewei_shop_member', array('invite' => $invite, 'brokerage' => $brokerage), array('id' => $member['fid']));
                       if ($f_member['level'] < 5) {
                           $this->acquire($f_member);
                       }
                   }
               }else{
                   pdo_update('ewei_shop_member', array('level' => 1), array('id' => $member['id']));
               }
           }

       }
       if ($res){
           exit(json_encode(array('code'=>0,'msg'=>'添加成功')));
       }
        exit(json_encode(array('code'=>1,'msg'=>'添加失败')));
    }


    public function pass()
    {
        global $_W;
        global $_GPC;
        $id = $_GPC['id'];

        $a = pdo_update('ewei_shop_curriculum',array('status'=>'1'),array('id'=>$id));
        $curriculums = pdo_get('ewei_shop_curriculum',array('id'=>$id));

        $member = pdo_get('ewei_shop_member',array('openid'=>$curriculums['openid']));

        $order= pdo_getall('ewei_shop_order', array( "openid" => $curriculums['openid'],"status"=>3), array('id'));
        $order_Num = 0;
        foreach ($order as $k=>$v){
            $orderNum = pdo_getall('ewei_shop_order_goods',array('orderid'=>$v['id']),array('total'));
            foreach ($orderNum as $key=>$value){
                $order_Num +=$value['total'];
            }
        }
        $goods = pdo_getall('ewei_shop_order_goods',array('openid'=>$curriculums['openid']),array('goodsid','total'));
        foreach ($goods as $k=>$v){
            $goods_list = pdo_get('ewei_shop_goods',array('id'=>$v['goodsid']));
            if ($goods_list['upgrade'] == 0){
                $upgrade = 1;
            }

        }

        $curriculum = count(pdo_getall('ewei_shop_curriculum',array('status'=>1,'openid'=>$curriculums['openid'])));

        if ($order_Num >= 2 && $member['level'] == 0 && $curriculum >= 2 && $upgrade >= 1) {
            if($member['fid'] >0){
                $f_member = pdo_get('ewei_shop_member', array('id' => $member['fid']), array('id', 'level', 'invite', 'brokerage', 'fid'));
                if($f_member['level'] >= 5 ){
                    $invite = $f_member['invite'] + 1;
                    $brokerage = $f_member['brokerage'] + 200;
                    pdo_update('ewei_shop_member', array('level' => 1), array('id' => $member['id']));
                    $a = pdo_update('ewei_shop_member', array('invite' => $invite, 'brokerage' => $brokerage), array('id' => $member['fid']));
                }else{
                    $invite = $f_member['invite'] + 1;
                    $brokerage = $f_member['brokerage'] + 100;
                    pdo_update('ewei_shop_member', array('level' => 1), array('id' => $member['id']));
                    $a = pdo_update('ewei_shop_member', array('invite' => $invite, 'brokerage' => $brokerage), array('id' => $member['fid']));
                    if ($f_member['level'] < 5) {
                        $this->acquire($f_member);
                    }
                }
            }else{
                pdo_update('ewei_shop_member', array('level' => 1), array('id' => $member['id']));
            }
        }

        if ($a){
            exit(json_encode(array('code'=>0,'msg'=>'通过成功')));
        }
        exit(json_encode(array('code'=>1,'msg'=>'网络错误！通过失败')));

    }
    /**
     * 计算上级直到第一个管理人
     * @param $fid  父类的信息
     */
    public function acquire($fid)
    {
        // 判断父类中是否有上级
        if ($fid['fid'] > 0) {
            // 获取父类上的上级
            $f_f_member = pdo_get('ewei_shop_member', array('id' => $fid['fid']), array('id', 'level', 'invite', 'brokerage', 'fid'));
            // 计算父类上级的推荐人数
            $invite = $f_f_member['invite'] + 1;
            // 判断父类的上级是否为管理人
            if ($f_f_member['level'] >= 5) {
                // 是管理员就 +100 元的推荐佣金
                $brokerage = $f_f_member['brokerage'] + 100;
            } else {
                // 不是就不加
                $brokerage = $f_f_member['brokerage'];
            }
            // 更新操作
            $a = pdo_update('ewei_shop_member', array('invite' => $invite, 'brokerage' => $brokerage), array('id' => $fid['fid']));
            // 判断更新操作是否成功  并且 当前父类的上级是否存在上级  并且 当前父类的上级是否为管理人
            if ($a && $f_f_member['fid'] > 0 && $f_f_member['level'] < 5) {
                $fid = $f_f_member;
                $this->acquire($fid);
            }
        } else {
            // 获取父类上的上级
            $f_f_member = pdo_get('ewei_shop_member', array('id' => $fid['fid']), array('id', 'level', 'invite', 'brokerage', 'fid', ''));
            // 计算父类上级的推荐人数
            $invite = $f_f_member['invite'] + 1;
            // 判断父类的上级是否为管理人
            if ($f_f_member['level'] >= 5) {
                // 是管理员就 +100 元的推荐佣金
                $brokerage = $f_f_member['brokerage'] + 100;
            } else {
                // 不是就不加
                $brokerage = $f_f_member['brokerage'];
            }
            // 更新操作
            $a = pdo_update('ewei_shop_member', array('invite' => $invite, 'brokerage' => $brokerage), array('id' => $fid['fid']));
        }
    }



}