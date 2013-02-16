<?php

namespace NdbSerializer\Test;

abstract class BaseTestCase extends \PHPUnit_Framework_TestCase
{

	/** @var \Nette\Database\Connection */
	protected $database;

    /** @var \Mockista\Registry */
    protected $mockista;

    protected function setUp()
    {
		$this->database = $GLOBALS['container']->database;
        $this->mockista = new \Mockista\Registry();
    }

    protected function tearDown()
    {
        $this->mockista->assertExpectations();
    }

}