<?php

namespace NdbSerializer\Test;

use NdbSerializer\ValueSerializer;

/**
 * @author Jan Marek
 */
class ValueSerializerTest extends BaseTestCase
{

	public function testSerialize()
	{
		$row = (object) array('id' => 123);

		$serializer = new ValueSerializer('id');
		$this->assertEquals(123, $serializer->serialize($row));
	}

}