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
		exit;
	case 'search-restaurants':
		require_fb_auth();
		require_params(array('loc_lat', 'loc_lgn', 'q'));
		$data = find_restuarants($_GET['loc_lat'], $_GET['loc_lgn'], $_GET['q']);
		echo json_encode(array('succss' => true, 'data' => $data));
		exit;
	case 'join-lunchline':
		require_fb_auth();
		require_params(array('time_begin', 'time_end', 'restuarant_ids', 'loc_lat', 'loc_lgn'));
		update_my_availability(array($_GET['time_begin'], $_GET['time_end'], $_GET['restuarant_ids'], $_GET['loc_lat'], $_GET['loc_lgn']));
		exit;
	default:
		echo json_encode(array('success' => false, 'msg' => 'Invalid action'));
		exit;
}
