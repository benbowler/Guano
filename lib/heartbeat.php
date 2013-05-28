<?php

	$heartbeat = json_encode($guano);
	file_get_contents("http://guano.im/hb.php?data=".$heartbeat);

?>