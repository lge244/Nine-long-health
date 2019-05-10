<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .on {
        background: #fff;
        position: relative;
        color: #ff5555;
        font-size: .65rem;
    }
</style>
<script>
    document.documentElement.style.fontSize = document.documentElement.clientWidth / 750 * 40 + "px";
</script>
<div class="fui-page fui-page-current page-shop-goods_category">
    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title">
            <form method="post" action="<?php  echo mobileUrl('goods')?>">
                <div class="searchbar">
                    <div class="search-input">
                        <i class="icon icon-search"></i>
                        <input type="search" name="keywords" placeholder="输入关键字...">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="fui-content navbar">
        <div class="fui-fullHigh-group">
            <?php  if($category_set['level']!=1) { ?>
            <div class="fui-fullHigh-item menu" id="tab">
                <nav data-src="<?php  echo $category_set['advimg'];?>" data-href="<?php  echo $category_set['advurl'];?>"
                     class="pro on">推荐分类
                </nav>
                <?php  if(is_array($category['parent']['0'])) { foreach($category['parent']['0'] as $value) { ?>
                <nav data-cate="<?php  echo $value['id'];?>" data-src="<?php  echo $value['advimg'];?>" data-href="<?php  echo $value['advurl'];?>"
                     class="pro"><?php  echo $value['name'];?>
                </nav>
                <?php  } } ?>
            </div>
            <?php  } ?>
            <div class="fui-fullHigh-item container" style="position: relative">

            </div>

        </div>
    </div>
</div>

<script>
    $('.pro').click(function () {
        var cateid = $(this).attr('data-cate');
        if ($('.on')) {
            $('.on').removeClass('on');
            $(this).addClass('on')
        }
        var a = $(".container").children("a").length;
        if (a > 0){
            $(".container").empty();
        }
        $.post("<?php  echo mobileUrl('shop/category/pro')?>", {id: cateid}, function (res) {
            $('.container').append(res.list);
        },'json')

    })

</script>


<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>