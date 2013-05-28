<?php

	if (!file_exists($guano['localShitList'])) {
		if (!touch($guano['localShitList'])) {
			echo "Failed to create shit list.";
			exit(0);
		}
	} else {
		$guano['object'] = json_decode(file_get_contents($guano['localShitList']), true);
	}

	\Codebird\Codebird::setConsumerKey($guano['appkey'], $guano['appsecret']);
	$cb = \Codebird\Codebird::getInstance();
	$cb->setToken($guano['usertoken'], $guano['usertokensecret']);
	$guano = array_merge((array) $cb->account_verifyCredentials(), (array) $guano);

	if (isset($guano['errors'])) {
		echo $guano['errors'][0]->message;
		exit(0);
	}

	if (isset($argv)) {
		if (isset($argv[1])) {
			if ($argv[1] == "unfollow") {
				echo "Executing mass unfollow\n";
				$ids = $cb->friends_ids();
				foreach ($ids->ids AS $id) {
					$params = array(
						"user_id" => $id
					);
					$reply = $cb->friendships_destroy($params);
					if ($reply->httpstatus != 200) {
						echo "You might need to run unfollow again in 15mins to finish this list\n";
						continue;
					}
				}
				exit(0);
			}
		}
	}

	if ($guano['followers_count'] > $guano['maxFollowing']) {
		$guano['maxFollowing'] = $guano['followers_count'];
	}

	if (isset($guano['object'])) {
		foreach ($guano['object'] AS $id => $o) {
			if ($o['followed'] <= $guano['followTime'] && $o['followed'] != 0) {
				$params = array(
					"user_id" => $id
				);
				echo "Unfollowing: ".$params['user_id']."\n";
				$reply = $cb->friendships_destroy($params);
				if ($reply->httpstatus == 200) {
					$guano['object'][$id]['unfollowed'] = 0;
				}
			}
		}
	}

	$search = $cb->search_tweets('q='.$guano['searchTerm'], true);

	if ($search->httpstatus == 200) {

		foreach ($search->statuses AS $status) {
			if (!isset($guano['object'][$status->user->id])) {
				$params = array(
					"user_id" => $status->user->id
				);
				$reply = $cb->friendships_create($params);
				echo "Following: ".$params['user_id']."\n";
				if ($reply->httpstatus == 200) {
					$guano['object'][$params['user_id']]['followed'] = date("U");
					$guano['object'][$params['user_id']]['unfollowed'] = 0;
				}
			}
		}

	}
 
	file_put_contents($guano['localShitList'], json_encode($guano['object']));

?>