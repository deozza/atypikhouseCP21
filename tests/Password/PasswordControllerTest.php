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
      ["kind" => "unit", "test" => ['method'=> 'PUT'    , 'url' => 'api/password/reset/request', 'status' => 405] ],
      ["kind" => "unit", "test" => ['method'=> 'DELETE' , 'url' => 'api/password/reset/request', 'status' => 405] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'  , 'url' => 'api/password/reset/request', 'status' => 405] ],
      ["kind" => "unit", "test" => ['method'=> 'GET'    , 'url' => 'api/password/reset/request', 'status' => 405] ],
      #api/password/reset (tout bloquer sauf patch)

      ["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password' , 'status' => 400, 'in' => 'postExtraField'      , 'out' => 'postedExtraField'      ] ],
      ["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password' , 'status' => 400, 'in' => 'postMissingField'    , 'out' => 'postedMissingField'    ] ],
      #checker si truc dedans

      ["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password', 'status' => 201, 'in' => 'postEmailOK', 'out' => 'postedEmailOk'] ],
      ["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password', 'status' => 201, 'in' => 'postEmptyOk', 'out' => 'postedEmptyOk'] ],

      ["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/password/reset', 'status' => 400, 'in' => 'postWrongToken', 'out' => 'postedWrongToken'] ],# + password et token dans payload
      #token expiré
      #extra
      #missing
      #checker user invalid
      #type token invalide
      #mot de passe invalide

    ];
  }
}
