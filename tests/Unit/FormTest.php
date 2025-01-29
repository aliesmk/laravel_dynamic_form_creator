<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Form;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormTest extends TestCase
{
    use RefreshDatabase;

    // برای پاک کردن دیتابیس بین تست‌ها

    /** @test */
    public function it_can_create_a_form()
    {
        $form = Form::create([
            'name' => 'Test Form',
            'description' => 'This is a test form.',
        ]);

        $this->assertDatabaseHas('forms', ['name' => 'Test Form']);
    }

    /** @test */
    public function it_requires_a_name()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Form::create([
            'description' => 'Missing name field',
        ]);
    }

    /** @test */
    public function description_can_be_nullable()
    {
        $form = Form::create(['name' => 'No Description']);

        $this->assertNull($form->description);
    }

    /** @test */
    public function it_can_be_soft_deleted()
    {
        $form = Form::create(['name' => 'Soft Delete Test']);

        $form->delete();

        $this->assertSoftDeleted('forms', ['name' => 'Soft Delete Test']);
    }

}
