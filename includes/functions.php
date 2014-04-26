<?php
function require_fb_auth()
{
        global $user, $facebook;

        if(!$user)
        {
                echo json_encode(array('success' => false, 'msg' => 'Facebook not authenticated', 'url' => 'fblogin.php'));
                exit;
        }
}

function require_params($params)
{
	foreach($params as $param)
	{
		if(!isset($_GET[$param]))
		{
			echo json_encode(array('success' => false, 'msg' => 'Missing required parameter "' . $param . '"'));
			exit;
		}
	}
}
