<?php

namespace NYPL\Services\Test\Controller;

use NYPL\Services\Controller\PatronController;
use NYPL\Services\Model\DataModel\BasePatron\Patron;
use NYPL\Services\Model\DataModel\PatronSet;
use NYPL\Services\Test\Mocks\MockConfig;
use NYPL\Services\Test\Mocks\MockService;
use PHPUnit\Framework\TestCase;

class PatronControllerTest extends TestCase
{
    public $fakePatronController;
    public $mockContainer;

    public function setUp()
    {
        parent::setUp();
        MockConfig::initialize(__DIR__ . '/../../');
        MockService::setMockContainer();
        $this->mockContainer = MockService::getMockContainer();

        $this->fakePatronController = new class(MockService::$mockContainer['request'], MockService::$mockContainer['response'], 0) extends PatronController {

            public $request;
            public $response;
            public $cacheSeconds;

            public function __construct($request, $response, $cacheSeconds)
            {
                parent::__construct($request, $response, $cacheSeconds);
            }

            public function getPatrons()
            {
                $data = json_decode(file_get_contents(__DIR__ . '/../Stubs/sample_patron_response.json'), true);
                $set = new PatronSet(new Patron($data));

                return $this->response->withJson($set);
            }

            public function getPatron($id)
            {
                $data = json_decode(file_get_contents(__DIR__ . '/../Stubs/sample_patron_response.json'), true);
                $patron = new Patron($data);

                return $this->response->withJson($patron);
            }
        };
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->fakePatronController);
    }

    /**
     * @covers NYPL\Services\Controller\PatronController::getPatrons()
     */
    public function testIfGetPatronsReturnsSuccessResponse()
    {
        $controller = $this->fakePatronController;

        $patronResponse = $controller->getPatrons();

        self::assertInstanceOf('\Slim\Http\Response', $patronResponse);
    }

    /**
     * @covers NYPL\Services\Controller\PatronController::getPatron()
     */
    public function testIfGetPatronProperSuccessResponse()
    {
        $controller = $this->fakePatronController;

        $patronResponse = $controller->getPatron('5524');

        self::assertInstanceOf('\Slim\Http\Response', $patronResponse);
    }
}
