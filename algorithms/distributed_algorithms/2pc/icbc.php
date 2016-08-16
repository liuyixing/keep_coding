<?php
set_time_limit(0); // default 30s

$ip = "127.0.0.1";
$port = 10086; // 小于1000要sudo来跑这个脚本

if (($cli = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false)
{
	exit("socket_create() failed, due to: " . socket_strerror(socket_last_error()) . PHP_EOL);
}

if (socket_connect($cli, $ip, $port) === false)
{
	exit("socket_connect failed, due to: " . socket_strerror(socket_last_error()) . PHP_EOL);
}

socket_write($cli, "REQ\n", 4);
echo "REQ" . PHP_EOL;
$ret = socket_read($cli, 2048);
echo "RET $ret" . PHP_EOL;
if ($ret == "OK\n")
{
	socket_write($cli, "COMMIT\n", 7);
	echo "COMMIT" . PHP_EOL;
	$ret = socket_read($cli, 2048);
	echo "RET $ret" . PHP_EOL;
	if ($ret == "OK\n")
	{
		echo "DONE" . PHP_EOL;
	}
}
echo "FAILED" . PHP_EOL;
socket_close($cli);

