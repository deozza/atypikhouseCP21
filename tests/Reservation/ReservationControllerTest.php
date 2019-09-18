<?php
namespace App\Tests\User;

use Deozza\PhilarmonyApiTesterBundle\Service\TestAsserter;

class ReservationControllerTest extends TestAsserter
{
    //const DBPATH = 'D:\F2I/Atypik_House/atypikhouseCP21/var/data/db_test/demo.sql';
    const DBPATH = __DIR__."/../../var/data/db_test/demo.sql";

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
                ["kind" => "unit", "test" => ['method'=> 'GET'   , 'url' => 'api/entities/reservation'                                                                        , 'status' => 200, 'out' => "getReservationAsNotLogged"] ],
                ["kind" => "unit", "test" => ['method'=> 'GET'   , 'url' => 'api/entities/reservation'                                        , 'token'=>'token_userAdmin'    , 'status' => 200, 'out' => "getReservationAsAdmin"] ],
                ["kind" => "unit", "test" => ['method'=> 'GET'   , 'url' => 'api/entities/reservation'                                        , 'token'=>'token_userActive'   , 'status' => 200, 'out' => "getReservationAsUser"] ],

                ["kind" => "unit", "test" => ['method'=> 'GET'   , 'url' => 'api/entity/00000100-0000-4000-a000-000000000000'                                                 , 'status' => 403] ],
                ["kind" => "unit", "test" => ['method'=> 'GET'   , 'url' => 'api/entity/00000100-0000-4000-a000-000000000000'                 , 'token'=>'token_userForbidden', 'status' => 403] ],
                ["kind" => "unit", "test" => ['method'=> 'GET'   , 'url' => 'api/entity/00000100-0000-4000-a000-000000000000'                 , 'token'=>'token_userActive'   , 'status' => 200] ],
                ["kind" => "unit", "test" => ['method'=> 'GET'   , 'url' => 'api/entity/00000100-0000-4000-a000-000000000000'                 , 'token'=>'token_userActive2'  , 'status' => 200] ],
                ["kind" => "unit", "test" => ['method'=> 'GET'   , 'url' => 'api/entity/00000100-0000-4000-a000-000000000000'                 , 'token'=>'token_userAdmin'    , 'status' => 200] ],

                //["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/entity/reservation'                                             ,'token'=>'token_userActive'   , 'status' => 201, 'out'=>'postedValidReservation', 'in'=>'postValidReservation'] ],
                ["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/entity/reservation'                                             ,'token'=>'token_userActive'   , 'status' => 409, 'out'=>'postedInvalidDateReservation1', 'in'=>'postInvalidDateReservation1'] ],
                ["kind" => "unit", "test" => ['method'=> 'POST', 'url' => 'api/entity/reservation'                                             ,'token'=>'token_userActive'   , 'status' => 409, 'out'=>'postedInvalidDateReservation2', 'in'=>'postInvalidDateReservation2'] ],

                ["kind" => "unit", "test" => ['method'=> 'DELETE', 'url' => 'api/entity/00000100-0000-4000-a000-000000000000'                 , 'token'=>'token_userForbidden', 'status' => 403] ],
                ["kind" => "unit", "test" => ['method'=> 'DELETE', 'url' => 'api/entity/00000100-0000-4000-a000-000000000000'                 , 'token'=>'token_userActive'   , 'status' => 204] ],
                ["kind" => "unit", "test" => ['method'=> 'DELETE', 'url' => 'api/entity/00000100-0000-4000-a000-000000000000'                 , 'token'=>'token_userActive2'  , 'status' => 204] ],
                ["kind" => "unit", "test" => ['method'=> 'DELETE', 'url' => 'api/entity/00000100-0000-4000-a000-000000000000'                 , 'token'=>'token_userAdmin'    , 'status' => 204] ],

                #[
                #    "kind" => "scenario",
                #    "test" =>
                #        [
                #                             ['method'=> 'POST'  , 'url' => 'api/entity/reservation'                                           ,'token'=>'token_userActive'   , 'status' => 201, 'out'=>'postedValidReservation', 'in'=>'postValidReservation'],
                #                             ['method'=> 'POST'  , 'url' => 'api/entity/reservation'                                           ,'token'=>'token_userActive2'  , 'status' => 409                                 , 'in'=>'postValidReservation'],
                #                             ['method'=> 'POST'  , 'url' => 'api/entity/reservation'                                           ,'token'=>'token_userActive2'  , 'status' => 409                                 , 'in'=>'postValidReservation2'],
                #                             ['method'=> 'POST'  , 'url' => 'api/entity/reservation'                                           ,'token'=>'token_userActive2'  , 'status' => 409                                 , 'in'=>'postValidReservation3'],
                #
                #        ],
                #]
            ];
    }
}
