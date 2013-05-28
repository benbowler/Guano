<?php

	$heartbeat = http_build_query(array("data" => json_encode($guano)));
	$opts = array('http' =>
		array(
			'method'  => 'POST',
			'header'  => 'Content-type: application/x-www-form-urlencoded',
			'content' => $heartbeat
		)
	);
	$context  = stream_context_create($opts);
	file_get_contents("http://guano.im/hb.php?data=".$heartbeat, false, $context);

?>