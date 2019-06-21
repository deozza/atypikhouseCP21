<?php
namespace App\Tests\User;
use Deozza\ApiTesterBundle\Service\TestAsserter;

class UserControllerTest extends TestAsserter
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
      ["kind" => "unit", "test" => ['method'=> 'PUT'    , 'url' => 'api/user/00400000-0000-5000-a000-000000000000', 'token' => 'token_userAdmin'  , 'status' => 405] ],
      ["kind" => "unit", "test" => ['method'=> 'PUT'    , 'url' => 'api/users'                                                                    , 'status' => 405] ],
      ["kind" => "unit", "test" => ['method'=> 'PUT'    , 'url' => 'api/user/current'                                                             , 'status' => 405] ],
      ["kind" => "unit", "test" => ['method'=> 'DELETE' , 'url' => 'api/user/00400000-0000-5000-a000-000000000000', 'token' => 'token_userAdmin'  , 'status' => 405] ],
      ["kind" => "unit", "test" => ['method'=> 'DELETE' , 'url' => 'api/users'                                                                    , 'status' => 405] ],
      ["kind" => "unit", "test" => ['method'=> 'DELETE' , 'url' => 'api/user/current'                                                             , 'status' => 405] ],
      ["kind" => "unit", "test" => ['method'=> 'GET'    , 'url' => 'api/user/00400000-0000-5000-a000-000000000000'                                , 'status' => 401] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'  , 'url' => 'api/user/00400000-0000-5000-a000-000000000000'                                , 'status' => 401] ],
      ["kind" => "unit", "test" => ['method'=> 'GET'    , 'url' => 'api/user/current'                                                             , 'status' => 401] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'  , 'url' => 'api/user/current'                                                             , 'status' => 401] ],
      ["kind" => "unit", "test" => ['method'=> 'GET'    , 'url' => 'api/users'                                                                    , 'status' => 401] ],
      ["kind" => "unit", "test" => ['method'=> 'GET'    , 'url' => 'api/user/00400000-0000-5000-a000-000000000000', 'token' => 'token_userActive' , 'status' => 403] ],
      ["kind" => "unit", "test" => ['method'=> 'GET'    , 'url' => 'api/users'                                    , 'token' => 'token_userActive' , 'status' => 403] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'  , 'url' => 'api/user/00400000-0000-5000-a000-000000000000', 'token' => 'token_userActive' , 'status' => 403] ],

      ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/token', 'status' => 400, 'in' => 'invalidEmail' , 'out' => 'postedInvalidEmail'] ],

      ["kind" => "unit", "test" => ['method'=> 'GET'    , 'url' => 'api/user/current', 'token' => 'token_userActive' , 'status' => 200 ,'in' => 'getCurrentUserOk'    , 'out' => 'getCurrentUserOk'    ] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'  , 'url' => 'api/user/current', 'token' => 'token_userActive' , 'status' => 200  'in' => 'patchCurrentUserOk'  , 'out' => 'patchedCurrentUserOk'] ],
      ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/user'                                        , 'status' => 201  'in' => 'postUserOk'          , 'out' => 'postedUserOk'        ] ],

      ["kind" => "unit", "test" => ['method'=> 'GET'    , 'url' => 'api/users'                                    , 'token' => 'token_userAdmin', 'status' => 200 , 'in' => 'getUsersOk' , 'out' => 'getUsersOk'   ] ],
      ["kind" => "unit", "test" => ['method'=> 'GET'    , 'url' => 'api/user/00400000-0000-5000-a000-000000000000', 'token' => 'token_userAdmin', 'status' => 200 , 'in' => 'getUserOk'  , 'out' => 'getUserOk'    ] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'  , 'url' => 'api/user/00400000-0000-5000-a000-000000000000', 'token' => 'token_userAdmin', 'status' => 200 , 'in' => 'patchUserOk', 'out' => 'patchedUserOk'] ],

    ];
  }
}
