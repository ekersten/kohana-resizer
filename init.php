<?php defined('SYSPATH') or die('No direct script access.');

$cache_folder = Kohana::$config->load('resizer.cache_folder');

if(!file_exists($cache_folder) || !is_dir($cache_folder)){
	mkdir($cache_folder);
}


Route::set('resizer_flush', 'resizer/flush_cache',
  array())
  ->defaults(array(
    'controller' => 'resizer',
    'action'     => 'flush_cache',
  ));

Route::set('resizer', 'resizer/<type>/<width>/<height>/<file>',
  array(
    'type' => '(r|c)',
    'width' => '\d+',
    'height' => '\d+',
    'file' => '[a-zA-Z0-9\.\/\-_]+'
  ))
	->defaults(array(
		'controller' => 'resizer',
		'action'     => 'index',
	));