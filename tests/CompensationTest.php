<?php


// use Tests\TestCase;

use App\Models\Compensation;
use App\Models\Employee;
// use App\Models\Review;
// use Carbon\Carbon;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CompensationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     $response = $this->call('GET', '/viewAll/compensationData');

    //     $this->assertEquals(200, $response->status());
    //     // $this->assertTrue(true);
    // }

    public function testCompensationy()
 {
    $this->get("viewAll/compensationData", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'product_name',
                    'product_description',
                    'created_at',
                    'updated_at',
                    'links'
                ]
            ],
            'meta' => [
                '*' => [
                    'total',
                    'count',
                    'per_page',
                    'current_page',
                    'total_pages',
                    'links',
                ]
            ]
        ]);

           
 }
}
