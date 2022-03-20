<?php

namespace Tests\Unit\Fields;

use App\Support\Mockend\Fields\NullField;
use Tests\TestCase;

class NullFieldTest extends TestCase
{
    /** @test */
    public function it_should_always_return_null()
    {
        $field = new NullField();
        $this->assertEquals(null, $field->get());
    }

    /** @test */
    public function it_is_not_a_relation_field()
    {
        $field = new NullField();
        $this->assertFalse($field->isRelation());
    }
}
