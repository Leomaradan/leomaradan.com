<?php

return [

	'default' => env('IPFILTER_DRIVER', 'file'),

	'ban' => [
		'attempt' => 5,
		'duration' => 1800
	],

	//	const DataDir = 'log';
	//const Filename = 'ipbans.php';


	'stores' => [

		'database' => [
			'driver' => 'database',
			'table'  => 'ipfilter',
			'connection' => null,
		],

		'file' => [
			'driver' => 'file',
			'path'   => storage_path().'/framework/ipfilter',
		],


	],

];
