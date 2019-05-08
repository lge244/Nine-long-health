<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    tbody tr td {
        position: relative;
    }

    tbody tr .icow-weibiaoti-- {
        visibility: hidden;
        display: inline-block;
        color: #fff;
        height: 18px;
        width: 18px;
        background: #e0e0e0;
        text-align: center;
        line-height: 18px;
        vertical-align: middle;
    }

    tbody tr:hover .icow-weibiaoti-- {
        visibility: visible;
    }

    tbody tr .icow-weibiaoti--.hidden {
        visibility: hidden !important;
    }

    .full .icow-weibiaoti-- {
        margin-left: 10px;
    }

    .full > span {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        vertical-align: middle;
        align-items: center;
    }

    tbody tr .label {
        margin: 5px 0;
    }

    .goods_attribute a {
        cursor: pointer;
    }

    .newgoodsflag {
        width: 22px;
        height: 16px;
        background-color: #ff0000;
        color: #fff;
        text-align: center;
        position: absolute;
        bottom: 70px;
        left: 57px;
        font-size: 12px;
    }

    .modal-dialog {
        min-width: 720px !important;
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
    }

    .catetag {
        overflow: hidden;

        text-overflow: ellipsis;

        display: -webkit-box;

        -webkit-box-orient: vertical;

        -webkit-line-clamp: 2;
    }
</style>
<div class="page-header">
    当前位置：<span class="text-primary">管理员管理</span>
</div>
<div class="page-content">
    <!--<div class="fixed-header">-->
        <!--<div style="width:25px;"></div>-->
        <!--<div style="width:80px;text-align:center;">排序</div>-->
        <!--<div style="width:80px;">商品</div>-->
        <!--<div class="flex1">&nbsp;</div>-->
        <!--<div style="width: 100px;">价格</div>-->
        <!--<div style="width: 80px;">库存</div>-->
        <!--<div style="width: 80px;">销量</div>-->
        <?php  if($goodsfrom!='cycle') { ?>
        <!--<div style="width:80px;">状态</div>-->
        <?php  } ?>
        <!--<div class="flex1">属性</div>-->
        <!--<div style="width: 120px;">操作</div>-->
    <!--</div>-->


    <div class="row">
        <div class="col-md-12">
            <table class="table table-responsive">
                <thead class="navbar-inner">
                <tr>
                    <th style="width:15%;">学员ID</th>
                    <th style="width:25%;">学员名称</th>
                    <th style="width:20%;">学员课程</th>
                    <th style="width:20%;">上课时间</th>
                    <th style="width:20%;">购课时间</th>
                    <th style="width:20%;">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php  if(is_array($member)) { foreach($member as $row) { ?>
                <tr>
                    <td><?php  echo $row['id'];?></td>
                    <td><?php  echo $row['member']['nickname'];?></td>
                    <td><?php  echo $row['title'];?></td>
                    <td><?php  if($row['status'] == 0 ) { ?><span style="color: red">未上课</span><?php  } else { ?><span style="color: #0baefd">已上课</span><?php  } ?></td>
                    <td><?php  echo date('Y-m-d',$row['schooltime'])?></td>
                    <td>
                        <a  class='btn  btn-op btn-operation' href="<?php  echo webUrl('training/pass', array('id' => $row['id']))?>">
                                   <span data-toggle="tooltip" data-placement="top" title="" data-original-title="通过">
                                        <i class='icow icow-bianji2'></i>
                                   </span>
                        </a>
                    </td>
                </tr>
                <?php  } } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/batchcates', TEMPLATE_INCLUDEPATH)) : (include template('goods/batchcates', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
