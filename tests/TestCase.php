<?php

namespace Tests;

use App\Trait\MakeJsonAPiRequestHeader;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, MakeJsonAPiRequestHeader;
}
