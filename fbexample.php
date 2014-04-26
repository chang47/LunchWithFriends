<?php
require('common.php');

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if($user)
{
	try{
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me');
	} catch (FacebookApiException $e) {
		error_log($e);
		$user = null;
	}
}

// Login or logout url will be needed depending on current user state.
$loginUrl = $facebook->getLoginUrl();
?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<title>php-sdk</title>
	</head>
	<body>
		<h1>php-sdk</h1>

		<?php if (!$user): ?>
			<div>
				Login using OAuth 2.0 handled by the PHP SDK:
				<a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
			</div>
		<?php endif ?>

		<?php if ($user): ?>
			<h3>You</h3>
			<img src="https://graph.facebook.com/<?php echo $user; ?>/picture">

			<h3>Your User Object (/me)</h3>
			<pre><?php print_r($user_profile); ?></pre>
			<?php print_r($facebook->api('me/friends?limit=5000')); ?>
		<?php else: ?>
			<strong><em>You are not Connected.</em></strong>
		<?php endif ?>
	</body>
</html>
