<?php
set_time_limit(0); // default 30s

$ip = "127.0.0.1";
$port = 10086; // 小于1000要sudo来跑这个脚本

if (($serv = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false)
{
	exit("socket_create() failed, due to: " . socket_strerror(socket_last_error()) . PHP_EOL);
}

if (socket_bind($serv, $ip, $port) === false)
{
	exit("socket_bind() failed, due to: " . socket_strerror(socket_last_error()) . PHP_EOL);
}

if (socket_listen($serv, 5) === false)
{
	exit("socket_listen failed, due to: " . socket_strerror(socket_last_error()) . PHP_EOL);
}

do
{
	if (($cli = socket_accept($serv)) === false)
	{
		exit("socket_accept() falied, due to: " . socket_strerror(socket_last_error()) . PHP_EOL);
	}
	echo "Accpet" . PHP_EOL;

	do
	{
		if (false === ($cmd = socket_read($cli, 2048, PHP_NORMAL_READ)))
		{
			echo "socket_read() failed, due to: " . socket_strerror(socket_last_error()) . PHP_EOL;
			break 2;
		}
		echo "Read $cmd" . PHP_EOL;

		$cmd = trim($cmd);
		if ($cmd == "REQ")
		{
			echo "2pc phase 1" . PHP_EOL;
			socket_write($cli, "OK\n", 3);
			continue;
		}
		elseif ($cmd == "COMMIT")
		{
			echo "2pc phase 2:" . PHP_EOL;
			socket_write($cli, "OK\n", 3);
			continue;
		}
		else
		{
			break;
		}
	}
	while (true);
	socket_close($cli);
}
while (true);

socket_close($serv);
