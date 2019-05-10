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
        if ($insurance['status'] == 2 || $insurance['status'] == 4) {
            exit(json_encode(array('code' => 1, 'msg' => '保单已生效！')));
        }
        if ($insurance['status'] == 3 ){
            exit(json_encode(array('code' => 1, 'msg' => '保单已关闭！无需再联系！')));
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
        if (!empty($insurance['price']) || $insurance['status'] == 2 || $insurance['status'] == 4) {
            exit(json_encode(array('code' => 1, 'msg' => '保单已生效！')));
        }
        if ($insurance['status'] == 3 ){
            exit(json_encode(array('code' => 1, 'msg' => '保单已关闭！无需再联系！')));
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
        if ($insurance['status'] == 2 ||$insurance['status'] == 3 ||!empty($insurance['price'])) {
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
        if (empty($insurance['price']) || $insurance['status'] == 3) {
            exit(json_encode(array('code' => 1, 'msg' => '保单金额不能为空')));
        }
        if ($insurance['status'] == 4){
            exit(json_encode(array('code' => 1, 'msg' => '保单已经完成！请勿重复审核')));
        }
        $a = pdo_update('ewei_shop_insurance', array('status' => 4), array('id' => $_GPC['id']));

        if($a){
            $share = pdo_get('ewei_insurance_share');
            $member = pdo_get('ewei_shop_member',array('id'=>$insurance['uid']));
            if($member['fid'] >0) {
                $f_member = pdo_get('ewei_shop_member', array('id' => $member['fid']), array('id', 'level', 'invite', 'brokerage', 'fid'));
                if ($f_member['level'] >= 5) {
                    $custodian = ($share['custodian_ratio'] / 100)*$insurance['price'];
                    $referrer = ($share['referrer_ratio'] / 100)*$insurance['price'];
                    $brokerage = $f_member['brokerage'] + $custodian+$referrer;

                    $a = pdo_update('ewei_shop_member', array( 'brokerage' => $brokerage), array('id' => $member['fid']));
                } else {
                    $referrer = ($share['referrer_ratio'] / 100)*$insurance['price'];
                    $brokerage = $f_member['brokerage'] + $referrer;

                    $a = pdo_update('ewei_shop_member', array( 'brokerage' => $brokerage), array('id' => $member['fid']));
                    if ($f_member['level'] < 5) {
                        $this->acquire($f_member,$insurance,$share);
                    }
                }
            }
        }
        if ($a) {
            exit(json_encode(array('code' => 0, 'msg' => '完成保单！')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '网络错误！请稍后重试！')));
    }

    public function acquire($fid,$in,$sha)
    {
        // 判断父类中是否有上级
        if ($fid['fid'] > 0) {
            // 获取父类上的上级
            $f_f_member = pdo_get('ewei_shop_member', array('id' => $fid['fid']), array('id', 'level', 'invite', 'brokerage', 'fid'));
            // 计算父类上级的推荐人数

            // 判断父类的上级是否为管理人
            if ($f_f_member['level'] >= 5) {
                $custodian = ($sha['custodian_ratio'] / 100)*$in['price'];
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
                $this->acquire($fid,$in,$sha);
            }
        } else {
            // 获取父类上的上级
            $f_f_member = pdo_get('ewei_shop_member', array('id' => $fid['fid']), array('id', 'level', 'invite', 'brokerage', 'fid', ''));

            // 判断父类的上级是否为管理人
            if ($f_f_member['level'] >= 5) {
                // 是管理员就 +100 元的推荐佣金
                $custodian = ($sha['custodian_ratio'] / 100)*$in['price'];
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