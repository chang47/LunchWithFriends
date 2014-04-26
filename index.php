<?php
require('common.php');

$times = array();
$hour = (int)date('H');
$minute = (int)date('i');
for($i = $hour; $i < 24; $i ++)
{
	if($i == $hour)
	{
		if($minute < 30)
		{
			$times[strtotime(date('Y-m-d ' . $i . ':30:00'))] = ($i > 12) ? ($i - 12) . ':30PM' : $i . ':30AM';
		}
	}
	else
	{
		$times[strtotime(date('Y-m-d ' . $i . ':00:00'))] = ($i > 12) ? ($i - 12) . ':00PM' : $i . ':00AM';
		$times[strtotime(date('Y-m-d ' . $i . ':30:00'))] = ($i > 12) ? ($i - 12) . ':30PM' : $i . ':30AM';
	}
}

if(!$user)
{
	header('location: fblogin.php');
	exit;
}
require('templates/index.html');
