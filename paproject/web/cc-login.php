<?php
	$file_path = 'web/images/blank.gif';
	$download_manager = new PADownloadManager($file_path);
	if(!$download_manager->getFile()) {
		out_error404($download_manager->lastError(), $file_path);
	}
?>