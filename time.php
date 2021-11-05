<?php
require 'vendor/autoload.php';

use Carbon\Carbon;

$dt = Carbon::today();
echo $dt->month;
