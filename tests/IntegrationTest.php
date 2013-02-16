<?php

namespace NdbSerializer\Test;

use NdbSerializer\CollectionSerializer;
use NdbSerializer\ManyToManySerializer;
use NdbSerializer\RefSerializer;
use NdbSerializer\RowSerializer;
use NdbSerializer\ValueSerializer;

/**
 * @author Jan Marek
 */
class IntegrationTest extends BaseTestCase
{

	public function testRef()
	{
		$serializer = new RowSerializer();
		$serializer->addPropertySerializer('programAuthor', new RefSerializer('author', new RowSerializer()));

		$adminer = $this->database->table('application')->where('title', 'Adminer')->fetch();

		$expected = array(
			'id' => 1,
			'author_id' => 11,
			'maintainer_id' => 11,
			'title' => 'Adminer',
			'web' => 'http://www.adminer.org/',
			'slogan' => 'Database management in single PHP file',
			'programAuthor' => array(
				'id' => 11,
				'name' => 'Jakub Vrana',
				'web' => 'http://www.vrana.cz/',
				'born' => NULL,
			),
		);

		$this->assertEquals($expected, $serializer->serialize($adminer));
	}

	public function testManyToMany()
	{
		$serializer = new RowSerializer();
		$serializer->addPropertySerializer(
			'tags',
			new ManyToManySerializer('tag', 'application_tag', new ValueSerializer('name'))
		);

		$adminer = $this->database->table('application')->where('title', 'Adminer')->fetch();

		$expected = array(
			'id' => 1,
			'author_id' => 11,
			'maintainer_id' => 11,
			'title' => 'Adminer',
			'web' => 'http://www.adminer.org/',
			'slogan' => 'Database management in single PHP file',
			'tags' => array('PHP', 'MySQL'),
		);

		$this->assertEquals($expected, $serializer->serialize($adminer));
	}

	public function testCollection()
	{
		$tags = $this->database->table('tag');

		$serializer = new CollectionSerializer(
			(new RowSerializer())
				->withValues(array('id', 'name'))
				->addPropertySerializer('applications', new ManyToManySerializer(
					'application', 'application_tag', new ValueSerializer('title')
				))
		);

		$expected = array(
			array(
				'id' => 21,
				'name' => 'PHP',
				'applications' => array('Adminer', 'Nette', 'Dibi'),
			),
			array(
				'id' => 22,
				'name' => 'MySQL',
				'applications' => array('Adminer', 'Dibi'),
			),
			array(
				'id' => 23,
				'name' => 'JavaScript',
				'applications' => array('JUSH'),
			),
		);

		$this->assertEquals($expected, $serializer->serialize($tags));
	}

}