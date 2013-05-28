#!/usr/bin/php
<?php

	/*
		This is your application keys retrieved from http://dev.twitter.com
	*/
	$guano['appkey'] = "";
	$guano['appsecret'] = "";

	/*
		These are the keys generated for your user on your Twitter application
	*/
	$guano['usertoken'] = "";
	$guano['usertokensecret'] = "";

	/*
		The search term used to harvest people to follow
	*/
	$guano['searchTerm'] = "#teamfollowback";

	/*
		How long do you want to leave it before we unfollow them?
	*/
	$guano['followTime'] = strtotime("-2 day");

	/*
		Where we locally store our output inbetween sessions
	*/
	$guano['localShitList'] = 'shitlist.txt';

	/*
		Not yet implemented
	*/
	$guano['maxFollowing'] = 2000;

	/*
		Auto updater
	*/
	$guano['autoUpdate'] = true;

	/*
		Send usage statistics
	*/
	$guano['heartbeat'] = true;


	/*

		Do not edit below here!

	*/

	chdir(dirname(__FILE__));

	include("lib/updater.php");

	include("lib/codebird.php");
	include("lib/guano.php");
	include("lib/heartbeat.php");

?>