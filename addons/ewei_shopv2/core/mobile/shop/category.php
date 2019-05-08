<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Category_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$merchid = intval($_GPC['merchid']);
		$category_set = $_W['shopset']['category'];
		$category_set['advimg'] = tomedia($category_set['advimg']);

		if ($category_set['level'] == -1) {
			$this->message('暂时未开启分类', '', 'error');
		}

		$category = $this->getCategory($category_set['level'], $merchid);
		$set = m('common')->getSysset('category');
		include $this->template();
	}

	protected function getCategory($level, $merchid = 0)
	{
		$level = intval($level);
		$category = m('shop')->getCategory();
		$category_parent = array();
		$category_children = array();
		$category_grandchildren = array();

		if (0 < $merchid) {
			$merch_plugin = p('merch');
			$merch_data = m('common')->getPluginset('merch');
			if ($merch_plugin && $merch_data['is_openmerch']) {
				$is_openmerch = 1;
			}
			else {
				$is_openmerch = 0;
			}

			if ($is_openmerch) {
				$merch_category = $merch_plugin->getSet('merch_category', $merchid);

				if (!empty($merch_category)) {
					if (!empty($category['parent'])) {
						foreach ($category['parent'] as $key => $value) {
							if (array_key_exists($value['id'], $merch_category)) {
								$category['parent'][$key]['enabled'] = $merch_category[$value['id']];
							}
						}
					}

					if (!empty($category['children'])) {
						foreach ($category['children'] as $key => $value) {
							if (!empty($value)) {
								foreach ($value as $k => $v) {
									if (array_key_exists($v['id'], $merch_category)) {
										$category['children'][$key][$k]['enabled'] = $merch_category[$v['id']];
									}
								}
							}
						}
					}
				}
			}
		}

		foreach ($category['parent'] as $value) {
			if ($value['enabled'] == 1) {
				$value['thumb'] = tomedia($value['thumb']);
				$value['advimg'] = tomedia($value['advimg']);
				$category_parent[$value['parentid']][] = $value;
				if (!empty($category['children'][$value['id']]) && 2 <= $level) {
					foreach ($category['children'][$value['id']] as $val) {
						if ($val['enabled'] == 1) {
							$val['thumb'] = tomedia($val['thumb']);
							$val['advimg'] = tomedia($val['advimg']);
							$category_children[$val['parentid']][] = $val;
							if (!empty($category['children'][$val['id']]) && 3 <= $level) {
								foreach ($category['children'][$val['id']] as $v) {
									if ($v['enabled'] == 1) {
										$v['thumb'] = tomedia($v['thumb']);
										$v['advimg'] = tomedia($v['advimg']);
										$category_grandchildren[$v['parentid']][] = $v;
									}
								}
							}
						}
					}
				}
			}
		}

		return array('parent' => $category_parent, 'children' => $category_children, 'grandchildren' => $category_grandchildren);
	}
  	public function pro(){
		global $_W;
		global $_GPC;

		$goods_list = pdo_getall('ewei_shop_goods',array('pcate'=>$_GPC['id'],'status'=>1,'deleted'=>0),array('id','pcate','title','thumb','marketprice'));
		$list = '';
		foreach ($goods_list as $k=>$v){
			$v['thumb'] = "http://jiu.ahlzzn.com/attachment/".$v['thumb'];
			$list .=<<<HEREDOC
 <a class="fui-goods-item" data-goodsid="{$v['id']}"
                   href="./index.php?i=2&amp;c=entry&amp;m=ewei_shopv2&amp;do=mobile&amp;r=goods.detail&amp;id={$v['id']}"
                   data-type="1" data-nocache="true" style="position: relative;">
                    <div class="image" style="background-image: url({$v['thumb']});">
                    </div>
                    <div class="detail">
                        <div class="name" style="color: #262626;">{$v['title']}
                        </div>
                        <div class="price buy">
                                    <span class="text" style="color: #ed2822;">
                                        <p class="minprice">{$v['marketprice']}</p>
                                    </span>
                            <span class="buy buybtn-1" style="border-color: #fe5455;color:white">购买</span>
                        </div>
                    </div>
                </a>
HEREDOC;

		}
		if (count($goods_list) > 0){
			exit(json_encode(array('code'=>0,'list'=>$list,'count'=>count($goods_list))));
		}
		exit(json_encode(array('code'=>1)));

	}
}

?>
