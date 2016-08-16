<?php
/**
 * 原型模式
 *
 * 意图：使用原型实例来指定需要创建的对象的种类，通过拷贝这个原型来创建新对象。
 *
 * 动机：来源于一个乐谱编辑器。通过先自定义一个图形编辑器基本框架，然后由应用程序添加表示音符、休止符和五线谱的对象来实现。
 *
 * 为什么这个乐谱编辑器要应用原型模式？
 * 首先，框架定义了一个Graphic基类用来表示图形对象。其次，框架定义了Tool基类用来表示乐谱编辑器工具面板上的工具。
 * 然后，框架还预定义了一个GraphicTool工具类用来表示创建Graphic并且将它添加到乐谱中的工具。
 * 那么问题来了，GT是属于框架层的，而特定的G是属于应用层的。GT本身并不知道要怎么创建具体的G并且将它添加到乐谱中。
 * 我们可以使用派生GT的方法，每一个具体的G，我们都派生相应的GT。但是这样的话，会有很多GT类，类多都不是主要问题，主要是这些类唯一的区别就是创建的对象不同。
 * 所以，就使用原型模式，通过参数化GT，在实例化GT的时候，给定一个具体的G的原型，这样就等于有了具体的GT。就解决了类多的问题。
 *
 * 适用性：
 * 当一个系统需要独立于它的产品的创建、组合和表示，并且
 * *.当需要实例化的类是运行时指定的时候。或者
 * *.当需要避免创建平行于产品类继承层次的工厂类继承层次的时候。或者
 * *.当一个类的实例只能有少数不同状态组合中的一种时。预先实例化几个不同状态的对象然后通过clone来使用，会比每次都new来得方便。
 *
 * 参与者：Prototype、ConcretePrototype、Client
 *
 * 实现需要注意的地方：
 * 1.可以使用一个prototype manager。这样的话，就可以动态注册和删除原型。
 * 2.实现Clone接口的时候，需要注意浅拷贝和深拷贝问题。
 * 3.如果克隆对象需要重新初始化，需额外提供初始化接口，初始化时需要注意释放深拷贝中拷贝的变量的内存，否则会造成内存泄露。
 */
class Goo
{
	static $count = 0;
	public $id;

	function __construct()
	{
		$this->id = ++self::$count;
	}

	function __clone()
	{
		$this->id = ++self::$count;
	}
}
class Foo
{
	private $goo1;
	private $goo2;

	function __construct($goo1, $goo2)
	{
		$this->goo1 = $goo1;
		$this->goo2 = $goo2;
	}

	function __clone()
	{
		$this->goo2 = clone $this->goo2; // deep copy
	}
}

// test
$goo1 = new Goo;
$goo2 = new Goo;

$foo1 = new Foo($goo1, $goo2);
$foo2 = clone $foo1; // clone prototype。PHP会执行浅拷贝shallow copy
$foo3 = clone $foo1;

var_dump($foo1, $foo2, $foo3);




