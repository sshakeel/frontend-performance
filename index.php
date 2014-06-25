<?php require_once("connections.php"); ?>
<?php require_once("functions.php"); ?>
<?php include("header.php"); ?>
<?php 
	
	
	$result = mysql_query("SELECT * FROM webpagetest WHERE '$where'");
	$row = mysql_fetch_array($result);
	return $row;

?>

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