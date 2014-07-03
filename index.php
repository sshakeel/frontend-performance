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

		array_push($avg_connections_fv, $test_results_item['average_fv']['connections']);
		array_push($avg_connections_rv, $test_results_item['average_rv']['connections']);

		array_push($avg_requests_fv, $test_results_item['average_fv']['requests']);
		array_push($avg_requests_rv, $test_results_item['average_rv']['requests']);

		array_push($avg_404_fv, $test_results_item['average_fv']['responses_404']);
		array_push($avg_404_rv, $test_results_item['average_rv']['responses_404']);
		
	}
	//print_r($avg_load_times_fv);
	//print_r($avg_load_times_rv);
?>

<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">Load Time (First View vs Repeat)</div>
			<div class="panel-body ">
				<canvas id="loadTimeChart" width="320" height="200"></canvas>
					<script>

						var data = {
							labels : [<?php echo '"' . implode('","', $test_dates) . '"'; ?>],
							datasets : [
								{
									fillColor : "rgba(100,100,100,0.3)",
									strokeColor : "rgba(220,220,220,1)",
									pointColor : "rgba(220,220,220,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_load_times_rv); ?>]
								},
								{
									fillColor : "rgba(151,187,205,0.3)",
									strokeColor : "rgba(151,187,205,1)",
									pointColor : "rgba(151,187,205,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_load_times_fv); ?>]
								}
							]
						}

						//Get the context of the canvas element we want to select
						var ctx1 = document.getElementById("loadTimeChart").getContext("2d");
						var theLoadTimeChart = new Chart(ctx1).Line(data);


					</script>
				</div>
		</div>
		
	</div>
	
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">Render Time (First View vs Repeat) <span class="pull-right"><span class="avg-fv"><?php echo array_sum($avg_render_times_fv)/count($avg_render_times_fv); ?></span><span class="avg-rv">(<?php echo array_sum($avg_render_times_rv)/count($avg_render_times_rv); ?>)</span></span></div>
			<div class="panel-body ">
				<canvas id="renderChart" width="320" height="200"></canvas>
					<script>

						var data = {
							labels : [<?php echo '"' . implode('","', $test_dates) . '"'; ?>],
							datasets : [
								{
									fillColor : "rgba(100,100,100,0.3)",
									strokeColor : "rgba(220,220,220,1)",
									pointColor : "rgba(220,220,220,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_render_times_rv); ?>]
								},
								{
									fillColor : "rgba(151,187,205,0.3)",
									strokeColor : "rgba(151,187,205,1)",
									pointColor : "rgba(151,187,205,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_render_times_fv); ?>]
								}
							]
						}

						//Get the context of the canvas element we want to select
						var ctx2 = document.getElementById("renderChart").getContext("2d");
						var theRenderChart = new Chart(ctx2).Line(data);


					</script>
				</div>
		</div>
		
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">Time to Fully Loaded (First View vs Repeat) <span class="pull-right"><span class="avg-fv"><?php echo array_sum($avg_fullyLoaded_times_fv)/count($avg_fullyLoaded_times_fv); ?></span><span class="avg-rv">(<?php echo array_sum($avg_fullyLoaded_times_rv)/count($avg_fullyLoaded_times_rv); ?>)</span></span></div>
			<div class="panel-body ">
				<canvas id="fullyLoadedChart" width="320" height="200"></canvas>
					<script>

						var data = {
							labels : [<?php echo '"' . implode('","', $test_dates) . '"'; ?>],
							datasets : [
								{
									fillColor : "rgba(100,100,100,0.3)",
									strokeColor : "rgba(220,220,220,1)",
									pointColor : "rgba(220,220,220,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_fullyLoaded_times_rv); ?>]
								},
								{
									fillColor : "rgba(151,187,205,0.3)",
									strokeColor : "rgba(151,187,205,1)",
									pointColor : "rgba(151,187,205,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_fullyLoaded_times_fv); ?>]
								}
							]
						}

						//Get the context of the canvas element we want to select
						var ctx3 = document.getElementById("fullyLoadedChart").getContext("2d");
						var theFullyLoadedChart = new Chart(ctx3).Line(data);


					</script>
				</div>
		</div>
		
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">Connections (First View vs Repeat) <span class="pull-right"><span class="avg-fv"><?php echo array_sum($avg_connections_fv)/count($avg_connections_fv); ?></span><span class="avg-rv">(<?php echo array_sum($avg_connections_rv)/count($avg_connections_rv); ?>)</span></span></div>
			<div class="panel-body ">
				<canvas id="connectionsChart" width="320" height="200"></canvas>
					<script>

						var data = {
							labels : [<?php echo '"' . implode('","', $test_dates) . '"'; ?>],
							datasets : [
								{
									fillColor : "rgba(100,100,100,0.3)",
									strokeColor : "rgba(220,220,220,1)",
									pointColor : "rgba(220,220,220,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_connections_rv); ?>]
								},
								{
									fillColor : "rgba(151,187,205,0.3)",
									strokeColor : "rgba(151,187,205,1)",
									pointColor : "rgba(151,187,205,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_connections_fv); ?>]
								}
							]
						}

						//Get the context of the canvas element we want to select
						var ctx4 = document.getElementById("connectionsChart").getContext("2d");
						var theConnectionsChart = new Chart(ctx4).Line(data);


					</script>
				</div>
		</div>
		
	</div>
	
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">Requests (First View vs Repeat) <span class="pull-right"><span class="avg-fv"><?php echo array_sum($avg_requests_fv)/count($avg_requests_fv); ?></span><span class="avg-rv">(<?php echo array_sum($avg_requests_rv)/count($avg_requests_rv); ?>)</span></span></div>
			<div class="panel-body ">
				<canvas id="requestsChart" width="320" height="200"></canvas>
					<script>

						var data = {
							labels : [<?php echo '"' . implode('","', $test_dates) . '"'; ?>],
							datasets : [
								{
									fillColor : "rgba(100,100,100,0.3)",
									strokeColor : "rgba(220,220,220,1)",
									pointColor : "rgba(220,220,220,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_requests_rv); ?>]
								},
								{
									fillColor : "rgba(151,187,205,0.3)",
									strokeColor : "rgba(151,187,205,1)",
									pointColor : "rgba(151,187,205,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_requests_fv); ?>]
								}
							]
						}

						//Get the context of the canvas element we want to select
						var ctx5 = document.getElementById("requestsChart").getContext("2d");
						var theRequestsChart = new Chart(ctx5).Line(data);


					</script>
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
	<div class="col-md-4">
		<div class="panel <?php echo $panel_class; ?> ">
			<div class="panel-heading">Responses_404 (First View vs Repeat) <span class="pull-right"><span class="avg-fv"><?php echo array_sum($avg_404_fv)/count($avg_404_fv); ?></span><span class="avg-rv">(<?php echo array_sum($avg_404_rv)/count($avg_404_rv); ?>)</span></span></div>
			<div class="panel-body ">
				<canvas id="r404Chart" width="320" height="200"></canvas>
					<script>

						var data = {
							labels : [<?php echo '"' . implode('","', $test_dates) . '"'; ?>],
							datasets : [
								{
									fillColor : "rgba(100,100,100,0.3)",
									strokeColor : "rgba(220,220,220,1)",
									pointColor : "rgba(220,220,220,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_404_rv); ?>]
								},
								{
									fillColor : "rgba(151,187,205,0.3)",
									strokeColor : "rgba(151,187,205,1)",
									pointColor : "rgba(151,187,205,1)",
									pointStrokeColor : "#fff",
									data : [<?php echo implode(',', $avg_404_fv); ?>]
								}
							]
						}

						//Get the context of the canvas element we want to select
						var ctx6 = document.getElementById("r404Chart").getContext("2d");
						var theR404Chart = new Chart(ctx6).Line(data);


					</script>
				</div>
		</div>
		
	</div>
</div>
	
<?php include("footer.php"); ?>