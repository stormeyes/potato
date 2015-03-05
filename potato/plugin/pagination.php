<?php

namespace potato\plugin;

class pagination {
    
    public static function paginate($totalpage=18, $currentpage=3, $maxlength=6, $link){
        $html = "<div class='pagination-box' style='margin-left: 20px'><ul class='pagination' style='margin: 0;' id='pagination'>";
        $limit='';
        $starter='';
        list($prelink,$preclass) = $currentpage == 1 ? array('1#','disable'):array($currentpage-1,'current');
        list($afterlink,$afterclass) = $currentpage == $totalpage ? array($currentpage.'#','disable'):array($currentpage+1,'current');
        $html .= "<a href='{$link}{$prelink}'><li class='{$preclass}'>上一页</li></a>";
        if($currentpage < $maxlength) {
            //总页数比设定的最多显示的页数多的情况
            $limit = $totalpage > $maxlength ? $maxlength : $totalpage;
            $starter = 1;
        }elseif($currentpage == $maxlength){
            $starter = $currentpage;
            $limit = $starter + $currentpage;
        }else{
            //$currentpage比$maxlangth大的情况下,不存在$maxlength比$totalpage大的情况
            $limit = $totalpage-$currentpage>$maxlength?$currentpage+$maxlength:$totalpage;
            $starter = $currentpage;
        }
        for ($i = $starter; $i <= $limit; $i++) {
            $currentclass = $i == $currentpage?" class='current'":"";
            $html .= "<a href='{$link}{$i}'><li{$currentclass}>{$i}</li></a>";
        }
        $html .= "<a href='{$link}{$afterlink}'><li class='{$afterclass}'>下一页</li></a>";
        $html .= "<a><li class='current'>共{$totalpage}页</li></a></ul></div>";
        return $html;
    }
} 