<?php
namespace App\Tests\Authentificator;
use Deozza\ApiTesterBundle\Service\TestAsserter;

class AuthentificatorControllerTest extends TestAsserter
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
        ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/token', 'status' => 400, 'in' => 'invalidEmail' , 'out' => 'postedInvalidEmail'] ],
        ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/token', 'status' => 400, 'in' => 'invalidPassword' , 'out' => 'postedInvalidPassword'] ],
        ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/token', 'status' => 400, 'in' => 'invalidLogin' , 'out' => 'postedInvalidLogin'] ],
        ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/token', 'status' => 400, 'in' => 'inactiveUser' , 'out' => 'postedInactiveUser'] ],
        ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/token', 'status' => 400, 'in' => 'extraField' , 'out' => 'postedExtraField'] ],
        ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/token', 'status' => 400, 'in' => 'missingField' , 'out' => 'postedMissingField'] ],

        ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/token', 'status' => 201, 'in' => 'loginOK' , 'out' => 'postedLogin'] ],
        ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/token', 'status' => 201, 'in' => 'emailOK' , 'out' => 'postedEmail'] ],

      ];
  }
}
