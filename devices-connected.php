<?php

	//include yii config file
	$config = include("protected/config/main.php");




	// Prevent caching.
	// header('Cache-Control: no-cache, must-revalidate');
	// header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

	// The JSON standard MIME header.
	// header('Content-type: application/json');

	// This ID parameter is sent by our javascript client.
	$id = $_GET['id'];

	// Here's some data that we want to send via JSON.
	// We'll include the $id parameter so that we
	// can show that it has been passed in correctly.
	// You can send whatever data you like.
	#$data = array("Hello", $id);

	// Send the data.
	#echo json_encode($data);
	//include yii config file
	$username=$config['components']['db']['username'];
	$password=$config['components']['db']['password'];
	$database=$config['components']['db']['username'];
	$dbHost=$config['params']['dbHost'];

	// Opens a connection to a mySQL server
	$connection=mysql_connect ($dbHost, $username, $password);
	if (!$connection) {
	die('Not connected : ' . mysql_error());
	}
	// Set the active mySQL database
	$db_selected = mysql_select_db($database, $connection);
	if (!$db_selected) {
	die ('Can\'t use db : ' . mysql_error());
	}

	echo '<meta http-equiv="refresh" content="30">';
	echo '<style>
	.grid {
		display: grid;
		grid-template-columns: 50% 50%;
	}
	div {
		text-align: center;
	}
	h1 {
		font-size: 2em;
	}
	h2 {
		font-size: 6em;
	}
	progress {
		-webkit-appearance: none;
		appearance: none;
		width: calc(100% - 40px);
		height: 50px;
		margin: 20px;
	}
	progress[value]::-webkit-progress-bar {
		background-color: #eee;
		border-radius: 2px;
		box-shadow: 0 2px 5px rgba(0, 0, 0, 0.25) inset;
	}
	progress[value]::-webkit-progress-value {
		background-image:
			-webkit-linear-gradient(-45deg, 
									transparent 33%, rgba(0, 0, 0, .1) 33%, 
									rgba(0,0, 0, .1) 66%, transparent 66%),
			-webkit-linear-gradient(top, 
									rgba(255, 255, 255, .25), 
									rgba(0, 0, 0, .25)),
			-webkit-linear-gradient(left, #09c, #f44);
	
		border-radius: 2px; 
		background-size: 80px 50px, 100% 100%, 100% 100%;
	}

	</style>
	';

	echo '<div class="grid">';

	$queryOld = "SELECT count(*) as total
		FROM device
		WHERE server_ip = '184.107.214.46'";

	$resultOld = mysql_query($queryOld);
	if (!$resultOld) {
		die('Invalid queryOld: ' . mysql_error());
	}

	// Iterate through the rows, adding XML nodes for each
	while ($row = mysql_fetch_assoc($resultOld)){
		echo "<div><h1>Old server (184.107.214.46)</h1><h2>" . $row['total'] . "</h2></div>";
		$old = $row['total'];
	}


	$queryNew = "SELECT count(*) as total
				FROM device
				WHERE server_ip = '165.227.244.59'";
				
	$resultNew = mysql_query($queryNew);
	if (!$resultNew) {
		die('Invalid queryNew: ' . mysql_error());
	}

	// Iterate through the rows, adding XML nodes for each
	while ($row = mysql_fetch_assoc($resultNew)){
		echo "<div><h1>New server (165.227.244.59)</h1><h2>" . $row['total'] . "</h2></div>";
		$new = $row['total'];
	}


	$total = $old + $new;


	$persent = ceil($new / $total * 100);
			
	echo '</div>';
	echo '<progress max="100" value="'.$persent.'"></progress>';
	echo '<div style="font-size:3em">'.$persent.' %</div>'
		




?>


</body>
</html>