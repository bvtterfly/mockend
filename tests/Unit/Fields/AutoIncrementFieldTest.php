<?php

namespace Tests\Unit\Fields;

use App\Support\Mockend\Fields\AutoIncrementField;
use Tests\TestCase;

class AutoIncrementFieldTest extends TestCase
{
    /** @test */
    public function it_should_acts_like_a_auto_increment_sql_field()
    {
        $field = new AutoIncrementField('__TEST__');
        $this->assertEquals(1, $field->get());
        $this->assertEquals(2, $field->get());
        $this->assertEquals(3, $field->get());
        $this->assertEquals(4, $field->get());
    }

    /** @test */
    public function it_is_not_a_relation_field()
    {
        $field = new AutoIncrementField('__TEST__');
        $this->assertFalse($field->isRelation());
    }

    /** @test */
    public function it_should_not_have_conflicts_between_two_services()
    {
        $field = new AutoIncrementField('__TEST__');
        $field2 = new AutoIncrementField('__TEST2__');
        $this->assertEquals(1, $field->get());
        $this->assertEquals(1, $field2->get());
        $this->assertEquals(2, $field->get());
        $this->assertEquals(3, $field->get());
        $this->assertEquals(4, $field->get());
        $this->assertEquals(5, $field->get());
        $this->assertEquals(2, $field2->get());
    }
}
