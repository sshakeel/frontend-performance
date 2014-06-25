<?php require_once("connections.php"); ?>
<?php require_once("functions.php"); ?>
<?php include("header.php"); ?>
<?php 
	
	$test_results = array();

	$result = mysql_query("SELECT * FROM webpagetest WHERE testdate >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
	
	$i = 0;
	
	while($row = mysql_fetch_array($result)){
		$test_results[$i]['id'] = $row['id'];
		$test_results[$i]['testID'] = $row['testID'];
		$test_results[$i]['url'] = $row['url'];
		$test_results[$i]['testdate'] = $row['testdate'];
		$test_results[$i]['average_fv'] = json_decode($row['average_fv'], true);
		$i++;
	}

	$load_times = array(23, 31, 45, 6, 11, 78, 21, 93);
	// foreach($test_results[$i]['average_fv'] as $average_fv_item){
	// 	array_push($load_times, intval($average_fv_item['loadTime']));
	// }

?>

<div class="row">
	<div class="col-md-12">
		<canvas id="myChart" width="600" height="400"></canvas>
		<script>
			
			loadTimeData = new array(<?php echo implode(',', $load_times); ?>);

			var data = {
				labels : ["January","February","March","April","May","June","July"],
				datasets : [
					{
						fillColor : "rgba(220,220,220,0.5)",
						strokeColor : "rgba(220,220,220,1)",
						pointColor : "rgba(220,220,220,1)",
						pointStrokeColor : "#fff",
						data : loadTimeData
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