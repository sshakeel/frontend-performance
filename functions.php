<?php
	// 

	function testSelect($col, $table, $where=''){
		$result = mysql_query("SELECT '$col' FROM '$table' WHERE '$where'");

		$row = mysql_fetch_array($result);

		return $row;
	}

	function sqlInsert(){
		
	}

	
	
	
?>