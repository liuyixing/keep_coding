<?php
/**
 * 建造者模式
 * 
 * 目的：将一个复杂对象的构建与它的表示分离，使得同样的构建过程可以创建不同的表示。
 * （Separate the construction of a complex object from its representation so that the same construction process can create different representations.）
 *
 * 从这句话中可以看出，这个模式的重点在于分离对象的表示。因为有时候对象的构建过程会很复杂但不常变化，而对象的表示却有可能需要经常变化。
 *
 * 动机：来源于一个文本格式转换器。需求是使用同一个文本解析器解析文本，使用不同的转换器将解析出的文本转换到其他格式。
 *
 * 什么时候用？
 * 1.创建复杂对象的算法需要独立于对象的组成部分和它们的组装方式。（什么意思呢？想象一下我们要开发一个Mysql类用来访问数据库，如果直接让开发人员写SQL语句的话可能不安全，所以我们来设计一个支持链式调用来创建SQL语句的Mysql类，这样就分离了SQL语句的创建过程和它的创建细节。）
 * 2.构建过程必须允许生成不同的表示。（这个比较好理解，就像动机中提到的文本格式装换器就应该使用这个模式）
 */
class Mysql // ConcreteBuilder // 这里没有定义Builder接口，其实也可以定义，不同数据库支持的sql语法应该有区别，虽然本例子中没有体现。
{
	private $sql; // Product

	public function select($field)
	{
		$this->sql = "select " . $field;
		return $this;
	}

	public function insert($table)
	{
		$this->sql = "insert into " . $table;
		return $this;
	}

	public function update($table)
	{
		$this->sql = "update " . $table;
		return $this;
	}

	public function set($field)
	{
		$this->sql .= " set " . $field;
		return $this;
	}

	public function delete($table)
	{
		$this->sql = "delete from " . $table;
		return $this;
	}

	public function from($table)
	{
		$this->sql .= " from " . $table;
		return $this;
	}

	public function where($where)
	{
		$this->sql .= " where " . $where;
		return $this;
	}

	public function orderby($orderby)
	{
		$this->sql .= " orderby " . $orderby;
		return $this;
	}

	public function limit($limit)
	{
		$this->sql .= " limit " . $limit;
		return $this;
	}

	public function execute()
	{
		echo $this->sql; // 模拟执行sql
	}
}

class UserDao // Director
{
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function getUserById($uid)
	{
		return $this->db
			->select("*")
			->from("user")
			->where("uid = $uid")
			->execute();
	}

	public function updateUserById($field, $uid)
	{
		return $this->db
			->update("user")
			->set($field)
			->where("uid = $uid")
			->execute();
	}
}

// test
$mysql = new Mysql;
$user_dao = new UserDao($mysql);
$user_dao->getUserById(26);
$user_dao->updateUserById("name = '选择'", 26);
