<head>
	<meta charset="UTF-8" />
	<title>EwA_WS2021-2022</title>
</head>
<body>
 <?php
echo $_SERVER['HTTP_USER_AGENT'];

echo "<br>";

echo strstr($_SERVER['HTTP_USER_AGENT'], 'Chrome');
?>
</body>