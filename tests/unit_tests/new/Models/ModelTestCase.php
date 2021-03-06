<?php

namespace Pantheon\Terminus\UnitTests\Models;

use Pantheon\Terminus\Config;
use Pantheon\Terminus\Request\Request;

abstract class ModelTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TerminusCollection
     */
    protected $collection;
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var TerminusModel
     */
    protected $model;
    /**
     * @var Request
     */
    protected $request;

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->config = $this->getMockBuilder(Config::class)
          ->disableOriginalConstructor()
          ->getMock();
        $this->request = $this->getMockBuilder(Request::class)
          ->disableOriginalConstructor()
          ->getMock();
        $this->request->method('getConfig')->willReturn($this->getConfig());
    }
}
