<?php
require('common.php');

if(!isset($_GET['action']))
{
	echo json_encode(array('success' => false, 'msg' => 'No action given'));
	exit;
}

switch($_GET['action'])
{
	case 'get-friends':
		require_fb_auth();
		$data = get_friends_availability();
		echo json_encode(array('succss' => true, 'data' => $data));
		break;
		
}
