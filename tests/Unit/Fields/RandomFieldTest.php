<?php

namespace Tests\Unit\Fields;

use App\Support\Mockend\Fields\RandomField;
use Tests\TestCase;

class RandomFieldTest extends TestCase
{
    /** @test */
    public function it_should_return_element()
    {
        $arr = [1, 2, 3];
        $field = new RandomField($arr);
        $this->assertTrue(in_array($field->get(), $arr));
    }

    /** @test */
    public function it_is_not_a_relation_field()
    {
        $field = new RandomField([1, 2, 3]);
        $this->assertFalse($field->isRelation());
    }
}
