<?php

$connection = mysqli_connect("localhost", "root", "", "test");

$text = isset($_REQUEST['text']) ? $text = mysqli_escape_string($connection, $_REQUEST['text']) : $text = NULL;

if (strlen($text) > 0) {
	mysqli_query($connection, "INSERT INTO shopping (message, ip) VALUES ('" . $text . "', '" . $_SERVER['REMOTE_ADDR'] . "')");
	$result = retrieveResults();
} else {
	if (isset($_REQUEST['del'])) clearMyShopping();
	$result = retrieveResults();
}
function retrieveResults()
{
	global $connection;
	$queryResult = mysqli_query($connection, "SELECT message FROM shopping WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "'");
	$result = [];
	while ($row = mysqli_fetch_array($queryResult)) {
		$result[] = $row['message'];
	}
	return $result;
}
function clearMyShopping()
{
	global $connection;
	mysqli_query($connection, "DELETE FROM shopping WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "'");
}
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css/main.css">
	<title>Shopping list app</title>
</head>

<body>
	<div class="cont">
		<form action="index.php">
			<ul class="ui">
				<li>
					<textarea name='text'></textarea>
				</li>
				<li>
					<input type="submit" value="Save" class="button">
					<input type="submit" value="Clear List" name="del" class="button">
				</li>
			</ul>
		</form>
		<ul class="listCont">
			<?php foreach ($result as $item) : ?>
				<li class="list-item"><?= $item ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</body>

</html>
