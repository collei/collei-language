<?php
namespace ColleiLang;

/**
 *	Embodies a user-defined enumerable and their abilities
 *
 *	@author Collei Inc. <collei@collei.com.br>
 *	@author Alarido <alarido.su@gmail.com>
 *	@since 2022-08-08
 */
abstract class ColleiEnum
{
	/**
	 *	@const array ALLOWED
	 */
	public const ALLOWED = [];

	/**
	 *	@var string $value
	 */
	protected $value = '';

	/**
	 *	Builds a named instance
	 *
	 *	@param	string	$value
	 */
	private function __construct(string $value)
	{
		$this->value = $value;
	}

	/**
	 *	Converts itself into string
	 *
	 *	@return	string
	 */
	public function __toString()
	{
		return $this->value;
	}

	/**
	 *	Returns the value name 
	 *
	 *	@return	string
	 */
	public function getName()
	{
		return $this->value;
	}

	/**
	 *	Returns if both values match 
	 *
	 *	@param	static|string	$value
	 *	@return	bool
	 */
	public function is($value)
	{
		if (\is_string($value)) {
			return $value === $this->value;
		} elseif ($value instanceof static) {
			return $value->value === $this->value;
		}
		//
		return false;
	}

	/**
	 *	Returns if the contained value is one of the list
	 *
	 *	@param	static|string	...$values
	 *	@return	bool
	 */
	public function in(...$values)
	{
		$result = false;
		//
		foreach ($values as $value) {
			$result = $result || $this->is($value);
		}
		//
		return $result;
	}

	/**
	 *	Returns an instance based upon the string value
	 *
	 *	@return	string
	 */
	public static function new(string $value)
	{
		$value = \ucfirst(\strtolower(\trim($value)));
		//
		if (\in_array($value, static::ALLOWED)) {
			return new static($value);
		}
		//
		return null;
	}

	/**
	 *	Returns an array of instances of values 
	 *
	 *	@return	string
	 */
	public static function asArray()
	{
		$values = [];
		//
		foreach (static::ALLOWED as $value) {
			$values[] = new static($value);
		}
		//
		return $values;
	}

}

