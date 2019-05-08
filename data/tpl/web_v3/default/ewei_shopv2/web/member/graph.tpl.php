<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>



<style type="text/css">


    ul{
        text-decoration: none;
        list-style-type: none;
    }
    .video_list>li{
        float: left;
        width: 32%;
        text-align: center;
        border: 1px solid #ccc;
        padding-top: 31%;
        margin-left: 1%;
        margin-top: 0.5%;
        position: relative;
    }
    .video_list>li>div{
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
    }
    .video_list>li>div>span{
        display: inline-block;
        margin-top: 50%;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
    }
</style>
<p style="text-align: center; font-size: 20px; font-weight: bold">点击用户名可查看对应用户的下级用户</p>
<ul class="video_list">
    <?php  if(is_array($list_arr)) { foreach($list_arr as $lists) { ?>
    <li>
     <div>

        <ul class="video_list">
            <?php  if(is_array($lists)) { foreach($lists as $list) { ?>
         <li>
             <div class="nickname" uid="<?php  echo $list['id'];?>">
                 <span >
                     <?php  echo $list['nickname'];?>
                     <br>
                     <br>
    <a class="btn  btn-op btn-operation" href="<?php  echo webUrl('member/list/detail',array('id' => $list['id']));?>" title="">

                                            <span data-toggle="tooltip" data-placement="top" title="" data-original-title="会员详情">

                                                <i class='icow icow-bianji2'></i>

                                            </span>

                                        </a>
                      <a class="btn  btn-op btn-operation" href="<?php  echo webUrl('order/list', array('searchfield'=>'member','keyword'=>$list['nickname']))?>"

                         title=''>

                                                   <span data-toggle="tooltip" data-placement="top" title="" data-original-title="会员订单">

                                                       <i class='icow icow-dingdan2'></i>

                                                    </span>
                                            </a>
                 </span>
             </div>
         </li>
            <?php  } } ?>
     </ul>
    </div>
    </li>
<?php  } } ?>
</ul>

<script>
$('.nickname').click(function () {

    var url = window.location.href;
    var id = $(this).attr('uid');

    window.location.href = url+'&id='+id
})
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>