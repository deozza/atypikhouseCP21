<?php
namespace App\Tests\User;

use Deozza\PhilarmonyApiTesterBundle\Service\TestAsserter;

class EstateControllerTest extends TestAsserter
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
                ["kind" => "unit", "test" => ['method'=> 'GET'   , 'url' => 'api/entities/estate'                                                                       , 'status' => 200, 'out' => "getEstatesAsNotLogged"] ],
                ["kind" => "unit", "test" => ['method'=> 'GET'   , 'url' => 'api/entities/estate'                                       , 'token'=>'token_userAdmin'    , 'status' => 200, 'out' => "getEstatesAsAdmin"] ],
                ["kind" => "unit", "test" => ['method'=> 'GET'   , 'url' => 'api/entities/estate'                                       , 'token'=>'token_userActive'   , 'status' => 200, 'out' => "getEstatesAsUser"] ],
                ["kind" => "unit", "test" => ['method'=> 'GET'   , 'url' => "api/entities/estate?filterBy[equal.validationState]=posted", 'token'=>'token_userActive'   , 'status' => 200, 'out' => "getEstatesAsUserFiltered"] ],

                ["kind" => "unit", "test" => ['method'=> 'GET'   , 'url' => "api/entity/00001000-0000-4000-a000-000000000000"                                           , 'status' => 403] ],
                ["kind" => "unit", "test" => ['method'=> 'GET'   , 'url' => "api/entity/00001000-0000-4000-a000-000000000000"           , 'token'=>'token_userForbidden', 'status' => 403] ],
                ["kind" => "unit", "test" => ['method'=> 'GET'   , 'url' => "api/entity/00001000-0000-4000-a000-000000000000"           , 'token'=>'token_userActive'   , 'status' => 200, 'out'=>'getEntity'] ],
                ["kind" => "unit", "test" => ['method'=> 'GET'   , 'url' => "api/entity/00001000-0000-4000-a000-000000000000"           , 'token'=>'token_userAdmin'    , 'status' => 200, 'out'=>'getEntity'] ],

                ["kind" => "unit", "test" => ['method'=> 'POST'  , 'url' => "api/entity/estate"                                                                         , 'status' => 401] ],
                ["kind" => "unit", "test" => ['method'=> 'POST'  , 'url' => "api/entity/estate"                                         , 'token'=>'token_userActive'   , 'status' => 400, 'out'=>'postedMissingFieldEstate'   , 'in'=>'postMissingFieldEstate'] ],
                ["kind" => "unit", "test" => ['method'=> 'POST'  , 'url' => "api/entity/estate"                                         , 'token'=>'token_userActive'   , 'status' => 400, 'out'=>'postedExtraFieldEstate'     , 'in'=>'postExtraFieldEstate'] ],
                ["kind" => "unit", "test" => ['method'=> 'POST'  , 'url' => "api/entity/estate"                                         , 'token'=>'token_userActive'   , 'status' => 400, 'out'=>'postedInvalidEstate'        , 'in'=>'postInvalidEstate'] ],
                ["kind" => "unit", "test" => ['method'=> 'POST'  , 'url' => "api/entity/estate"                                         , 'token'=>'token_userActive'   , 'status' => 409, 'out'=>'postedValidEstate'          , 'in'=>'postValidEstate'] ],

                ["kind" => "unit", "test" => ['method'=> 'PATCH' , 'url' => "api/entity/00001000-0000-4000-a000-000000000000"                                           , 'status' => 401] ],
                ["kind" => "unit", "test" => ['method'=> 'PATCH' , 'url' => "api/entity/00001000-0000-4000-a000-000000000000"           , 'token'=>'token_userForbidden', 'status' => 403] ],
                ["kind" => "unit", "test" => ['method'=> 'PATCH' , 'url' => "api/entity/00001000-0000-4000-a000-000000000000"           , 'token'=>'token_userActive'   , 'status' => 400, 'out'=>'patchedExtraFieldEstate'    , 'in'=>'patchExtraFieldEstate'] ],
                ["kind" => "unit", "test" => ['method'=> 'PATCH' , 'url' => "api/entity/00001000-0000-4000-a000-000000000000"           , 'token'=>'token_userActive'   , 'status' => 400, 'out'=>'patchedInvalidEstate'       , 'in'=>'patchInvalidEstate'] ],
                ["kind" => "unit", "test" => ['method'=> 'PATCH' , 'url' => "api/entity/00001000-0000-4000-a000-000000000000"           , 'token'=>'token_userActive'   , 'status' => 409, 'out'=>'patchedValidPostedEstate'   , 'in'=>'patchValidPostedEstate'] ],
                ["kind" => "unit", "test" => ['method'=> 'PATCH' , 'url' => "api/entity/00003000-0000-4000-a000-000000000000"           , 'token'=>'token_userActive'   , 'status' => 409, 'out'=>'patchedValidPublishedEstate', 'in'=>'patchValidPublishedEstate'] ],

                ["kind" => "unit", "test" => ['method'=> 'DELETE', 'url' => "api/entity/00001000-0000-4000-a000-000000000000"                                           , 'status' => 401] ],
                ["kind" => "unit", "test" => ['method'=> 'DELETE', 'url' => "api/entity/00001000-0000-4000-a000-000000000000"           , 'token'=>'token_userForbidden', 'status' => 403] ],
                ["kind" => "unit", "test" => ['method'=> 'DELETE', 'url' => "api/entity/00001000-0000-4000-a000-000000000000"           , 'token'=>'token_userActive'   , 'status' => 204] ],
                ["kind" => "unit", "test" => ['method'=> 'DELETE', 'url' => "api/entity/00001000-0000-4000-a000-000000000000"           , 'token'=>'token_userAdmin'    , 'status' => 204] ],

            ];
    }
}
