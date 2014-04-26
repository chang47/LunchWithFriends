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
		require_params(array('loc_lat', 'loc_lng', 'q'));
		$data = find_restuarants($_GET['loc_lat'], $_GET['loc_lng'], $_GET['q']);
		echo json_encode(array('succss' => true, 'data' => $data));
		exit;
	case 'join-lunchline':
		require_fb_auth();
		require_params(array('starttime', 'endtime', 'restaurant_ids', 'loc_lat', 'loc_lng', 'pref'));
		if(join_lunchline(array(
				'starttime' => $_GET['starttime'],
				'endtime' => $_GET['endtime'],
				'restaurant_ids' => $_GET['restaurant_ids'],
				'status' => 1,
				'loc_lat' => $_GET['loc_lat'],
				'loc_lng' => $_GET['loc_lng']
				'pref' => $_GET['pref'];
		)));
		{
			echo json_encode(array('success' => true));
		}
		else
		{
			echo json_encode(array('success' => false, 'msg' => 'Failed to join lunchline :('));
		}
		exit;
	case 'leave-lunchline':
		require_fb_auth();
		leave_lunchline();
		echo json_encode(array('success' => true));
		exit;
	default:
		echo json_encode(array('success' => false, 'msg' => 'Invalid action'));
		exit;
}
