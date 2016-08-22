<?php

interface Visitor
{
	function visitElementA(ElementA $elementA);
	function visitElementB(ElementB $elemetnB);
	function visitCompositeElement(CompositeElement $compositeElement);
}

interface Element
{
	function accept(Visitor $visitor);
}

class ElementA implements Element
{
	function accept(Visitor $visitor)
	{
		$visitor->visitElementA($this);
	}
}

class ElementB implements Element
{
	function accept(Visitor $visitor)
	{
		$visitor->visitElementB($this);
	}	
}

class CompositeElement implements Element
{
	private $elementA;
	private $elementB;

	function __construct(Element $elementA, Element $elementB)
	{
		$this->elementA = $elementA;
		$this->elementB = $elementB;
	}

	function accept(Visitor $visitor)
	{
		$this->elementA->accept($visitor);
		$this->elementB->accept($visitor);
		$visitor->visitCompositeElement($this);	
	}
}


class VisitorA implements Visitor
{
	function visitElementA(ElementA $elementA)
	{
		echo __CLASS__ . __FUNCTION__ . PHP_EOL;
	}
	
	function visitElementB(ElementB $elementB)
	{
		echo __CLASS__ . __FUNCTION__ . PHP_EOL;
	}

	function visitCompositeElement(CompositeElement $compositeElement)
	{
		echo __CLASS__ . __FUNCTION__ . PHP_EOL;
	}
}

class VisitorB implements Visitor
{
	function visitElementA(ElementA $elementA)
	{
		echo __CLASS__ . __FUNCTION__ . PHP_EOL;
	}

	function visitElementB(ElementB $elementB)
	{
		echo __CLASS__ . __FUNCTION__ . PHP_EOL;
	}

	function visitCompositeElement(CompositeElement $compositeElement)
	{
		echo __CLASS__ . __FUNCTION__ . PHP_EOL;
	}
}

// test 
$visitorA = new VisitorA;
$visitorB = new VisitorB;

$elementA = new ElementA; 
$elementB = new ElementB;
$compositeElement = new CompositeElement($elementA, $elementB);

$compositeElement->accept($visitorA);
$compositeElement->accept($visitorB);
