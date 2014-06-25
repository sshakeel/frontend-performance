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

	$avg_load_times_fv = array();
	$avg_load_times_rv = array();
	$test_dates = array();
	foreach($test_results as $test_results_item){
		//echo "Load Time: ".$test_results_item['average_fv']['loadTime']."<br>";
		//echo "Load Time(int): " . (($test_results_item['average_fv']['loadTime'])/1000) . "<br><hr>";
		array_push($avg_load_times_fv, ($test_results_item['average_fv']['loadTime'])/1000);
		array_push($avg_load_times_rv, ($test_results_item['average_rv']['loadTime'])/1000);
		array_push($test_dates, (string)$test_results_item['testdate']);
	}
	//print_r($avg_load_times_fv);
	//print_r($avg_load_times_rv);
?>

<div class="row">
	<div class="col-md-12">
		<canvas id="myChart" width="600" height="400"></canvas>
		<script>

			var data = {
				labels : [<?php echo implode(',', $test_dates); ?>],
				datasets : [
					{
						fillColor : "rgba(220,220,220,0.5)",
						strokeColor : "rgba(220,220,220,1)",
						pointColor : "rgba(220,220,220,1)",
						pointStrokeColor : "#fff",
						data : [<?php echo implode(',', $avg_load_times_rv); ?>]
					},
					{
						fillColor : "rgba(151,187,205,0.5)",
						strokeColor : "rgba(151,187,205,1)",
						pointColor : "rgba(151,187,205,1)",
						pointStrokeColor : "#fff",
						data : [<?php echo implode(',', $avg_load_times_fv); ?>]
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