<?php
/**
 * 单例模式应该算是设计模式中最简单也是最常用的一个设计模式。
 */
class Application
{
	private $name;

	private function __construct()
	{	
	}

	public static function getInstance()
	{
		static $instance = NULL;
		if (NULL === $instance)
		{
			$instance = new self;
		}
		return $instance;
	}
	
	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}
} 

// 使用new创建
//$app = new Application; // fatal error

// 调用getInstance方法返回对象
$app = Application::getInstance();
$app->setName("LOL手机盒子");
echo $app->getName("LOL手机盒子"); // ouput: LOL手机盒子 

// 通过反射来创建对象
$app_class = new ReflectionClass("Application");
//$app = $app_class->newInstance(); // fatal error: ReflectionException
$app = $app_class->newInstanceWithoutConstructor(); // 创建成功，但是没有调用构造函数，对象状态可能暂时不完整 (PHP >= 5.4.0)
// 继续反射构造函数，修改访问权限
$ctor = $app_class->getConstructor();
$ctor->setAccessible(true);
$ctor->invoke($app); // 此处只是将构造函数当成普通的函数来调用，实际上并没有重新分配对象内存，只是将第一个参数当作函数执行时的$this上下文
var_dump($app);
