<?php
require 'vendor/autoload.php';

use Carbon\Carbon;

$dt = Carbon::yesterday();
echo $dt->day;
echo $dt->now();
echo $dt;
//echo $dt->day;

