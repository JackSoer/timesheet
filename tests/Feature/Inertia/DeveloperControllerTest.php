<?php

use App\Models\Developer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class DeveloperControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function transformDeveloper($developer)
    {
        return [
            'id' => $developer->id,
            'firstName' => $developer->first_name,
            'lastName' => $developer->last_name,
            'status' => $developer->status ? 1 : 0,
            'rate' => $developer->rate,
            'ratePercent' => $developer->rate_percent,
        ];
    }

    private function getDeveloperData()
    {
        return [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'rate' => 222,
            'ratePercent' => 22,
            'status' => 1,
        ];
    }

    private function getDeveloperDataFromDB()
    {
        return [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'rate' => 222,
            'rate_percent' => 22,
            'status' => 1,
        ];
    }
    public function test_index_method_displays_developers_page()
    {
        $developers = Developer::factory(5)->create();

        $expectedDevelopers = $developers->map(function ($developer) {
            return $this->transformDeveloper($developer);
        });

        $response = $this->get(route('developers.index'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $assert) use ($expectedDevelopers) {
            $assert->component('Developers')
                ->where('developers', $expectedDevelopers);
        });
    }

    public function test_create_method_displays_add_developer_page()
    {
        $response = $this->get(route('developers.create'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $assert) {
            $assert->component('AddDeveloper');
        });
    }

    public function test_store_method_creates_developer()
    {
        $developerData = $this->getDeveloperData();

        $response = $this->post(route('developers.store'), $developerData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('developers', $this->getDeveloperDataFromDB());
    }

    public function test_edit_method_displays_edit_developer_page()
    {
        $developer = Developer::factory()->create();

        $response = $this->get("/developers/$developer->id/edit");

        $response->assertStatus(200);

        $expectedDeveloper = $this->transformdeveloper($developer);

        $response->assertInertia(function (AssertableInertia $assert) use ($expectedDeveloper) {
            $assert->component('EditDeveloper')->where('defaultDeveloper', $expectedDeveloper);
        });
    }

    public function test_update_method_updates_developer()
    {
        $developer = Developer::factory()->create();
        $updatedData = $this->getDeveloperData();

        $response = $this->put("/developers/$developer->id", $updatedData);

        $this->assertDatabaseHas('developers', $this->getDeveloperDataFromDB());
        $response->assertStatus(302);
    }

    public function test_destroy_method_deletes_developer()
    {
        $developer = Developer::factory()->create();

        $response = $this->delete("/developers/{$developer->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('developers', ['id' => $developer->id]);
    }
}
