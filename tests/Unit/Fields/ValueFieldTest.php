<?php

namespace Tests\Unit\Fields;

use App\Support\Mockend\Fields\ValueField;
use Tests\TestCase;

class ValueFieldTest extends TestCase
{
    /** @test */
    public function it_should_return_the_args()
    {
        $arr = [1, 2, 3];
        $field = new ValueField($arr);
        $this->assertEquals($arr, $field->get());
        $field = new ValueField(1);
        $this->assertEquals(1, $field->get());
    }

    /** @test */
    public function it_is_not_a_relation_field()
    {
        $field = new ValueField([1, 2, 3]);
        $this->assertFalse($field->isRelation());
    }
}
