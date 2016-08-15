<?php
/**
 * 工厂方法模式
 *
 * 意图：定义一个创建对象的接口，让子类决定实例化哪个类。工厂方法模式让一个类的实例化延迟到了子类当中。
 *
 * 动机：框架使用抽象类来定义和维护对象之间的关系。一个框架通常也要负责创建这些对象。(举了一个Application和Document的例子)
 *
 * 但是，这里有一个问题。就是框架必须要实例化类，但是框架自身只知道它定义的抽象类，而这些抽象类是不能实例化的。
 *
 * 工厂方法模式就是解决了上面这个问题。通过定义一个工厂方法，封装了具体需要创建哪个子类的细节，将这些细节搬到了框架之外(由使用者决定创建哪个子类)。
 * 
 * 适用性：
 * 1.当一个类一定要创建一些对象，但是它不能预知这些对象是属于哪个类的时候。(动机中描述的情况)
 * 2.当一个类希望由它的子类来指定它要创建哪些对象。(咋看，这种情况跟1貌似一样，其实不然。在1中，是一个类一定要创建对象，但不知道创建什么。就是说在这个类中不能实现创建指定对象的目标。但是在2中，这个目标有可能是可以实现的，只是出于其他的一些扩展性考虑，可以由子类重写创建方法来创建其他的类)(GoF中本章的效果1中所指的情况)
 * 3.当一个类需要将它的部分责任委托给其中一个帮助子类，并且你希望将“哪一个帮助子类是委托类”这一信息局部化的时候。(GoF中本章的效果2中所指的情况)(这句话中提到局部化，我觉得是相对于全局来说的，范围更小了，设计成由局部指定最终的委托类。)
 *
 * 参与者：Product、ConcreteProduct、Creator、ConcreteCreator
 * 
 * 实现：工厂方法模式实现起来有好些变种，其中主要有
 * 1.Creator是抽象类，并且自身不实现工厂方法，由它的子类实现工厂方法。对应适用性1
 * 2.Creator是具体类，自身提供默认的工厂方法实现。对应适用性2
 * 3.工厂方法接受一个参数，根据这个参数来创建对象。
 *
 * 我的理解：
 * 其实工厂方法就是通过加入一层间接，避免通过硬编码来创建对象，从而满足开闭原则。
 */
interface Logger // Product
{
	const DEBUG = 1;
	const INFO = 2;
	const WARN = 3;
	const ERROR = 4;
	const FATAL = 5;

	public function debug($message);

	public function info($message);

	public function warn($message);

	public function error($message);

	public function fatal($message);

	public function log($message, $level);
}
// 将日志写到本地文件
class FileLogger implements Logger // ConcreteProduct
{
	public function debug($message)
	{
		echo "file: debug $message";
	}

	public function info($message)
	{
		echo "file: info $message";
	}

	public function warn($message)
	{
		echo "file: warn $message";
	}

	public function error($message)
	{
		echo "file: error $message";
	}

	public function fatal($message)
	{
		echo "file: fatal $message)";
	}

	public function log($message, $level)
	{
		echo "file: $level $message)";
	}
}
// 将日志走Udp发送到日志服务器
class UdpLogger implements Logger // ConcreteProduct
{	
	public function debug($message)
	{
		echo "udp: debug $message";
	}

	public function info($message)
	{
		echo "udp: info $message";
	}

	public function warn($message)
	{
		echo "udp: warn $message";
	}

	public function error($message)
	{
		echo "udp: error $message)";
	}

	public function fatal($message)
	{
		echo "udp: fatal $message)";
	}

	public function log($message, $level)
	{
		echo "udp: $level $message)";
	}
}

// 按照实现3来实现，并且将工厂方法静态化
class LoggerFactory // Creator
{
	public static function getLogger($type)
	{
		if ($type == 'file')
		{
			static $file_logger = NULL;
			if (NULL === $file_logger)
			{
				$file_logger = new FileLogger;
			}
			return $file_logger;

		}
		else if ($type == 'udp')
		{
			static $udp_logger = NULL;
			if (NULL === $udp_logger)
			{
				$udp_logger = new UdpLogger;
			}
			return $udp_logger;
		}
	}
}

// test
$log = LoggerFactory::getLogger("file");
$log->info("我是info消息");
$log->error("我是error消息");

$log = LoggerFactory::getLogger("udp");
$log->debug("我是debug消息");
$log->info("我是info消息");
$log->error("我是error消息");
