<?php
namespace App\Tests\Authenticator;
use Deozza\ApiTesterBundle\Service\TestAsserter;

class AuthenticatorControllerTest extends TestAsserter
{
  public function setUp()
  {
      parent::setUp();
  }

  /**
  * @dataProvider addDataProvider
  */
  public function testUnit($kind, $test)
  {
    parent::launchTestByKind($kind, $test);
  }

  public function addDataProvider()
  {
      return
      [
        ["kind" => "unit", "test" => ['method'=> 'PATCH'  , 'url' => 'api/token', 'status' => 405] ],
        ["kind" => "unit", "test" => ['method'=> 'PUT'    , 'url' => 'api/token', 'status' => 405] ],
        ["kind" => "unit", "test" => ['method'=> 'DELETE' , 'url' => 'api/token', 'status' => 405] ],
        ["kind" => "unit", "test" => ['method'=> 'GET'    , 'url' => 'api/token', 'status' => 405] ],


      ];
  }
}
