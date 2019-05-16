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
        $member = pdo_get('member_wristband', array('mobile' => $_GPC['mobile']));
        $user1 = pdo_getall('wristband_location', array('imei' => $member['imei']), array(), '', 'id desc', array(1));
        $location = $user1[0];
        $user2 = pdo_getall('wristband_health', array('imei' => $member['imei']), array(), '', 'id desc', array(1));
        $health = $user2[0];
        $week_health = pdo_getall('wristband_health', array('imei' => $member['imei']), array(), '', 'id desc', array(7));
        sort($week_health);
        foreach ($week_health as $k=>$v){
            $heartRate[$k] = (int)$v['heartRate'];
            $dbp[$k] = (int)$v['dbp'];
            $sdp[$k] = (int)$v['sdp'];
            $bloodSugar[$k] = (int)$v['bloodSugar'];
            $oxygen[$k] = (int)$v['oxygen'];
        }
        include $this->template();
    }

    public function gainhealth()
    {
        global $_GPC;
        $member = pdo_get('member_wristband', array('mobile' => $_GPC['mobile']));
        $data = $this->requesthealth($member['imei']);
        $data = json_decode($data,true);
        if ($data['code'] == 0000) {
            exit(json_encode(array('code' => 0, 'msg' => '获取成功！')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '网络错误！请稍后重试！')));
    }


    public function location()
    {
        global $_GPC;
        $member = pdo_get('member_wristband', array('mobile' => $_GPC['mobile']));
        $data = $this->requestlocation($member['imei']);
        $data = json_decode($data,true);
        if ($data['code'] == 0000) {
            exit(json_encode(array('code' => 0, 'msg' => '获取成功！')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '网络错误！请稍后重试！')));
    }

    public function requestlocation($imei)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "8080",
            CURLOPT_URL => "http://api.jiai.pro:8080/jiai/location",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => "{\n\"imei\":\"$imei\"\n}",
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Type: application/json",
                "Host: api.jiai.pro:8080",
                "Postman-Token: 23c75434-21d4-4bf1-acbb-7aa44aeed63e,a68977e1-64d5-459a-9963-c3a132694c3c",
                "User-Agent: PostmanRuntime/7.11.0",
                "accept-encoding: gzip, deflate",
                "cache-control: no-cache",
                "content-length: 28",
                "cpid: 424",
                "imei: $imei",
                "key: d0041f5e674aebd6b645fbdca5885644"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return $err;
        } else {
            return $response;
        }

    }
    public function requesthealth($imei)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "8080",
            CURLOPT_URL => "http://api.jiai.pro:8080/jiai/bloodPressure",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => "{\n\"imei\":\"$imei\"\n}",
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Type: application/json",
                "Host: api.jiai.pro:8080",
                "Postman-Token: 23c75434-21d4-4bf1-acbb-7aa44aeed63e,a68977e1-64d5-459a-9963-c3a132694c3c",
                "User-Agent: PostmanRuntime/7.11.0",
                "accept-encoding: gzip, deflate",
                "cache-control: no-cache",
                "content-length: 28",
                "cpid: 424",
                "imei: $imei",
                "key: d0041f5e674aebd6b645fbdca5885644"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return $err;
        } else {

            return $response;
        }
    }
}