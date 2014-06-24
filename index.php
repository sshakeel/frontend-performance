<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.css">
	<script src="script.js"></script>
	<title></title>
</head>
<?php 
	$testID = "140621_Z6_51V";

	$url = 'http://www.webpagetest.org/xmlResult/'.$testID.'/';
	//echo "url: ".$url."<br>";

		$xml = simplexml_load_file($url);
		//var_dump($xml);

	

	// or...........
	// foreach ($xml->bbb->cccc as $element) {
	//   foreach($element as $key => $val) {
	//    echo "{$key}: {$val}";
	//   }
	// }
?>
<style>
	.no-padding {padding: 0;}
</style>
<body>
	<div class="container">
		
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
	</div>
</body>
</html>