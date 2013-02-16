<?php

namespace NdbSerializer;

/**
 * @author Jan Marek
 */
class CollectionSerializer implements ISerializer
{

	private $serializer;

	public function __construct(ISerializer $serializer)
	{
		$this->serializer = $serializer;
	}

	public function serialize($data)
	{
		$serialized = array();

		foreach ($data as $item) {
			$serialized[] = $this->serializer->serialize($item);
		}

		return $serialized;
	}
}