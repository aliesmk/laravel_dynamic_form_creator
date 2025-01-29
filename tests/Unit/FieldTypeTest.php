<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\FieldType;
use Illuminate\Foundation\Testing\RefreshDatabase;


class FieldTypeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_field_type()
    {
        $fieldType = FieldType::create([
            'name' => 'Text',
            'description' => 'A simple text field',
        ]);

        $this->assertDatabaseHas('field_type', ['name' => 'Text']);
    }

    /** @test */
    public function it_requires_a_name()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        FieldType::create([
            'description' => 'Missing name field',
        ]);
    }


    /** @test */
    public function description_can_be_nullable()
    {
        $fieldType = FieldType::create(['name' => 'No Description']);

        $this->assertNull($fieldType->description);
    }
}
