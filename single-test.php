<?php require_once("connections.php"); ?>
<?php require_once("functions.php"); ?>
<?php include("header.php"); ?>
<?php 
	//$testID1 = "140621_Z6_51V";
	//$testID2 = "140625_E0_41X";
	//$testID3 = "140625_VH_TG0";
	//$testID4 = "140702_EZ_WP8";
	//$testID5 = "140703_KN_HJZ";
	//$testID6 = "140704_8M_HHH";
	//$testID7 = "140707_XY_RZK";
	//$testID8 = "140709_ZY_JR0";
	//$testID9 = "140709_BN_JVC";
	//$testID10 = "140710_NC_RP4";
	//$testID11 = "140711_M5_YWJ";

	$testID = "140711_M5_YWJ";


	//$comp_testID1 = "140704_8Y_GBR";
	//$comp_testID2 = "140704_K9_HH5";
	//$comp_testID3 = "140707_3H_RJ2";
	//$comp_testID4 = "140709_TV_JRD";
	//$comp_testID5 = "140709_AE_JVN";
	//$comp_testID6 = "140710_P6_RRS";
	//$comp_testID7 = "140711_AD_YWN";

	$comp_testID = "140711_AD_YWN";

	$xml_url = 'http://www.webpagetest.org/xmlResult/'.$testID.'/';
	//echo "url: ".$url."<br>";
	
	$comp_xml_url = 'http://www.webpagetest.org/xmlResult/'.$comp_testID.'/';

	$xml = simplexml_load_file($xml_url);
	//var_dump($xml);

	$comp_xml = simplexml_load_file($comp_xml_url);

	
	$url = $xml->data->testUrl;
	$comp_url = $comp_xml->data->testUrl;
	
	$test_date = date('Y-m-d', strtotime($xml->data->completed));
	$average_fv = array('loadTime'=> (int)$xml->data->average->firstView[0]->loadTime, 
						'TTFB'=> (int)$xml->data->average->firstView[0]->TTFB, 
						'connections'=> (int)$xml->data->average->firstView[0]->connections, 
						'requests'=> (int)$xml->data->average->firstView[0]->requests, 
						'responses_404'=> (int)$xml->data->average->firstView[0]->responses_404, 
						'render'=> (int)$xml->data->average->firstView[0]->render, 
						'fullyLoaded'=> (int)$xml->data->average->firstView[0]->fullyLoaded, 
						'score_cache'=> (int)$xml->data->average->firstView[0]->score_cache, 
						'score_cdn'=> (int)$xml->data->average->firstView[0]->score_cdn, 
						'score_gzip'=> (int)$xml->data->average->firstView[0]->score_gzip, 
						'score_cookies'=> (int)$xml->data->average->firstView[0]->score_cookies, 
						'score_keep-alive'=> (int)$xml->data->average->firstView[0]->score_keep-alive, 
						'score_minify'=> (int)$xml->data->average->firstView[0]->score_minify, 
						'score_compress'=> (int)$xml->data->average->firstView[0]->score_compress);
	
	$average_rv = array('loadTime'=> (int)$xml->data->average->repeatView[0]->loadTime, 
						'TTFB'=> (int)$xml->data->average->repeatView[0]->TTFB, 
						'connections'=> (int)$xml->data->average->repeatView[0]->connections, 
						'requests'=> (int)$xml->data->average->repeatView[0]->requests, 
						'responses_404'=> (int)$xml->data->average->repeatView[0]->responses_404, 
						'render'=> (int)$xml->data->average->repeatView[0]->render, 
						'fullyLoaded'=> (int)$xml->data->average->repeatView[0]->fullyLoaded, 
						'score_cache'=> (int)$xml->data->average->repeatView[0]->score_cache, 
						'score_cdn'=> (int)$xml->data->average->repeatView[0]->score_cdn, 
						'score_gzip'=> (int)$xml->data->average->repeatView[0]->score_gzip, 
						'score_cookies'=> (int)$xml->data->average->repeatView[0]->score_cookies, 
						'score_keep-alive'=> (int)$xml->data->average->repeatView[0]->score_keep-alive, 
						'score_minify'=> (int)$xml->data->average->repeatView[0]->score_minify, 
						'score_compress'=> (int)$xml->data->average->repeatView[0]->score_compress);

	$average_fv = json_encode($average_fv);
	$average_rv = json_encode($average_rv);


	$comp_average_fv = array('loadTime'=> (int)$comp_xml->data->average->firstView[0]->loadTime, 
						'TTFB'=> (int)$comp_xml->data->average->firstView[0]->TTFB, 
						'connections'=> (int)$comp_xml->data->average->firstView[0]->connections, 
						'requests'=> (int)$comp_xml->data->average->firstView[0]->requests, 
						'responses_404'=> (int)$comp_xml->data->average->firstView[0]->responses_404, 
						'render'=> (int)$comp_xml->data->average->firstView[0]->render, 
						'fullyLoaded'=> (int)$comp_xml->data->average->firstView[0]->fullyLoaded, 
						'score_cache'=> (int)$comp_xml->data->average->firstView[0]->score_cache, 
						'score_cdn'=> (int)$comp_xml->data->average->firstView[0]->score_cdn, 
						'score_gzip'=> (int)$comp_xml->data->average->firstView[0]->score_gzip, 
						'score_cookies'=> (int)$comp_xml->data->average->firstView[0]->score_cookies, 
						'score_keep-alive'=> (int)$comp_xml->data->average->firstView[0]->score_keep-alive, 
						'score_minify'=> (int)$comp_xml->data->average->firstView[0]->score_minify, 
						'score_compress'=> (int)$comp_xml->data->average->firstView[0]->score_compress);
	
	$comp_average_rv = array('loadTime'=> (int)$comp_xml->data->average->repeatView[0]->loadTime, 
						'TTFB'=> (int)$comp_xml->data->average->repeatView[0]->TTFB, 
						'connections'=> (int)$comp_xml->data->average->repeatView[0]->connections, 
						'requests'=> (int)$comp_xml->data->average->repeatView[0]->requests, 
						'responses_404'=> (int)$comp_xml->data->average->repeatView[0]->responses_404, 
						'render'=> (int)$comp_xml->data->average->repeatView[0]->render, 
						'fullyLoaded'=> (int)$comp_xml->data->average->repeatView[0]->fullyLoaded, 
						'score_cache'=> (int)$comp_xml->data->average->repeatView[0]->score_cache, 
						'score_cdn'=> (int)$comp_xml->data->average->repeatView[0]->score_cdn, 
						'score_gzip'=> (int)$comp_xml->data->average->repeatView[0]->score_gzip, 
						'score_cookies'=> (int)$comp_xml->data->average->repeatView[0]->score_cookies, 
						'score_keep-alive'=> (int)$comp_xml->data->average->repeatView[0]->score_keep-alive, 
						'score_minify'=> (int)$comp_xml->data->average->repeatView[0]->score_minify, 
						'score_compress'=> (int)$comp_xml->data->average->repeatView[0]->score_compress);

	$comp_average_fv = json_encode($comp_average_fv);
	$comp_average_rv = json_encode($comp_average_rv);

	mysql_query("INSERT INTO webpagetest (testID, url, testdate, average_fv, average_rv, comp_testID, comp_url, comp_average_fv, comp_average_rv, runs) VALUES('$testID', '$url', '$test_date', '$average_fv', '$average_rv', '$comp_testID', '$comp_url', '$comp_average_fv', '$comp_average_rv', '')");

	// or...........
	// foreach ($xml->bbb->cccc as $element) {
	//   foreach($element as $key => $val) {
	//    echo "{$key}: {$val}";
	//   }
	// }
?>
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Connection Info</h3>
		</div>
		<div class="panel-body no-padding">
		
			<div class="col-md-2 <?php echo ($xml->statusCode == '200' ? 'alert-success' : 'alert-warning'); ?> ">Status:<br><?php echo $xml->statusCode; ?> (<?php echo $xml->statusText; ?>)</div>
			<div class="col-md-2">Connection:<br><?php echo $xml->data->connectivity; ?></div>
			<div class="col-md-2">D/L:<br><?php echo ($xml->data->bwDown)/1000; ?> mbps</div>
			<div class="col-md-2">U/L:<br><?php echo ($xml->data->bwUp)/1000; ?> mbps</div>
			<div class="col-md-2">Latency:<br><?php echo $xml->data->latency; ?> ms</div>
			<div class="col-md-2">Completed On:<br><?php echo date("F j, Y, g:i a", strtotime($xml->data->completed));?></div>
		
		</div>
	</div>
</div>
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Connection Info</h3>
		</div>
		<div class="panel-body no-padding">
		
			<div class="col-md-1 <?php echo ($xml->statusCode == '200' ? 'alert-success' : 'alert-warning'); ?> ">Status:<br><?php echo $xml->statusCode; ?> (<?php echo $xml->statusText; ?>)</div>
			<div class="col-md-2">Location:<br><?php echo $xml->data->from; ?></div>
			<div class="col-md-1">Connection:<br><?php echo $xml->data->connectivity; ?></div>
			<div class="col-md-1">D/L:<br><?php echo ($xml->data->bwDown)/1000; ?> mbps</div>
			<div class="col-md-1">U/L:<br><?php echo ($xml->data->bwUp)/1000; ?> mbps</div>
			<div class="col-md-1">Latency:<br><?php echo $xml->data->latency; ?> ms</div>
			<div class="col-md-1">Browser:<br><?php echo substr($xml->data->tester, 0, 3); ?></div>
			<div class="col-md-2">Completed On:<br><?php echo date("F j, Y, g:i a", strtotime($xml->data->completed));?></div>
			<div class="col-md-2">Tested URL:<br><?php echo $xml->data->testUrl; ?></div>
		
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<canvas id="myChart" width="600" height="400"></canvas>
		<script>
			
			var data = {
				labels : ["January","February","March","April","May","June","July"],
				datasets : [
					{
						fillColor : "rgba(220,220,220,0.5)",
						strokeColor : "rgba(220,220,220,1)",
						pointColor : "rgba(220,220,220,1)",
						pointStrokeColor : "#fff",
						data : [65,59,90,81,56,55,40]
					},
					{
						fillColor : "rgba(151,187,205,0.5)",
						strokeColor : "rgba(151,187,205,1)",
						pointColor : "rgba(151,187,205,1)",
						pointStrokeColor : "#fff",
						data : [28,48,40,19,96,27,0]
					}
				]
			}

			//Get the context of the canvas element we want to select
			var ctx = document.getElementById("myChart").getContext("2d");
			var myNewChart = new Chart(ctx).Line(data);


		</script>
	</div>
</div>
	
<?php include("footer.php"); ?>