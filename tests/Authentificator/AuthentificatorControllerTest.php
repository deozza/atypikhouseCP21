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
        ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/token', 'status' => 400, 'in' => 'invalidEmail'     , 'out' => 'postedInvalidEmail'   ] ],
        ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/token', 'status' => 400, 'in' => 'invalidPassword'  , 'out' => 'postedInvalidPassword'] ],
        ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/token', 'status' => 400, 'in' => 'invalidLogin'     , 'out' => 'postedInvalidLogin'   ] ],
        ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/token', 'status' => 400, 'in' => 'inactiveUser'     , 'out' => 'postedInactiveUser'   ] ],
        ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/token', 'status' => 400, 'in' => 'extraField'       , 'out' => 'postedExtraField'     ] ],
        ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/token', 'status' => 400, 'in' => 'missingField'     , 'out' => 'postedMissingField'   ] ],

        ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/token', 'status' => 201, 'in' => 'loginOK' , 'out' => 'postedLogin'] ],
        ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/token', 'status' => 201, 'in' => 'emailOK' , 'out' => 'postedEmail'] ],


        ["kind" => "unit", "test" => ['method'=> 'PATCH'  , 'url' => 'api/token/00400000-0000-5000-a000-000000000000'                               , 'status' => 405] ],
        ["kind" => "unit", "test" => ['method'=> 'PUT'    , 'url' => 'api/token/00400000-0000-5000-a000-000000000000'                               , 'status' => 405] ],
        ["kind" => "unit", "test" => ['method'=> 'GET'    , 'url' => 'api/token/00400000-0000-5000-a000-000000000000'                               , 'status' => 405] ],
        ["kind" => "unit", "test" => ['method'=> 'DELETE' , 'url' => 'api/token/00400000-0000-5000-a000-000000000000'                               , 'status' => 401] ],
        ["kind" => "unit", "test" => ['method'=> 'DELETE' , 'url' => 'api/token/00100000-0000-5000-a000-000000000000', 'token' => 'token_userActive', 'status' => 404] ],
        ["kind" => "unit", "test" => ['method'=> 'DELETE' , 'url' => 'api/token/0000-5000-a000-000000000000'         , 'token' => 'token_userActive', 'status' => 404] ],

        ["kind" => "unit", "test" => ['method'=> 'DELETE' , 'url' => 'api/token/00400000-0000-5000-a000-000000000000', 'token' => 'token_userActive', 'status' => 204] ],

        ["kind" => "scenario",
        "test" => [
            ['method'=> 'POST'   , 'url' => 'api/token'                             , 'status' => 201, 'in' => 'loginOK' , 'out' => 'postedLoginScenario'],
            ['method'=> 'DELETE' , 'url' => 'api/token/#uuid#', 'token' => '#token#', 'status' => 204],
          ]
        ]

      ];
  }
}
