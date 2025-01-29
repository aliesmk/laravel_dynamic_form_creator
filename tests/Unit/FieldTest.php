<?php

namespace Tests\Unit;

use App\Models\FieldType;
use Tests\TestCase;
use App\Models\Form;
use App\Models\Fields;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FieldTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_field()
    {
        $form = Form::create(['name' => 'Test Form']);
        $fieldType = FieldType::create(['name' => 'Checkbox']);
        $field = Fields::create([
            'form_id' => $form->id,
            'field_type_id' => $fieldType->id,
            'label' => 'First Name',
            'key' => 'first_name',
            'options' => json_encode(['max' => 50]),
            'sequence' => 1,
            'placeholder' => 'Enter your name',
            'required' => true,
        ]);

        $this->assertDatabaseHas('field', ['key' => 'first_name']);
    }

    /** @test */
    public function it_requires_a_label_and_key()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Fields::create([]);
    }



    /** @test */
    public function nullable_fields_can_be_null()
    {
        $form = Form::create(['name' => 'Test Form']);
        $fieldType = FieldType::create(['name' => 'Number']);

        $field = Fields::create([
            'form_id' => $form->id,
            'field_type_id' => $fieldType->id,
            'label' => 'Age',
            'key' => 'age',
        ]);

        $this->assertNull($field->options);
        $this->assertNull($field->placeholder);
        $this->assertNull($field->sequence);
    }

}
