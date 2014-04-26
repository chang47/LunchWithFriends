<?php
function require_fb_auth()
{
        global $user, $facebook;

        if(!$user)
        {
                echo json_encode(array('success' => false, 'msg' => 'Facebook not authenticated', 'url' => $facebook->getLoginUrl()));
                exit;
        }
}

