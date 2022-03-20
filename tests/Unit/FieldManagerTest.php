<?php

namespace Tests\Unit;

use App\Support\Mockend\FieldManager;
use App\Support\Mockend\Fields\AutoIncrementField;
use App\Support\Mockend\Fields\BelongsToField;
use App\Support\Mockend\Fields\FakerField;
use App\Support\Mockend\Fields\HasManyField;
use App\Support\Mockend\Fields\HasOneField;
use App\Support\Mockend\Fields\NullField;
use App\Support\Mockend\Fields\RandomField;
use App\Support\Mockend\Fields\ValueField;
use Tests\TestCase;

class FieldManagerTest extends TestCase
{
    /** @test */
    public function it_should_return_auto_increment_field()
    {
        $this->assertInstanceOf(AutoIncrementField::class, FieldManager::getField('Test', 'id', []));
    }

    /** @test */
    public function it_should_return_value_field()
    {
        $this->assertInstanceOf(ValueField::class, FieldManager::getField('Test', 'value', []));
    }

    /** @test */
    public function it_should_return_null_field_if_field_doesnt_exists()
    {
        $this->assertInstanceOf(NullField::class, FieldManager::getField('Test', 'test', []));
    }

    /** @test */
    public function it_should_return_random_field()
    {
        $this->assertInstanceOf(RandomField::class, FieldManager::getField('Test', 'random', []));
    }

    /** @test */
    public function it_should_return_belongsTo_field()
    {
        $this->assertInstanceOf(BelongsToField::class, FieldManager::getField('Test', 'belongsTo', 'AnotherModel'));
    }

    /** @test */
    public function it_should_return_hasMany_field()
    {
        $this->assertInstanceOf(HasManyField::class, FieldManager::getField('Test', 'hasMany', 'AnotherModel'));
    }

    /** @test */
    public function it_should_return_hasOne_field()
    {
        $this->assertInstanceOf(HasOneField::class, FieldManager::getField('Test', 'hasOne', 'AnotherModel'));
    }

    public function provideFakerMethods()
    {
        return [FakerField::SUPPORTED_METHODS];
    }

    /**
     * @test
     * @dataProvider provideFakerMethods
     */
    public function it_should_return_faker_field($input): void
    {
        $this->assertInstanceOf(FakerField::class, FieldManager::getField('Test', $input, []));
    }
}
