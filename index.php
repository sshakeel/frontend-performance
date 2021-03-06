<?php require_once("connections.php"); ?>
<?php require_once("functions.php"); ?>
<?php include("header.php"); ?>
<?php 
	
	$test_results = array();

	$result = mysql_query("SELECT * FROM webpagetest WHERE testdate >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
	
	$i = 0;
	
	while($row = mysql_fetch_array($result)){
		$test_results[$i]['id'] = $row['id'];
		//echo $test_results[$i]['id'];

		$test_results[$i]['testID'] = $row['testID'];
		//echo $test_results[$i]['testID'];

		$test_results[$i]['url'] = $row['url'];
		//echo $test_results[$i]['url'];

		$test_results[$i]['testdate'] = $row['testdate'];
		//echo $test_results[$i]['testdate'];

		$test_results[$i]['average_fv'] = json_decode($row['average_fv'], true);
		//print_r($test_results[$i]['average_fv']);
		//echo "<hr><hr>";

		$test_results[$i]['average_rv'] = json_decode($row['average_rv'], true);
		//print_r($test_results[$i]['average_rv']);
		//echo "<hr><hr>";

		$test_results[$i]['comp_testID'] = $row['comp_testID'];
		//echo $test_results[$i]['testID'];

		$test_results[$i]['comp_url'] = $row['comp_url'];
		//echo $test_results[$i]['url'];

		$test_results[$i]['comp_average_fv'] = json_decode($row['comp_average_fv'], true);
		//print_r($test_results[$i]['average_fv']);
		//echo "<hr><hr>";

		$test_results[$i]['comp_average_rv'] = json_decode($row['comp_average_rv'], true);
		//print_r($test_results[$i]['average_rv']);
		//echo "<hr><hr>";

		$i++;
	}

	$test_dates = array();

	$avg_load_times_fv = array();
	$avg_load_times_rv = array();
	
	$avg_render_times_fv = array();
	$avg_render_times_rv = array();

	$avg_fullyLoaded_times_fv = array();
	$avg_fullyLoaded_times_rv = array();

	$avg_connections_fv = array();
	$avg_connections_rv = array();

	$avg_requests_fv = array();
	$avg_requests_rv = array();

	$avg_404_fv = array();
	$avg_404_rv = array();

	// competitor stuff

	$comp_avg_load_times_fv = array();
	$comp_avg_load_times_rv = array();
	
	$comp_avg_render_times_fv = array();
	$comp_avg_render_times_rv = array();

	$comp_avg_fullyLoaded_times_fv = array();
	$comp_avg_fullyLoaded_times_rv = array();

	$comp_avg_connections_fv = array();
	$comp_avg_connections_rv = array();

	$comp_avg_requests_fv = array();
	$comp_avg_requests_rv = array();

	$comp_avg_404_fv = array();
	$comp_avg_404_rv = array();


	foreach($test_results as $test_results_item){
		//echo "Load Time: ".$test_results_item['average_fv']['loadTime']."<br>";
		//echo "Load Time(int): " . (($test_results_item['average_fv']['loadTime'])/1000) . "<br><hr>";
		array_push($test_dates, date("F j", strtotime((string)$test_results_item['testdate'])));

		array_push($avg_load_times_fv, ($test_results_item['average_fv']['loadTime'])/1000);
		array_push($avg_load_times_rv, ($test_results_item['average_rv']['loadTime'])/1000);

		array_push($avg_render_times_fv, ($test_results_item['average_fv']['render'])/1000);
		array_push($avg_render_times_rv, ($test_results_item['average_rv']['render'])/1000);

		array_push($avg_fullyLoaded_times_fv, ($test_results_item['average_fv']['fullyLoaded'])/1000);
		array_push($avg_fullyLoaded_times_rv, ($test_results_item['average_rv']['fullyLoaded'])/1000);

		array_push($avg_connections_fv, ($test_results_item['average_fv']['connections'])+0);
		array_push($avg_connections_rv, ($test_results_item['average_rv']['connections'])+0);

		array_push($avg_requests_fv, ($test_results_item['average_fv']['requests'])+0);
		array_push($avg_requests_rv, ($test_results_item['average_rv']['requests'])+0);

		array_push($avg_404_fv, ($test_results_item['average_fv']['responses_404'])+0);
		array_push($avg_404_rv, ($test_results_item['average_rv']['responses_404'])+0);

		// competitor stuff

		array_push($comp_avg_load_times_fv, ($test_results_item['comp_average_fv']['loadTime'])/1000);
		array_push($comp_avg_load_times_rv, ($test_results_item['comp_average_rv']['loadTime'])/1000);

		array_push($comp_avg_render_times_fv, ($test_results_item['comp_average_fv']['render'])/1000);
		array_push($comp_avg_render_times_rv, ($test_results_item['comp_average_rv']['render'])/1000);

		array_push($comp_avg_fullyLoaded_times_fv, ($test_results_item['comp_average_fv']['fullyLoaded'])/1000);
		array_push($comp_avg_fullyLoaded_times_rv, ($test_results_item['comp_average_rv']['fullyLoaded'])/1000);

		array_push($comp_avg_connections_fv, ($test_results_item['comp_average_fv']['connections'])+0);
		array_push($comp_avg_connections_rv, ($test_results_item['comp_average_rv']['connections'])+0);

		array_push($comp_avg_requests_fv, ($test_results_item['comp_average_fv']['requests'])+0);
		array_push($comp_avg_requests_rv, ($test_results_item['comp_average_rv']['requests'])+0);

		array_push($comp_avg_404_fv, ($test_results_item['comp_average_fv']['responses_404'])+0);
		array_push($comp_avg_404_rv, ($test_results_item['comp_average_rv']['responses_404'])+0);
		
	}
	//print_r($avg_load_times_fv);
	//print_r($avg_load_times_rv);
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				
				<strong>Render Time</strong><br>
			</div>
			<div class="panel-body ">
				<canvas id="renderChart" width="500" height="350"></canvas>
					<script>

						var data = {
							labels : [<?php echo '"' . implode('","', $test_dates) . '"'; ?>],
							datasets : [
								{
									fillColor : "rgba(128,178,226,0)",
									strokeColor : "rgba(128,178,226,1)",
									pointColor : "rgba(128,178,226,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_render_times_rv); ?>]
								},
								{
									fillColor : "rgba(29,80,129,0)",
									strokeColor : "rgba(29,80,129,1)",
									pointColor : "rgba(29,80,129,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_render_times_fv); ?>]
								},
								{
									fillColor : "rgba(166,206,57,0)",
									strokeColor : "rgba(166,206,57,1)",
									pointColor : "rgba(166,206,57,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $comp_avg_render_times_rv); ?>]
								},
								{
									fillColor : "rgba(119,150,37,0)",
									strokeColor : "rgba(119,150,37,1)",
									pointColor : "rgba(119,150,37,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $comp_avg_render_times_fv); ?>]
								}

							]
						}

						//Get the context of the canvas element we want to select
						var ctx2 = document.getElementById("renderChart").getContext("2d");
						var theRenderChart = new Chart(ctx2).Line(data);


					</script>
			</div>
			<div class="panel-footer clearfix">
				<div class="pull-left">
					<span class="avg-fv">XE.com Avg: <?php echo round(array_sum($avg_render_times_fv)/count($avg_render_times_fv), 2) . "s"; ?></span> 
					<span class="avg-rv">(<?php echo round(array_sum($avg_render_times_rv)/count($avg_render_times_rv), 2) . "s"; ?>)</span><br>
				</div>
				<div class="pull-right">
					<span class="comp-avg-fv">Oanda.com Avg: <?php echo round(array_sum($comp_avg_render_times_fv)/count($comp_avg_render_times_fv), 2) . "s"; ?></span> 
					<span class="comp-avg-rv">(<?php echo round(array_sum($comp_avg_render_times_rv)/count($comp_avg_render_times_rv), 2) . "s"; ?>)</span>
				</div>
			</div>
		</div>
		
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				
				<strong>Load Time</strong><br>
			</div>
			<div class="panel-body ">
				<canvas id="loadTimeChart" width="500" height="350"></canvas>
					<script>

						var data = {
							labels : [<?php echo '"' . implode('","', $test_dates) . '"'; ?>],
							datasets : [
								{
									fillColor : "rgba(128,178,226,0)",
									strokeColor : "rgba(128,178,226,1)",
									pointColor : "rgba(128,178,226,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_load_times_rv); ?>]
								},
								{
									fillColor : "rgba(29,80,129,0)",
									strokeColor : "rgba(29,80,129,1)",
									pointColor : "rgba(29,80,129,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_load_times_fv); ?>]
								},
								{
									fillColor : "rgba(166,206,57,0)",
									strokeColor : "rgba(166,206,57,1)",
									pointColor : "rgba(166,206,57,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $comp_avg_load_times_rv); ?>]
								},
								{
									fillColor : "rgba(119,150,37,0)",
									strokeColor : "rgba(119,150,37,1)",
									pointColor : "rgba(119,150,37,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $comp_avg_load_times_fv); ?>]
								}
							]
						}

						//Get the context of the canvas element we want to select
						var ctx1 = document.getElementById("loadTimeChart").getContext("2d");
						var theLoadTimeChart = new Chart(ctx1).Line(data);


					</script>
			</div>
			<div class="panel-footer clearfix">
				<div class="pull-left">
					<span class="avg-fv">XE.com Avg: <?php echo round(array_sum($avg_load_times_fv)/count($avg_load_times_fv), 2) . "s"; ?></span> 
					<span class="avg-rv">(<?php echo round(array_sum($avg_load_times_rv)/count($avg_load_times_rv), 2) . "s"; ?>)</span><br>
				</div>
				<div class="pull-right">
					<span class="comp-avg-fv">Oanda.com Avg: <?php echo round(array_sum($comp_avg_load_times_fv)/count($comp_avg_load_times_fv), 2) . "s"; ?></span> 
					<span class="comp-avg-rv">(<?php echo round(array_sum($comp_avg_load_times_rv)/count($comp_avg_load_times_rv), 2) . "s"; ?>)</span>
				</div>

			</div>
		</div>
		
	</div>
</div>
<div class="row">
	
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				
				<strong>Time to Fully Loaded</strong><br>
			</div>
			<div class="panel-body ">
				<canvas id="fullyLoadedChart" width="500" height="350"></canvas>
					<script>

						var data = {
							labels : [<?php echo '"' . implode('","', $test_dates) . '"'; ?>],
							datasets : [
								{
									fillColor : "rgba(128,178,226,0)",
									strokeColor : "rgba(128,178,226,1)",
									pointColor : "rgba(128,178,226,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_fullyLoaded_times_rv); ?>]
								},
								{
									fillColor : "rgba(29,80,129,0)",
									strokeColor : "rgba(29,80,129,1)",
									pointColor : "rgba(29,80,129,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_fullyLoaded_times_fv); ?>]
								},
								{
									fillColor : "rgba(166,206,57,0)",
									strokeColor : "rgba(166,206,57,1)",
									pointColor : "rgba(166,206,57,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $comp_avg_fullyLoaded_times_rv); ?>]
								},
								{
									fillColor : "rgba(119,150,37,0)",
									strokeColor : "rgba(119,150,37,1)",
									pointColor : "rgba(119,150,37,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $comp_avg_fullyLoaded_times_fv); ?>]
								}
							]
						}

						//Get the context of the canvas element we want to select
						var ctx3 = document.getElementById("fullyLoadedChart").getContext("2d");
						var theFullyLoadedChart = new Chart(ctx3).Line(data);


					</script>
			</div>
			<div class="panel-footer clearfix">
				<div class="pull-left">
					<span class="avg-fv">XE.com Avg: <?php echo round(array_sum($avg_fullyLoaded_times_fv)/count($avg_fullyLoaded_times_fv), 2) . "s"; ?></span> 
					<span class="avg-rv">(<?php echo round(array_sum($avg_fullyLoaded_times_rv)/count($avg_fullyLoaded_times_rv), 2) . "s"; ?>)</span><br>
				</div>
				<div class="pull-right">
					<span class="comp-avg-fv">Oanda.com Avg: <?php echo round(array_sum($comp_avg_fullyLoaded_times_fv)/count($comp_avg_fullyLoaded_times_fv), 2) . "s"; ?></span> 
					<span class="comp-avg-rv">(<?php echo round(array_sum($comp_avg_fullyLoaded_times_rv)/count($acomp_vg_fullyLoaded_times_rv), 2) . "s"; ?>)</span>
				</div>
			</div>
		</div>
		
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				
				<strong>Connections</strong><br>
			</div>
			<div class="panel-body ">
				<canvas id="connectionsChart" width="500" height="350"></canvas>
					<script>

						var data = {
							labels : [<?php echo '"' . implode('","', $test_dates) . '"'; ?>],
							datasets : [
								{
									fillColor : "rgba(128,178,226,0)",
									strokeColor : "rgba(128,178,226,1)",
									pointColor : "rgba(128,178,226,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_connections_rv); ?>]
								},
								{
									fillColor : "rgba(29,80,129,0)",
									strokeColor : "rgba(29,80,129,1)",
									pointColor : "rgba(29,80,129,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_connections_fv); ?>]
								},
								{
									fillColor : "rgba(166,206,57,0)",
									strokeColor : "rgba(166,206,57,1)",
									pointColor : "rgba(166,206,57,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $comp_avg_connections_rv); ?>]
								},
								{
									fillColor : "rgba(119,150,37,0)",
									strokeColor : "rgba(119,150,37,1)",
									pointColor : "rgba(119,150,37,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $comp_avg_connections_fv); ?>]
								}

							]
						}

						//Get the context of the canvas element we want to select
						var ctx4 = document.getElementById("connectionsChart").getContext("2d");
						var theConnectionsChart = new Chart(ctx4).Line(data);


					</script>
			</div>
			<div class="panel-footer clearfix">
				<div class="pull-left">
					<span class="avg-fv">XE.com Avg: <?php echo round(array_sum($avg_connections_fv)/count($avg_connections_fv), 2); ?></span> 
					<span class="avg-rv">(<?php echo round(array_sum($avg_connections_rv)/count($avg_connections_rv), 2); ?>)</span><br>
				</div>
				<div class="pull-right">
					<span class="comp-avg-fv">Oanda.com Avg: <?php echo round(array_sum($comp_avg_connections_fv)/count($comp_avg_connections_fv), 2); ?></span> 
					<span class="comp-avg-rv">(<?php echo round(array_sum($comp_avg_connections_rv)/count($comp_avg_connections_rv), 2); ?>)</span>
				</div>
			</div>
		</div>
		
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				
				<strong>Requests</strong><br></div>
			<div class="panel-body ">
				<canvas id="requestsChart" width="500" height="350"></canvas>
					<script>

						var data = {
							labels : [<?php echo '"' . implode('","', $test_dates) . '"'; ?>],
							datasets : [
								{
									fillColor : "rgba(128,178,226,0)",
									strokeColor : "rgba(128,178,226,1)",
									pointColor : "rgba(128,178,226,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_requests_rv); ?>]
								},
								{
									fillColor : "rgba(29,80,129,0)",
									strokeColor : "rgba(29,80,129,1)",
									pointColor : "rgba(29,80,129,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_requests_fv); ?>]
								},
								{
									fillColor : "rgba(166,206,57,0)",
									strokeColor : "rgba(166,206,57,1)",
									pointColor : "rgba(166,206,57,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $comp_avg_requests_rv); ?>]
								},
								{
									fillColor : "rgba(119,150,37,0)",
									strokeColor : "rgba(119,150,37,1)",
									pointColor : "rgba(119,150,37,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $comp_avg_requests_fv); ?>]
								}
							]
						}

						//Get the context of the canvas element we want to select
						var ctx5 = document.getElementById("requestsChart").getContext("2d");
						var theRequestsChart = new Chart(ctx5).Line(data);


					</script>
			</div>
			<div class="panel-footer clearfix">
				<div class="pull-left">
					<span class="avg-fv">XE.com Avg: <?php echo round(array_sum($avg_requests_fv)/count($avg_requests_fv), 2); ?></span> 
					<span class="avg-rv">(<?php echo round(array_sum($avg_requests_rv)/count($avg_requests_rv), 2); ?>)</span><br>
				</div>
				<div class="pull-right">
					<span class="comp-avg-fv">Oanda.com Avg: <?php echo round(array_sum($comp_avg_requests_fv)/count($comp_avg_requests_fv), 2); ?></span> 
					<span class="comp-avg-rv">(<?php echo round(array_sum($comp_avg_requests_rv)/count($comp_avg_requests_rv), 2); ?>)</span>
				</div>
			</div>
		</div>
		
	</div>
	<?php
		
		$panel_class = "panel-default"; 
		$error_count_fv = 0;
		$error_count_rv = 0;

		foreach ($avg_404_fv as $numba) {
			if($numba>0) {
				$error_count_fv++;
			}
		}
		foreach ($avg_404_rv as $numba) {
			if($numba>0) {
				$error_count_rv++;
			}
		}

		if($error_count_fv > 0 || $error_count_rv > 0) {
			$panel_class = "panel-danger";
		} 
	?>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel <?php echo $panel_class; ?> ">
			<div class="panel-heading">
				
				<strong>Responses_404</strong><br>
			</div>
			<div class="panel-body ">
				<canvas id="r404Chart" width="500" height="350"></canvas>
					<script>

						var data = {
							labels : [<?php echo '"' . implode('","', $test_dates) . '"'; ?>],
							datasets : [
								{
									fillColor : "rgba(128,178,226,0)",
									strokeColor : "rgba(128,178,226,1)",
									pointColor : "rgba(128,178,226,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_404_rv); ?>]
								},
								{
									fillColor : "rgba(29,80,129,0)",
									strokeColor : "rgba(29,80,129,1)",
									pointColor : "rgba(29,80,129,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_404_fv); ?>]
								},
								{
									fillColor : "rgba(166,206,57,0)",
									strokeColor : "rgba(166,206,57,1)",
									pointColor : "rgba(166,206,57,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $comp_avg_404_rv); ?>]
								},
								{
									fillColor : "rgba(119,150,37,0)",
									strokeColor : "rgba(119,150,37,1)",
									pointColor : "rgba(119,150,37,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $comp_avg_404_fv); ?>]
								}
							]
						}

						//Get the context of the canvas element we want to select
						var ctx6 = document.getElementById("r404Chart").getContext("2d");
						var theR404Chart = new Chart(ctx6).Line(data);


					</script>
			</div>
			<div class="panel-footer clearfix">
				<div class="pull-left">
					<span class="avg-fv">XE.com Avg: <?php echo round(array_sum($avg_404_fv)/count($avg_404_fv), 2); ?></span> 
					<span class="avg-rv">(<?php echo round(array_sum($avg_404_rv)/count($avg_404_rv), 2); ?>)</span><br>
				</div>
				<div class="pull-right">
					<span class="comp-avg-fv">Oanda.com Avg: <?php echo round(array_sum($comp_avg_404_fv)/count($comp_avg_404_fv), 2); ?></span> 
					<span class="comp-avg-rv">(<?php echo round(array_sum($comp_avg_404_rv)/count($comp_avg_404_rv), 2); ?>)</span>
				</div>
			</div>
		</div>
		
	</div>
</div>
	
<?php include("footer.php"); ?>