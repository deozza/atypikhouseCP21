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
      ["kind" => "unit", "test" => ['method'=> 'PUT'    , 'url' => 'api/password', 'status' => 405] ],
      ["kind" => "unit", "test" => ['method'=> 'DELETE' , 'url' => 'api/password', 'status' => 405] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'  , 'url' => 'api/password', 'status' => 401] ],
      ["kind" => "unit", "test" => ['method'=> 'GET'    , 'url' => 'api/password', 'status' => 401] ],

      ["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password' , 'status' => 400, 'in' => 'postMissingDotEmail' , 'out' => 'postedMissingDotEmail' ] ],
      ["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password' , 'status' => 400, 'in' => 'postMissingAtEmail'  , 'out' => 'postedMissingAtEmail'  ] ],
      ["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password' , 'status' => 400, 'in' => 'postExtraField'      , 'out' => 'postedExtraField'      ] ],
      ["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password' , 'status' => 400, 'in' => 'postMissingField'    , 'out' => 'postedMissingField'    ] ],

      ["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password', 'status' => 201, 'in' => 'postEmailOK', 'out' => 'postedEmailOk'] ],
      ["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password', 'status' => 201, 'in' => 'postEmptyOk', 'out' => 'postedEmptyOk'] ],

      ["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password/token_userActive', 'status' => 200, 'in' => 'postTokenOK', 'out' => 'postedTokenOk'] ],
      ["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password/token_Broken'    , 'status' => 400, 'in' => 'postWrongToken', 'out' => 'postedWrongToken'] ],
    ];
  }
}
