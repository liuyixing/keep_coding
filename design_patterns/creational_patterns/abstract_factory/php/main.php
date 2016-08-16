<?php
/**
 * 抽象工厂模式
 *
 * 意图：提供一个接口（接口类），用于创建一系列相关或者相互依赖的对象而无需指定它们的具体实现类。
 *
 * 动机：来源于一个用户界面工具包。需求是通过切换工厂类，就能够改变整个用户界面中各种组件的外观和行为。
 *
 * 适用性：
 * 1.当一个系统需要独立于它的产品的创建、组合和表示的时候。(这里只是强调独立于，有可能只是一个产品族）
 * 2.当一个系统需要配置成使用多个产品族之中的一个的时候。(这里强调多个产品族）
 * 3.当一系列相关的产品对象被设计为一起使用，并且你希望实施这个限制的时候。(这里强调的是限制产品对象要一起使用）
 * 4.当你想提供一个产品类库，但是只想暴露它们的接口而不是实现的时候。(这里强调的是隐藏产品库的实现）
 *
 * 参与者：AbstractFactory、ConcreteFactory、AbstractProduct、ConcreteProduct、Client
 *
 * 优点：
 * 1.隔离了具体的产品实现类。应用程序只需要跟抽象接口打交道。
 * 2.使得修改产品族很容易。换一个新的ConcreteFactory就可以了。
 * 3.促进了产品之间的一致性。应用程序同一时间只应该使用一个产品族的产品，抽象工厂模式天生就能保证这个一致性。
 * 
 * 缺点：
 * 1.加入新的产品会很困难。因为所有ConcreteFactory都要修改。
 * 2.为某个产品加入一个新的操作也会有问题，在动态类型中还好，在静态类型语言中就需要强制类型转换。
 * 
 * 实现的一些建议：
 * 1.将ConcreteFactory实现成单例。
 * 2.如果产品族太多的话，可以通过原型模式来实现ConcreteFactory。这样的话，就不需要很多ConcreteFactory。
 * 3.在动态类型语言中，比如PHP中，可以将ConcreteFactory实现为参数化的工厂，就是只有一个带一个参数的方法的工厂。这样的话，加新的产品就会灵活很多。但是在静态类型语言中依然蛋疼。
 */
interface ProductA
{
	function getName();	
}	

interface ProductB
{
	function getName();
}

interface Factory
{
	function newProductA();

	function newProductB();
}

class ProductAImpl1
{
	function getName()
	{
		return __CLASS__;
	}
}

class ProductAImpl2
{
	function getName()
	{
		return __CLASS__;
	}
}

class ProductBImpl1
{
	function getName()
	{
		return __CLASS__;
	}

}

class ProductBImpl2
{
	function getName()
	{
		return __CLASS__;
	}
}

class FactoryImpl1
{
	function newProductA()
	{
		return new ProductAImpl1;
	}

	function newProductB()
	{
		return new ProductBImpl1;
	}

	static function getInstance()
	{
		static $instance = NULL;
		if (NULL === $instance)
		{
			$instance = new self;
		}
		return $instance;
	}
}

class FactoryImpl2
{
	function newProductA()
	{
		return new ProductAImpl2;
	}

	function newProductB()
	{
		return new ProductBImpl2;
	}
	
	static function getInstance()
	{
		static $instance = NULL;
		if (NULL === $instance)
		{
			$instance = new self;
		}
		return $instance;
	}
}

// test
$f = FactoryImpl1::getInstance();
$pa = $f->newProductA();
$pb = $f->newProductB();
echo $pa->getName();
echo $pb->getName();

$f = FactoryImpl2::getInstance();
$pa = $f->newProductA();
$pb = $f->newProductB();
echo $pa->getName();
echo $pb->getName();

