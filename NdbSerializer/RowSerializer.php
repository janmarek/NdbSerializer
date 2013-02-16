<?php

namespace NdbSerializer;

/**
 * @author Jan Marek
 */
class RowSerializer implements ISerializer
{

	/** @var ISerializer[] */
	private $propertySerializers = array();

	private $withValues = NULL;

	private $mapping = array();

	private $withoutValues = NULL;

	public function serialize($data)
	{
		if ($this->withValues !== NULL) {
			$serialized = array();

			foreach ($this->withValues as $name) {
				$serialized[$name] = $data->{$name};
			}
		} else {
			$serialized = array();

			foreach ($data->toArray() as $name => $value) {
				if ($this->withoutValues === NULL || !in_array($name, $this->withoutValues)) {
					$serialized[$name] = $value;
				}
			}
		}

		foreach ($this->propertySerializers as $key => $serializer) {
			$serialized[$key] = $serializer->serialize($data);
		}

		return $serialized;
	}

	/**
	 * @param string $propertyName
	 * @param ISerializer $serializer
	 * @return RowSerializer
	 */
	public function addPropertySerializer($propertyName, ISerializer $serializer)
	{
		$this->propertySerializers[$propertyName] = $serializer;

		return $this;
	}

	/**
	 * @param string[] $values
	 * @return RowSerializer
	 */
	public function withValues(array $values)
	{
		$this->withValues = $values;

		return $this;
	}

	/**
	 * @param string[] $values
	 * @return RowSerializer
	 */
	public function withoutValues(array $values)
	{
		$this->withoutValues = $values;

		return $this;
	}

}