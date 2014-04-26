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
	case 'get-friend-locations':
		require_fb_auth();
		require_params(array('facebook_id'));
		$data = get_friend_locations($_GET['facebook_id']);
		echo json_encode(array('success' => true, 'data' => $data));
		exit;
	case 'join-lunchline':
		require_fb_auth();
		require_params(array('starttime', 'endtime', 'food_pref', 'loc_lat', 'loc_lng'));
		if(($restaurants = join_lunchline(array(
				'starttime' => $_GET['starttime'],
				'endtime' => $_GET['endtime'],
				'food_pref' => $_GET['food_pref'],
				'status' => 1,
				'loc_lat' => $_GET['loc_lat'],
				'loc_lng' => $_GET['loc_lng']
		))) != false)
		{
			echo json_encode(array('success' => true, 'data' => array('restaurants' => $restaurants)));
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
