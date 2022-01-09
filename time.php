<?php
require 'vendor/autoload.php';

use Carbon\Carbon;

$dt = Carbon::yesterday();
echo $dt->day."<br/>\n";
echo $dt->now()."<br/>\n";
echo "今日は".date("Y.m.d", $dt)."<br/>\n";
//echo $dt->day;

$item1 = '00:32:55';
$item2 = '00:35:54';

$objItem1 = new DateTime($item1);
$objItem2 = new DateTime($item2);
$objInterval = $objItem1->diff($objItem2);

echo $objInterval->format('%H:%i:%s').'<br/>'; //

//echo $objInterval;
echo $objInterval->format('%R%Y').'年<br/>'; //年
echo $objInterval->format('%R%M').'月<br/>'; //月
echo $objInterval->format('%R%D').'日<br/>'; //日
echo $objInterval->format('%R%H').'時<br/>'; //時
echo $objInterval->format('%R%I').'分<br/>'; //分
echo $objInterval->format('%R%S').'秒<br/>'; //秒
echo $objInterval->format('%H:%i:%s').'<br/>'; //

echo $item2."<-item2 item1->".$item1."<br/>\n";
echo "<br>\n";
$item11 = $item2 - $item1;
echo date("H:i:s", $item11);
