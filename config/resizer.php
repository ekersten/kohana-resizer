<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(
	// Use cached thumbnail
	'user_cache'  => TRUE,
	// 
	'ttl' => (3600 * 24) * 7, // 1 week

	'cache_folder' => APPPATH . 'cache' . DIRECTORY_SEPARATOR . 'resizer' . DIRECTORY_SEPARATOR


);
