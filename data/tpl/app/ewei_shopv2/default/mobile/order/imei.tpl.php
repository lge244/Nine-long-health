<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style>

    .fui-cell-group .fui-cell .fui-cell-icon {

        width: auto;

    }

    .fui-cell-group .fui-cell .fui-cell-icon img {

        width: 1.3rem;

        height: 1.3rem;

    }

    .fui-cell-group .fui-cell.no-border {

        padding-top: 0;

    }

    .fui-cell-group .fui-cell.no-border .fui-cell-info {

        font-size: .6rem;

        color: #999;

    }

    .fui-cell-group .fui-cell.applyradio .fui-cell-info {

        line-height: normal;

    }

</style>

<div class='fui-page  fui-page-current'>

    <div class="fui-header">

        <div class="fui-header-left">

            <a class="back"></a>

        </div>

        <div class="title">填写串号

        </div>

        <div class="fui-header-right">&nbsp;</div>

    </div>

    <div class="fui-content ">
        <div class="fui-cell-group">

        </div>
        <a class="btn btn-danger block " id="withdraw">确定</a>
    </div>


    <script>
        function getQueryString(name) {
            var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
            var r = window.location.search.substr(1).match(reg);
            if (r != null) {
                return unescape(r[2]);
            }
            return null;
        }

        $(function () {
            var num = getQueryString('num');
            for (var i = 1; i <= num; i++) {
                // "+ i +"
                $(".fui-cell-group").append(" <div class=\"fui-cell applyradio\">\n" +
                    "                <div class=\"fui-cell-label\" style=\"width: 120px;\">串号</div>\n" +
                    "                <div class=\"fui-cell-info\"><input type=\"text\" placeholder=\"请填写手环串号\" name=\"username\" class=\"fui-input\" value=\"\" max=\"25\"></div>\n" +
                    "            </div>")
            }
            $('#withdraw').click(function () {
                console.log(num);
                for (var i = 1; i <= num; i++) {
                    var arr = [{i:$("input[name=username]").val()}]
                }
                console.log(arr);
            })
        })


    </script>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>