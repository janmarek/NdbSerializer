<?php

namespace NdbSerializer;

/**
 * @author Jan Marek
 */
class ValueSerializer implements ISerializer
{

	private $property;

	public function __construct($property)
	{
		$this->property = $property;
	}

	public function serialize($data)
	{
		return $data->{$this->property};
	}

}