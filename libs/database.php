<?php
	defined( 'uservice' ) or die( 'You should not see this.' );
include_once("global.php");
	//require_once(dirname(__FILE__).'/../config/config.inc.php');
	require_once(dirname(__FILE__).'/database/mapper.php');


	$GLOBALS['mapping_table'] = array(
		'notes' => array(
			'type' => 'entity',
			'fields' => array(
				'author',
				'message',
				'user',
				'time'
			)
		),
		'list_notes' => array(
			'type' => 'query',
			'query' => 'select * from notes',
			'count_query' => 'select count(*) as count from notes',
			'oper' => 'select'
		)
	);


?>
