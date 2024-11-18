<?php

	require_once 'config.php';
	require_once 'includes/loader.php';
	require_once ADSYNCPATH . 'db_connect.php';

	global $user;

	DbConnect::store_log($user_id, $user['type'], 'Logout', 'successfully logged out.');

	setcookie('_adsync_auth', '', time() - 2592000, '/'); // 30 days = 60 * 60 * 24 * 30
	header('Location: login.php');
