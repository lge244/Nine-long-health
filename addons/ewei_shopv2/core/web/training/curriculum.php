<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Curriculum_EweiShopV2Page extends WebPage
{
    public function main()
    {

        include $this->template();
    }
}