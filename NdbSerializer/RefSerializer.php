<?php

namespace NdbSerializer;

/**
 * @author Jan Marek
 */
class RefSerializer implements ISerializer
{

	private $property;

	private $serializer;

	public function __construct($property, ISerializer $serializer)
	{
		$this->property = $property;
		$this->serializer = $serializer;
	}

	public function serialize($data)
	{
		$refData = $data->ref($this->property);
		return $this->serializer->serialize($refData);
	}

}