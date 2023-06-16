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
        $this->withoutExceptionHandling();
        Route::get('test_route', function () {
            return 'ok';
        })->middleware(ValidateJsonApiHeaders::class);

        $this->get('test_route', [
            'accept' => 'application/vnd.api+json'
        ])->assertSuccessful();
    }

    public function test_accept_header_must_be_present_on_all_post_request(): void
    {

        Route::post('test_route', function () {
            return 'ok';
        })->middleware(ValidateJsonApiHeaders::class);

        $this->post('test_route', [], [
            'accept' => 'application/vnd.api+json'
        ])->assertStatus(415);

        $this->post('test_route', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertSuccessful();
    }

    public function test_accept_header_must_be_present_on_all_patch_request(): void
    {

        Route::patch('test_route', function () {
            return 'ok';
        })->middleware(ValidateJsonApiHeaders::class);

        $this->patch('test_route', [], [
            'accept' => 'application/vnd.api+json'
        ])->assertStatus(415);

        $this->patch('test_route', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertSuccessful();
    }

    public function test_content_type_header_must_be_present_in_responses(): void
    {
        $this->withoutExceptionHandling();
        Route::any('test_route', function () {
            return 'ok';
        })->middleware(ValidateJsonApiHeaders::class);

        $this->get('test_route', [
            'accept' => 'application/vnd.api+json'
        ])->assertHeader('content-type','application/vnd.api+json');

        $this->post('test_route', [],[
            'accept' => 'application/vnd.api+json',
            'content-type'=>'application/vnd.api+json'
        ])->assertHeader('content-type','application/vnd.api+json');


        $this->patch('test_route', [],[
            'accept' => 'application/vnd.api+json',
            'content-type'=>'application/vnd.api+json'
        ])->assertHeader('content-type','application/vnd.api+json');
    }

    public function test_content_type_header_must_no_be_present_in_empty_responses():void
    {
        Route::any('empty_response', function () {
            return response()->noContent();
        })->middleware(ValidateJsonApiHeaders::class);

        $this->get('empty_response',[
            'accept' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');

        $this->post('empty_response',[],[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');

        $this->patch('empty_response',[],[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');

        $this->delete('empty_response',[],[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');

    }
}
