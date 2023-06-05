<?php

namespace Tests\Feature;

use App\Http\Middleware\ValidateJsonApiHeaders;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ValidateJsonApiHeadersTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_accept_header_must_be_present_in_all_request(): void
    {
        Route::get('test_route',function(){
            return 'ok';
        })->middleware(ValidateJsonApiHeaders::class);

        $this->get('test_route')->assertStatus(406);
    }
}
