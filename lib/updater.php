<?php

	if ($guano['autoUpdate'] || !isset($guano['autoUpdate'])) {
		if (file_exists("version.json")) {
			$guano['currentVersions'] = json_decode(file_get_contents("version.json"), true);
		}
		file_put_contents("version.json", file_get_contents("https://raw.github.com/benbowler/Guano/master/version.json"));
		$guano['updatedVersions'] = json_decode(file_get_contents("version.json"), true);
		foreach ($guano['updatedVersions'] AS $k => $v) {
			if (!isset($guano['currentVersions'][$k]['version']) || $guano['currentVersions'][$k]['version'] < $guano['updatedVersions'][$k]['version']) {
				echo "Updating ".$k." to version ".$guano['updatedVersions'][$k]['version']."..\n";
				file_put_contents("lib/".$k.".php", file_get_contents($guano['updatedVersions'][$k]['path']));
			}
		}
	}

?>