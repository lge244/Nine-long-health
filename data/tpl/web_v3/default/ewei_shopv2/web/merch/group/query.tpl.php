<?php defined('IN_IA') or exit('Access Denied');?><div style='max-height:500px;overflow:auto;min-width:850px;'>
<table class="table table-hover" style="min-width:850px;">
    <tbody>   
        <?php  if(is_array($list)) { foreach($list as $row) { ?>
        <tr>
          <td><?php  echo $row['groupname'];?></td>
          <td style="width:80px;"><a href="javascript:;" onclick='biz.selector.set(this, <?php  echo json_encode($row);?>)'>选择</a></td>
        </tr>
        <?php  } } ?>
        <?php  if(count($list)<=0) { ?>
        <tr> 
            <td colspan='4' align='center'>未找到分组</td>
        </tr>
        <?php  } ?>
    </tbody>
</table>
    </div>
<!--913702023503242914-->