<?php

namespace NdbSerializer\Test;

use NdbSerializer\CollectionSerializer;

/**
 * @author Jan Marek
 */
class CollectionSerializerTest extends BaseTestCase
{

	public function testSerialize()
	{
		$collection = array(1, 2, 3);

		$innerSerializer = $this->mockista->create('NdbSerializer\ISerializer');
		$innerSerializer->expects('serialize')->andCallback(function ($val) {
			return $val * 2;
		});

		$serializer = new CollectionSerializer($innerSerializer);
		$this->assertEquals(array(2, 4, 6), $serializer->serialize($collection));
	}

}