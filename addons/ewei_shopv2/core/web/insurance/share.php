<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Share_EweiShopV2Page extends WebPage
{
    public function main()
    {
        include $this->template();
    }
}