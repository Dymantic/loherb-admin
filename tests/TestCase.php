<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function assertDatabaseHasWithTranslations($table, $attributes)
    {
        $encodedAttributes = collect($attributes)->flatMap(function($value, $field) {
                return [$field => is_array($value) ? json_encode($value) : $value];
        })->all();

        return $this->assertDatabaseHas($table, $encodedAttributes);
    }
}
