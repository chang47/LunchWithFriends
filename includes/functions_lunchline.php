<?php
function get_friends_availability()
{
	global $db, $facebook;

	$friends = $facebook->api('me/friends?limit=5000');
	$data = $friends['data'];
	foreach($friends['data'] as $key => $val)
	{ 
		$facebook_id = $val['id'];
		$data[$key]['dp'] = 'https://graph.facebook.com/' . $facebook_id . '/picture';

		$friend_availability = get_friend_availability($facebook_id);
		if($friend_availability == false)
		{
			$data[$key]['status'] = 0;
		}
		else
		{
			$data[$key] = array_merge($data[$key], $friend_availability);
		}

	}
	return $data;
}

function get_friend_availability($facebook_id)
{
	global $db;

	$stmt = $db->prepare('SELECT location_lat, location_lng, status, datetime FROM lunch_time WHERE expiredatatime < NOW() AND facebook_id = ?');
	$stmt->execute(array($facebook_id));
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update_my_availability($availability)
{
	global $user;
	return update_availability($user, $availability);
}

function update_availability($facebook_id, $availability)
{
	global $db;

	//try to make change to a current record
	$stmt = $db->prepare('UPDATE lunch_line SET location_lat = ?, location_lng = ?, status = ?, startdatetime = ?, enddatetime = ? WHERE facebook_id = ?');
	$stmt->execute(array($availability['location_lat'], $availability['location_lng'], $availability['status'], $availability['expire'], $facebook_id));
	if(!$stmt->rowCount())
	{
		//insert new row
		$stmt = $db->prepare('INSERT INTO lunch_line (location_lat, location_lng, status, datetime, expiredatetime) VALUES (?, ?, ?, NOW(), TIMESTAMPADD(MINUTE, ?, NOW())) WHERE facebook_id = ?');
		$stmt->execute(array($availability['location_lat'], $availability['location_lng'], $availability['status'], $availability['expire'], $facebook_id));
	}
}
