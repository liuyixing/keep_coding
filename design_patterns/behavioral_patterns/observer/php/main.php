<?php

abstract class Subject
{
	private $_observers = array();

	function attach(Observer $observer)
	{
		$this->_observers[] = $observer;
	}

	function detach(Observer $observer)
	{
		foreach ($this->_observers as $k => $v)
		{
			if ($v === $observer)
			{
				unset($this->_observers[$k]);
				break;
			}
		}
	}

	function notify()
	{
		foreach ($this->_observers as $observer)
		{
			$observer->update($this);
		}
	}
}

class ConcreteSubject extends Subject
{

	private $_subjectState;

	function getState()
	{
		return $this->_subjectState;
	}

	function setState($state)
	{
		echo "subject setState: $state\n";
		$this->_subjectState = $state;
		$this->notify(); // notify observers
	}
}

interface Observer
{
	function update(Subject $subject);
}

class ConcreteObserver implements Observer
{
	private $_observerState;

	function update(Subject $subject)
	{
		$this->_observerState = $subject->getState();
		echo "update observer state: {$this->_observerState}\n";
	}
}

// test
$subject = new ConcreteSubject;
$observer1 = new ConcreteObserver;
$observer2 = new ConcreteObserver;

$subject->attach($observer1);
$subject->attach($observer2);

$subject->setState("state 1");
$subject->setState("state 2");

$subject->detach($observer1);
$subject->setState("state 3");
