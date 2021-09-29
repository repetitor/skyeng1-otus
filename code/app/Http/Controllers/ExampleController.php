<?php

namespace App\Http\Controllers;

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
        return 'example';
    }
}
