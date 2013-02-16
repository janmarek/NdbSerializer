<?php

namespace NdbSerializer\Test;

use NdbSerializer\ManyToManySerializer;

/**
 * @author Jan Marek
 */
class ManyToManySerializerTest extends BaseTestCase
{

	public function testSerialize()
	{
		$data = array('id' => 1, 'name' => 'lorem');
		$articleRow = $this->mockista->create();
		$articleTagRow = $this->mockista->create();
		$articleRow->expects('related')->once()->with('article_tag')->andReturn(array($articleTagRow, $articleTagRow));
		$articleTagRow->expects('ref')->with('tag')->twice()->andReturn($data);

		$innerSerializer = $this->mockista->create('NdbSerializer\ISerializer');
		$innerSerializer->expects('serialize')->twice()->andCallback(function ($data) {
			return $data;
		});

		$serializer = new ManyToManySerializer('tag', 'article_tag', $innerSerializer);
		$expected = array($data, $data);
		$this->assertEquals($expected, $serializer->serialize($articleRow));
	}

}