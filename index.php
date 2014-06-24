<?php require_once("connections.php"); ?>
<?php require_once("functions.php"); ?>
<?php include("header.php"); ?>
<?php 
	$testID = "140621_Z6_51V";

	$xml_url = 'http://www.webpagetest.org/xmlResult/'.$testID.'/';
	//echo "url: ".$url."<br>";

	$xml = simplexml_load_file($xml_url);
	//var_dump($xml);

	$url = $xml->data->testUrl;
	$date = $xml->data->completed;
	$average = $xml->data->average;

	$sql = "INSERT INTO webpagetest (testID, url, date, average, runs) VALUES('$testID', '$url', '$date', '$average')";
	if ($stmt->prepare($sql)) {
    	$stmt->bind_param('iss', $varID, $var1, $var2);

    	if ($stmt->execute()) {
        	echo 'insert successful!';   //or something like that
    	}
	}
	

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