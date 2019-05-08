<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .checkbox-inline input[type=checkbox], .radio-inline input[type=radio] {
        position: absolute;
        margin-left: -1.2rem;
        top: -.15rem;
    }
    .fui-list-inner .title{
        display: -webkit-box;  display: -webkit-flex;  display: -ms-flexbox;  display: flex;
    }
    .fui-list-inner .title .realname{
        max-width: 2rem;
        display: inline-block;
        max-width: 12rem;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        padding-right: 1.2rem;
    }
    .fui-list-inner .address{
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
</style>
<div class='fui-page  fui-page-current'>
    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title">投保记录</div>
        <div class="fui-header-right">&nbsp;</div>
    </div>


<?php  if(is_array($insurance)) { foreach($insurance as $row) { ?>
    <div class="fui-list-group address-item" style='margin-top:50px;'
         data-addressid="">
        <div  class="fui-list" >
            <div class="fui-list-inner">
                <div class="title"><span class='realname'><?php  echo $row['username'];?></span> <span class='mobile'><?php  echo $row['phone'];?></span>
                    <?php  if($row['status'] == 0) { ?>
                    <span style="color: red; margin-left: 20px;">尚未联系</span>
                    <?php  } else { ?>
                    <?php  if($row['status'] == 1) { ?>
                    <span style="color: #0A8CD2;margin-left: 20px; ">已联系</span>
                    <?php  } else { ?>
                    <?php  if($row['status'] == 2) { ?>
                    <span style="color: #7A3993;margin-left: 20px; ">已保</span>
                    <?php  } else { ?>
                    <span style="color: #495066;margin-left: 20px; ">已关闭</span>
                    <?php  } ?>
                    <?php  } ?>
                    <?php  } ?>
                </div>
                <div class="text">
                    <span class='address'><?php  echo $row['address'];?></span>
                </div>
                <div class='bar' >
			<span class='pull-right'>
                <?php  if($row['status'] == 2) { ?>
			    <a class="" href="<?php  echo mobileUrl('member/insurance/backfill',array('id'=>$row['id']))?>" data-nocache="true">
				<i class='icon icon-edit2'></i> 反馈
			    </a>
			    &nbsp;&nbsp;<?php  } ?>
			    <a data-toggle='delete' class='external' href="JavaScript:;" data-id="<?php  echo $row['id'];?>">
				<i class='icon icon-delete'></i> 关闭
			    </a>
			</span>
                </div>
            </div>
        </div>
    </div>
<?php  } } ?>
</div>
<script>
    $('.external').click(function () {
        var id = $(this).attr('data-id');
        $.post("<?php  echo mobileUrl('member/insurance/close')?>",{id:id},function (res) {
            if (res.code == 0){
                alert(res.msg);
                window.location.reload();
            }else{
                alert(res.msg);
            }
        },'json')
    })
</script>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
