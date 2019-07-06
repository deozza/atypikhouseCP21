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

      ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/user' , 'status' => 400, 'in' => 'postExistingEmail'   , 'out' => 'postedExistingEmail'   ] ],
      ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/user' , 'status' => 400, 'in' => 'postMissingDotEmail' , 'out' => 'postedMissingDotEmail' ] ],
      ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/user' , 'status' => 400, 'in' => 'postMissingAtEmail'  , 'out' => 'postedMissingAtEmail'  ] ],
      ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/user' , 'status' => 400, 'in' => 'postExistingLogin'   , 'out' => 'postedExistingLogin'   ] ],
      ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/user' , 'status' => 400, 'in' => 'postInvalidPassword' , 'out' => 'postedInvalidPassword' ] ],
      ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/user' , 'status' => 400, 'in' => 'postExtraField'      , 'out' => 'postedExtraField'      ] ],
      ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/user' , 'status' => 400, 'in' => 'postMissingField'    , 'out' => 'postedMissingField'    ] ],

      ["kind" => "unit", "test" => ['method'=> 'PATCH'   , 'url' => 'api/user/current' , 'status' => 400, 'in' => 'patchExistingEmail'   , 'out' => 'patchedExistingEmail'   ] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'   , 'url' => 'api/user/current' , 'status' => 400, 'in' => 'patchMissingDotEmail' , 'out' => 'patchedMissingDotEmail' ] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'   , 'url' => 'api/user/current' , 'status' => 400, 'in' => 'patchMissingAtEmail'  , 'out' => 'patchedMissingAtEmail'  ] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'   , 'url' => 'api/user/current' , 'status' => 400, 'in' => 'patchExistingLogin'   , 'out' => 'patchedExistingLogin'   ] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'   , 'url' => 'api/user/current' , 'status' => 400, 'in' => 'patchInvalidPassword' , 'out' => 'patchedInvalidPassword' ] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'   , 'url' => 'api/user/current' , 'status' => 400, 'in' => 'patchExtraField'      , 'out' => 'patchedExtraField'      ] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'   , 'url' => 'api/user/current' , 'status' => 400, 'in' => 'patchMissingField'    , 'out' => 'patchedMissingField'    ] ],

      ["kind" => "unit", "test" => ['method'=> 'PATCH'   , 'url' => 'api/user/00400000-0000-5000-a000-000000000000' , 'status' => 400, 'in' => 'patchExistingEmailAdmin'   , 'out' => 'patchedExistingEmailAdmin'   ] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'   , 'url' => 'api/user/00400000-0000-5000-a000-000000000000' , 'status' => 400, 'in' => 'patchMissingDotEmailAdmin' , 'out' => 'patchedMissingDotEmailAdmin' ] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'   , 'url' => 'api/user/00400000-0000-5000-a000-000000000000' , 'status' => 400, 'in' => 'patchMissingAtEmailAdmin'  , 'out' => 'patchedMissingAtEmailAdmin'  ] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'   , 'url' => 'api/user/00400000-0000-5000-a000-000000000000' , 'status' => 400, 'in' => 'patchExistingLoginAdmin'   , 'out' => 'patchedExistingLoginAdmin'   ] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'   , 'url' => 'api/user/00400000-0000-5000-a000-000000000000' , 'status' => 400, 'in' => 'patchInvalidPasswordAdmin' , 'out' => 'patchedInvalidPasswordAdmin' ] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'   , 'url' => 'api/user/00400000-0000-5000-a000-000000000000' , 'status' => 400, 'in' => 'patchExtraFieldAdmin'      , 'out' => 'patchedExtraFieldAdmin'      ] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'   , 'url' => 'api/user/00400000-0000-5000-a000-000000000000' , 'status' => 400, 'in' => 'patchMissingFieldAdmin'    , 'out' => 'patchedMissingFieldAdmin'    ] ],

      ["kind" => "unit", "test" => ['method'=> 'GET'    , 'url' => 'api/user/current', 'token' => 'token_userActive' , 'status' => 200                                , 'out' => 'getCurrentUserOk'    ] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'  , 'url' => 'api/user/current', 'token' => 'token_userActive' , 'status' => 200, 'in' => 'patchCurrentUserOk'  , 'out' => 'patchedCurrentUserOk'] ],
      ["kind" => "unit", "test" => ['method'=> 'POST'   , 'url' => 'api/user'                                        , 'status' => 201, 'in' => 'postUserOk'          , 'out' => 'postedUserOk'        ] ],

      ["kind" => "unit", "test" => ['method'=> 'GET'    , 'url' => 'api/users'                                    , 'token' => 'token_userAdmin', 'status' => 200                        , 'out' => 'getUsersOk'   ] ],
      ["kind" => "unit", "test" => ['method'=> 'GET'    , 'url' => 'api/user/00400000-0000-5000-a000-000000000000', 'token' => 'token_userAdmin', 'status' => 200                        , 'out' => 'getUserOk'    ] ],
      ["kind" => "unit", "test" => ['method'=> 'PATCH'  , 'url' => 'api/user/00400000-0000-5000-a000-000000000000', 'token' => 'token_userAdmin', 'status' => 200 , 'in' => 'patchUserOk', 'out' => 'patchedUserOk'] ],

    ];
  }
}
