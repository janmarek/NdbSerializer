<?php

namespace NdbSerializer;

/**
 * @author Jan Marek
 */
class ManyToManySerializer implements ISerializer
{

	private $property;

	private $via;

	private $serializer;

	public function __construct($property, $via, ISerializer $serializer)
	{
		$this->property = $property;
		$this->via = $via;
		$this->serializer = $serializer;
	}

	public function serialize($data)
	{
		$serialized = array();

		foreach ($data->related($this->via) as $item) {
			$serialized[] = $this->serializer->serialize($item->ref($this->property));
		}

		return $serialized;
	}

}