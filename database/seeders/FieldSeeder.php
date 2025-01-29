<?php

namespace Database\Seeders;

use Tests\TestCase;
use App\Models\Form;
use App\Models\FieldType;
use App\Models\Field;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FieldSeeder extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_field()
    {
        $form = Form::create(['name' => 'Test Form']);
        $fieldType = FieldType::create(['name' => 'Text']);

        $field = Field::create([
            'form_id' => $form->id,
            'field_type_id' => $fieldType->id,
            'label' => 'First Name',
            'key' => 'first_name',
            'options' => json_encode(['max' => 50]),
            'sequence' => 1,
            'placeholder' => 'Enter your name',
            'required' => true,
        ]);

        $this->assertDatabaseHas('fields', ['key' => 'first_name']);
    }

    /** @test */
    public function it_requires_a_label_and_key()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Field::create([]);
    }

    /** @test */
    public function it_has_default_value_for_required()
    {
        $form = Form::create(['name' => 'Test Form']);
        $fieldType = FieldType::create(['name' => 'Text']);

        $field = Field::create([
            'form_id' => $form->id,
            'field_type_id' => $fieldType->id,
            'label' => 'Email',
            'key' => 'email',
        ]);

        $this->assertFalse($field->required);
    }

    /** @test */
    public function nullable_fields_can_be_null()
    {
        $form = Form::create(['name' => 'Test Form']);
        $fieldType = FieldType::create(['name' => 'Number']);

        $field = Field::create([
            'form_id' => $form->id,
            'field_type_id' => $fieldType->id,
            'label' => 'Age',
            'key' => 'age',
        ]);

        $this->assertNull($field->options);
        $this->assertNull($field->placeholder);
        $this->assertNull($field->sequence);
    }

    /** @test */
    public function it_deletes_fields_when_form_is_deleted()
    {
        $form = Form::create(['name' => 'Test Form']);
        $fieldType = FieldType::create(['name' => 'Text']);

        $field = Field::create([
            'form_id' => $form->id,
            'field_type_id' => $fieldType->id,
            'label' => 'Phone',
            'key' => 'phone',
        ]);

        $form->delete();

        $this->assertDatabaseMissing('fields', ['key' => 'phone']);
    }

    /** @test */
    public function it_deletes_fields_when_field_type_is_deleted()
    {
        $form = Form::create(['name' => 'Test Form']);
        $fieldType = FieldType::create(['name' => 'Dropdown']);

        $field = Field::create([
            'form_id' => $form->id,
            'field_type_id' => $fieldType->id,
            'label' => 'Country',
            'key' => 'country',
        ]);

        $fieldType->delete();

        $this->assertDatabaseMissing('fields', ['key' => 'country']);
    }
}
