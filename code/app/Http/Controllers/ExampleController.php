<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use function Sodium\add;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get example.
     *
     * @OA\Get(
     *     path="/",
     *     @OA\Response(response="200", description="OK"),
     * )
     */
    public function getExample(): string
    {
        return 'example'.time();
    }
    public function testRedis()
    {
        if (Cache::has('test_redis1')) {
            echo 'Test redis key was set on ' . date('Y-m-d H:i:s', (int)Cache::get('test_redis1'));
        }
        else
        {
            echo 'Redis is empty, setting a key... reload page.';
            Cache::add( 'test_redis1', time(), 60 * 2 );
        }
    }
}
