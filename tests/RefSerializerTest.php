<?php

namespace NdbSerializer\Test;

use NdbSerializer\RefSerializer;

/**
 * @author Jan Marek
 */
class RefSerializerTest extends BaseTestCase
{

	public function testSerialize()
	{
		$data = array('id' => 123);

		$row = $this->mockista->create();
		$row->expects('ref')->once()->with('name')->andReturn($data);

		$innerSerializer = $this->mockista->create('NdbSerializer\ISerializer');
		$innerSerializer->expects('serialize')->once()->andCallback(function ($data) {
			return $data;
		});

		$serializer = new RefSerializer('name', $innerSerializer);
		$this->assertEquals($data, $serializer->serialize($row));
	}

}