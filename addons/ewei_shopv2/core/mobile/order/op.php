<?php
if (!defined("IN_IA")) {
    exit("Access Denied");
}


class Op_EweiShopV2Page extends MobileLoginPage
{
    /**
     * 取消订单
     * @global type $_W
     * @global type $_GPC
     */

    public function cancel()
    {
        global $_W;
        global $_GPC;
        $orderid = intval($_GPC["id"]);
        $order = pdo_fetch("select id,ordersn,openid,status,deductcredit,deductcredit2,deductprice,couponid,isparent,`virtual`,`virtual_info`,merchid from " . tablename("ewei_shop_order") . " where id=:id and uniacid=:uniacid and openid=:openid limit 1", array(":id" => $orderid, ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"]));
        if (empty($order)) {
            show_json(0, "订单未找到");
        }

        if (0 < $order["status"]) {
            show_json(0, "订单已支付，不能取消!");
        }

        if ($order["status"] < 0) {
            show_json(0, "订单已经取消!");
        }

        if (!empty($order["virtual"]) && $order["virtual"] != 0) {
            $goodsid = pdo_fetch("SELECT goodsid FROM " . tablename("ewei_shop_order_goods") . " WHERE uniacid = " . $_W["uniacid"] . " AND orderid = " . $order["id"]);
            $typeid = $order["virtual"];
            $vkdata = ltrim($order["virtual_info"], "[");
            $vkdata = rtrim($vkdata, "]");
            $arr = explode("}", $vkdata);
            foreach ($arr as $k => $v) {
                if (!$v) {
                    unset($arr[$k]);
                }

            }
            $vkeynum = count($arr);
            pdo_query("update " . tablename("ewei_shop_virtual_data") . " set openid=\"\",usetime=0,orderid=0,ordersn=\"\",price=0,merchid=" . $order["merchid"] . " where typeid=" . intval($typeid) . " and orderid = " . $order["id"]);
            pdo_query("update " . tablename("ewei_shop_virtual_type") . " set usedata=usedata-" . $vkeynum . " where id=" . intval($typeid));
        }

        m("order")->setStocksAndCredits($orderid, 2);
        if (0 < $order["deductprice"]) {
            m("member")->setCredit($order["openid"], "credit1", $order["deductcredit"], array("0", $_W["shopset"]["shop"]["name"] . "购物返还抵扣积分 积分: " . $order["deductcredit"] . " 抵扣金额: " . $order["deductprice"] . " 订单号: " . $order["ordersn"]));
        }

        m("order")->setDeductCredit2($order);
        if (com("coupon") && !empty($order["couponid"])) {
            com("coupon")->returnConsumeCoupon($orderid);
        }

        pdo_update("ewei_shop_order", array("status" => -1, "canceltime" => time(), "closereason" => trim($_GPC["remark"])), array("id" => $order["id"], "uniacid" => $_W["uniacid"]));
        if (!empty($order["isparent"])) {
            pdo_update("ewei_shop_order", array("status" => -1, "canceltime" => time(), "closereason" => trim($_GPC["remark"])), array("parentid" => $order["id"], "uniacid" => $_W["uniacid"]));
        }

        m("notice")->sendOrderMessage($orderid);
        show_json(1);
    }

    /**
     * 确认收货
     * @global type $_W
     * @global type $_GPC
     */

    public function finish()
    {
        global $_W;
        global $_GPC;
        $orderid = intval($_GPC["id"]);

        $order = pdo_fetch("select id,status,openid,couponid,price,refundstate,refundid,ordersn,price from " . tablename("ewei_shop_order") . " where id=:id and uniacid=:uniacid and openid=:openid limit 1", array(":id" => $orderid, ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"]));
        $goods = pdo_getall('ewei_shop_order_goods', array('orderid' => $order['id']), array('goodsid', 'total'));
        $imei = 0;
        if (!isset($_GPC['imei'])) {

            foreach ($goods as $k => $v) {
                $goods_list = pdo_get('ewei_shop_goods', array('id' => $v['goodsid']));
                if ($goods_list['pcate'] == 1181) {
                    $imei = $v['total'];
                }
            }
        } else {
            $imei2 = $_GPC['imei'];
            for ($i = 0; $i <= count($imei2) - 1; $i++) {
                $data['openid'] = $_W['ewei_shopv2_member']['openid'];
                $data['mobile'] = $_W['ewei_shopv2_member']['mobile'];
                $data['imei'] = $imei2[$i];
                $data['orderid'] = $orderid;
                pdo_insert('member_wristband', $data);
                unset($data);
            }

        }
        if ($imei > 0) {
            exit(json_encode(array('status' => 2, 'msg' => '手环必须要填写串号才能确定收货', 'num' => $imei)));
        }
        if (empty($order)) {
            show_json(0, "订单未找到");
        }

        if ($order["status"] != 2) {
            show_json(0, "订单不能确认收货");
        }

        if (0 < $order["refundstate"] && !empty($order["refundid"])) {
            $change_refund = array();
            $change_refund["status"] = -2;
            $change_refund["refundtime"] = time();
            pdo_update("ewei_shop_order_refund", $change_refund, array("id" => $order["refundid"], "uniacid" => $_W["uniacid"]));
        }
        pdo_update("ewei_shop_order", array("status" => 3, "finishtime" => time(), "refundstate" => 0), array("id" => $order["id"], "uniacid" => $_W["uniacid"]));

        $goods = pdo_getall('ewei_shop_order_goods', array('orderid' => $order['id']), array('goodsid', 'total'));
        foreach ($goods as $k => $v) {
            $goods_list = pdo_get('ewei_shop_goods', array('id' => $v['goodsid']));
            if ($goods_list['pcate'] == 1182) {
                $data['openid'] = $order['openid'];
                $data['schooltime'] = time();
                $data['goodsid'] = $goods_list['id'];
                $data['title'] = $goods_list['title'];
                $data['status'] = 0;
                for ($i = 1; $i <= $v['total']; $i++) {
                    pdo_insert('ewei_shop_curriculum', $data);
                }
            }
            if ($goods_list['pcate'] == 1176) {
                $data['openid'] = $order['openid'];
                $data['schooltime'] = time();
                $data['goodsid'] = $goods_list['id'];
                $data['title'] = $goods_list['title'];
                $data['status'] = 0;
                for ($i = 1; $i <= $v['total']; $i++) {
                    pdo_insert('ewei_shop_fitness', $data);
                }
            }
            if ($goods_list['pcate'] == 1181) {
                pdo_update('ewei_shop_fitness', array('status' => 1), array('openid' => $order['openid']));
            }
            if ($goods_list['upgrade'] == 0) {
                $upgrade = 1;
            }

        }

        $order = pdo_getall('ewei_shop_order', array("openid" => $_W['openid'], "status" => 3), array('id'));
        $order_Num = 0;
        foreach ($order as $k => $v) {
            $orderNum = pdo_getall('ewei_shop_order_goods', array('orderid' => $v['id']), array('total'));
            foreach ($orderNum as $key => $value) {
                $order_Num += $value['total'];
            }
        }
        $curriculum = count(pdo_getall('ewei_shop_curriculum', array('status' => 1, 'openid' => $_W['openid'])));

        if ($order_Num >= 2 && $_W['ewei_shopv2_member']['level'] == 0 && $curriculum >= 2 && $upgrade >= 1) {
            if ($_W['ewei_shopv2_member']['fid'] > 0) {
                $f_member = pdo_get('ewei_shop_member', array('id' => $_W['ewei_shopv2_member']['fid']), array('id', 'level', 'invite', 'brokerage', 'fid'));
                if ($f_member['level'] >= 5) {
                    $invite = $f_member['invite'] + 1;
                    $brokerage = $f_member['brokerage'] + 200;
                    pdo_update('ewei_shop_member', array('level' => 1), array('id' => $_W['ewei_shopv2_member']['id']));
                    $a = pdo_update('ewei_shop_member', array('invite' => $invite, 'brokerage' => $brokerage), array('id' => $_W['ewei_shopv2_member']['fid']));
                } else {
                    $invite = $f_member['invite'] + 1;
                    $brokerage = $f_member['brokerage'] + 100;
                    pdo_update('ewei_shop_member', array('level' => 1), array('id' => $_W['ewei_shopv2_member']['id']));
                    $a = pdo_update('ewei_shop_member', array('invite' => $invite, 'brokerage' => $brokerage), array('id' => $_W['ewei_shopv2_member']['fid']));
                    if ($f_member['level'] < 5) {
                        $this->acquire($f_member);
                    }
                }
            } else {
                pdo_update('ewei_shop_member', array('level' => 1), array('id' => $_W['ewei_shopv2_member']['id']));
            }
        }

        m("order")->setStocksAndCredits($orderid, 3);
        m("order")->fullback($orderid);
        m("member")->upgradeLevel($order["openid"], $orderid);
        m("order")->setGiveBalance($orderid, 1);
        if (com("coupon")) {
            $refurnid = com("coupon")->sendcouponsbytask($orderid);
        }

        if (com("coupon") && !empty($order["couponid"])) {
            com("coupon")->backConsumeCoupon($orderid);
        }

        m("notice")->sendOrderMessage($orderid);
        com_run("printer::sendOrderMessage", $orderid);
        if (p("lineup")) {
            p("lineup")->checkOrder($order);
        }

        if (p("commission")) {
            p("commission")->checkOrderFinish($orderid);
        }

        if (p("lottery")) {
            $res = p("lottery")->getLottery($_W["openid"], 1, array("money" => $order["price"], "paytype" => 2));
            if ($res) {
                p("lottery")->getLotteryList($_W["openid"], array("lottery_id" => $res));
            }

        }

        if (p("task")) {
            p("task")->checkTaskProgress($order["price"], "order_full", "", $order["openid"]);
        }

        show_json(1, array("url" => mobileUrl("order", array("status" => 3))));
    }

    /**
     * 删除或恢复订单
     * @global type $_W
     * @global type $_GPC
     */

    public function delete()
    {
        global $_W;
        global $_GPC;
        $orderid = intval($_GPC["id"]);
        $userdeleted = intval($_GPC["userdeleted"]);
        $order = pdo_fetch("select id,status,refundstate,refundid from " . tablename("ewei_shop_order") . " where id=:id and uniacid=:uniacid and openid=:openid limit 1", array(":id" => $orderid, ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"]));
        if (empty($order)) {
            show_json(0, "订单未找到!");
        }

        if ($userdeleted == 0) {
            if ($order["status"] != 3) {
                show_json(0, "无法恢复");
            }

        } else {
            if ($order["status"] != 3 && $order["status"] != -1) {
                show_json(0, "无法删除");
            }

            if (0 < $order["refundstate"] && !empty($order["refundid"])) {
                $change_refund = array();
                $change_refund["status"] = -2;
                $change_refund["refundtime"] = time();
                pdo_update("ewei_shop_order_refund", $change_refund, array("id" => $order["refundid"], "uniacid" => $_W["uniacid"]));
            }

        }

        pdo_update("ewei_shop_order", array("userdeleted" => $userdeleted, "refundstate" => 0), array("id" => $order["id"], "uniacid" => $_W["uniacid"]));
        show_json(1);
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


