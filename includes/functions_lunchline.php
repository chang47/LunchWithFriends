<?php
function get_friends_availability()
{
	global $db, $facebook;

	$friends = $facebook->api('me/friends?limit=5000');
	$data = array();
	$i = 0;
	foreach($friends['data'] as $key => $val)
	{ 
		$facebook_id = $val['id'];

		$friend_availability = get_friend_availability($facebook_id);
		if($friend_availability != false)
		{
			$data[$i] = array_merge($val, $friend_availability);
			$data[$i]['dp'] = 'https://graph.facebook.com/' . $facebook_id . '/picture';
			$i ++;
		}

	}
	return $data;
}

function get_friend_availability($facebook_id)
{
	global $db;

	$stmt = $db->prepare('SELECT location_lat, location_lng, status, startdatetime, enddatetime FROM lunch_line WHERE /*enddatetime < NOW() AND*/ facebook_id = ?');
	$stmt->execute(array($facebook_id));
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function join_lunchline($availability)
{
	global $user, $db;

	if(!($starttime = date('Y-m-d H:i:s', $availability['starttime'])))
	{
		return false;
	}
	if(!($endtime = date('Y-m-d H:i:s', $availability['endtime'])))
	{
		return false;
	}

	//try to make change to a current record
	$stmt = $db->prepare('UPDATE lunch_line SET location_lat = ?, location_lng = ?, status = ?, startdatetime = ?, enddatetime = ? WHERE facebook_id = ?');
	$stmt->execute(array($availability['loc_lat'], $availability['loc_lng'], $availability['status'], $starttime, $endtime, $user));
	if(!$stmt->rowCount())
	{
		//insert new row
		$stmt = $db->prepare('INSERT INTO lunch_line (facebook_id, location_lat, location_lng, status, startdatetime, enddatetime) VALUES (?, ?, ?, ?, ?, ?)');
		$stmt->execute(array($user, $availability['loc_lat'], $availability['loc_lng'], $availability['status'], $starttime, $endtime));
	}
	return true;
}

function leave_lunchline()
{
	global $user, $db;

	$stmt = $db->prepare('UPDATE lunch_line SET status = 0 WHERE facebook_id = ?');
	$stmt->execute(array($facebook_id));
}
