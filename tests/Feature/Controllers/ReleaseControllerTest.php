<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Release;

use App\Models\Project;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReleaseControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_releases()
    {
        $releases = Release::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('releases.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.releases.index')
            ->assertViewHas('releases');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_release()
    {
        $response = $this->get(route('releases.create'));

        $response->assertOk()->assertViewIs('app.releases.create');
    }

    /**
     * @test
     */
    public function it_stores_the_release()
    {
        $data = Release::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('releases.store'), $data);

        $this->assertDatabaseHas('releases', $data);

        $release = Release::latest('id')->first();

        $response->assertRedirect(route('releases.edit', $release));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_release()
    {
        $release = Release::factory()->create();

        $response = $this->get(route('releases.show', $release));

        $response
            ->assertOk()
            ->assertViewIs('app.releases.show')
            ->assertViewHas('release');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_release()
    {
        $release = Release::factory()->create();

        $response = $this->get(route('releases.edit', $release));

        $response
            ->assertOk()
            ->assertViewIs('app.releases.edit')
            ->assertViewHas('release');
    }

    /**
     * @test
     */
    public function it_updates_the_release()
    {
        $release = Release::factory()->create();

        $project = Project::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'document' => $this->faker->text,
            'released_at' => $this->faker->dateTime,
            'status' => $this->faker->word,
            'project_id' => $project->id,
        ];

        $response = $this->put(route('releases.update', $release), $data);

        $data['id'] = $release->id;

        $this->assertDatabaseHas('releases', $data);

        $response->assertRedirect(route('releases.edit', $release));
    }

    /**
     * @test
     */
    public function it_deletes_the_release()
    {
        $release = Release::factory()->create();

        $response = $this->delete(route('releases.destroy', $release));

        $response->assertRedirect(route('releases.index'));

        $this->assertModelMissing($release);
    }
}
