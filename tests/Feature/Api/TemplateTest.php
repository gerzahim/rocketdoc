<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Template;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TemplateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_templates_list()
    {
        $templates = Template::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.templates.index'));

        $response->assertOk()->assertSee($templates[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_template()
    {
        $data = Template::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.templates.store'), $data);

        $this->assertDatabaseHas('templates', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_template()
    {
        $template = Template::factory()->create();

        $data = [
            'name' => $this->faker->text(255),
            'document' => $this->faker->text,
        ];

        $response = $this->putJson(
            route('api.templates.update', $template),
            $data
        );

        $data['id'] = $template->id;

        $this->assertDatabaseHas('templates', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_template()
    {
        $template = Template::factory()->create();

        $response = $this->deleteJson(
            route('api.templates.destroy', $template)
        );

        $this->assertModelMissing($template);

        $response->assertNoContent();
    }
}
