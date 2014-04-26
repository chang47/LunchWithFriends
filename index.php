<?php
$times = array();
$hour = (int)date('H');
$minute = (int)date('i');
for($i = $hour; $i < 24; $i ++)
{
	if($i == $hour && $minute < 30)
	{
		$times = strtotime(date(

require('templates/index.html');
