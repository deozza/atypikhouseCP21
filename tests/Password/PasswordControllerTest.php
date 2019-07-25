<?php
namespace App\Tests\Password;

use Deozza\PhilarmonyApiTesterBundle\Service\TestAsserter;

class PasswordControllerTest extends TestAsserter
{
  const DBPATH = 'D:\F2I/Atypik_House/atypikhouseCP21/var/data/db_test/demo.sql';
  //const DBPATH = __DIR__."/../../var/data/db_test/demo.sql";

  public function setUp()
  {
    parent::setTestDatabasePath(self::DBPATH);
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
      #["kind" => "unit", "test" => ['method'=> 'PUT'    , 'url' => 'api/password/reset/request', 'status' => 405] ],
      #["kind" => "unit", "test" => ['method'=> 'DELETE' , 'url' => 'api/password/reset/request', 'status' => 405] ],
      #["kind" => "unit", "test" => ['method'=> 'PATCH'  , 'url' => 'api/password/reset/request', 'status' => 405] ],
      #["kind" => "unit", "test" => ['method'=> 'GET'    , 'url' => 'api/password/reset/request', 'status' => 405] ],
      #["kind" => "unit", "test" => ['method'=> 'PUT'    , 'url' => 'api/password/reset'        , 'status' => 405] ],
      #["kind" => "unit", "test" => ['method'=> 'DELETE' , 'url' => 'api/password/reset'        , 'status' => 405] ],
      #["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/password/reset'        , 'status' => 405] ],
      #["kind" => "unit", "test" => ['method'=> 'GET'    , 'url' => 'api/password/reset'        , 'status' => 405] ],

      #["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password/reset/request' , 'status' => 400, 'in' => 'postExtraField'      , 'out' => 'postedExtraField'    ] ],
      #["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password/reset/request' , 'status' => 400, 'in' => 'postMissingField'    , 'out' => 'postedMissingField'  ] ],
      #["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password/reset/request' , 'status' => 400, 'in' => 'postEmptyField'      , 'out' => 'postedEmptyField'    ] ],

      #["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password/reset/request', 'status' => 201, 'in' => 'postEmailOK', 'out' => 'postedEmailOk'] ],
      #["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password/reset/request', 'status' => 201, 'in' => 'postStringOk', 'out' => 'postedStringOk'] ],

      # password et token dans payload
      #["kind" => "unit", "test" => ['method'=> 'PATCH', 'url' => 'api/password/reset', 'status' => 400, 'in' => 'postWrongToken'  , 'out' => 'postedWrongToken'] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH', 'url' => 'api/password/reset', 'status' => 400, 'in' => 'postExpiredToken', 'out' => 'postedExpiredToken'] ],
      #["kind" => "unit", "test" => ['method'=> 'PATCH', 'url' => 'api/password/reset', 'status' => 400, 'in' => 'postInvalidUser', 'out' => 'postedInvalidUser'] ],
      #["kind" => "unit", "test" => ['method'=> 'PATCH', 'url' => 'api/password/reset', 'status' => 400, 'in' => 'postInvalidToken', 'out' => 'postedInvalidToken'] ],
      #["kind" => "unit", "test" => ['method'=> 'PATCH', 'url' => 'api/password/reset', 'status' => 400, 'in' => 'postWrongPassword', 'out' => 'postedWrongPassword'] ],
      #["kind" => "unit", "test" => ['method'=> 'PATCH', 'url' => 'api/password/reset', 'status' => 400, 'in' => 'postExtraField2', 'out' => 'postedExtraField2'] ],
      #["kind" => "unit", "test" => ['method'=> 'PATCH', 'url' => 'api/password/reset', 'status' => 400, 'in' => 'postMissingField2', 'out' => 'postedMissingField2'] ],

    ];
  }
}
