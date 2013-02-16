<?php

namespace NdbSerializer\Test;

use NdbSerializer\RowSerializer;

/**
 * @author Jan Marek
 */
class RowSerializerTest extends BaseTestCase
{

	public function testSerialize()
	{
		$data = array(
			'id' => 1,
			'name' => 'Lorem ipsum',
		);

		$row = $this->mockista->create(array(
			'toArray' => $data,
		));

		$serializer = new RowSerializer();
		$this->assertEquals($data, $serializer->serialize($row));
	}

	public function testPropertySerializer()
	{
		$data = array(
			'id' => 1,
			'name' => 'Lorem ipsum',
		);

		$row = $this->mockista->create(array(
			'toArray' => $data,
		));

		$propertySerializer = $this->mockista->create('NdbSerializer\ISerializer');
		$propertySerializer->expects('serialize')->once()->andReturn(123);
		$serializer = new RowSerializer();
		$serializer->addPropertySerializer('property', $propertySerializer);

		$expected = array(
			'id' => 1,
			'name' => 'Lorem ipsum',
			'property' => 123,
		);

		$this->assertEquals($expected, $serializer->serialize($row));
	}

	public function testWith()
	{
		$row = (object) array(
			'id' => 1,
			'name' => 'Lorem ipsum',
		);

		$serializer = new RowSerializer();
		$serializer->withValues(array('id'));
		$this->assertEquals(array(
			'id' => 1,
		), $serializer->serialize($row));
	}

	public function testWithout()
	{
		$data = array(
			'id' => 1,
			'name' => 'Lorem ipsum',
		);

		$row = $this->mockista->create(array(
			'toArray' => $data,
		));

		$serializer = new RowSerializer();
		$serializer->withoutValues(array('name'));
		$this->assertEquals(array(
			'id' => 1,
		), $serializer->serialize($row));
	}

}