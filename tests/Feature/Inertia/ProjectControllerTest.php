<?php

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $client;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->client = Client::factory()->create();
    }

    public function transformProject($project)
    {
        return [
            'id' => $project->id,
            'clientId' => $project->client_id,
            'name' => $project->name,
            'status' => $project->status ? 1 : 0,
            'rate' => $project->rate,
            'client' => $this->client,
        ];
    }

    private function getProjectData()
    {
        return [
            'clientId' => $this->client->id,
            'name' => 'name',
            'status' => 1,
            'rate' => 22,
        ];
    }

    private function getProjectDataFromDB()
    {
        return [
            'client_id' => $this->client->id,
            'name' => 'name',
            'status' => 1,
            'rate' => 22,
        ];
    }

    public function test_index_method_displays_projects_page()
    {
        $project = Project::factory()->create($this->getProjectDataFromDB());

        $project->client()->associate($this->client);
        $project->save();

        $response = $this->get(route('projects.index'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $assert) use ($project) {
            $projectData = $project->toArray();
            $projectData['status'] = 1;
            $projectData['client']['status'] = $this->client->status ? 1 : 0;

            $assert->component('Projects')
                ->where('projects', [$projectData]);
        });
    }

    public function test_create_method_displays_add_project_page()
    {
        $response = $this->get(route('projects.create'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $assert) {
            $assert->component('AddProject');
        });
    }

    public function test_store_method_creates_project()
    {
        $ProjectData = $this->getProjectData();

        $response = $this->post(route('projects.store'), $ProjectData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('Projects', $this->getProjectDataFromDB());
    }

    public function test_edit_method_displays_edit_project_page()
    {
        $project = Project::factory()->create($this->getProjectDataFromDB());

        $project->client()->associate($this->client);
        $project->save();

        $response = $this->get("/projects/$project->id/edit");

        $expectedProject = $this->transformProject($project);

        $expectedProject['client'] = $this->client->toArray();
        $expectedProject['status'] = $expectedProject['status'] ? 1 : 0;
        $expectedProject['client']['status'] = $expectedProject['client']['status'] ? 1 : 0;

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $assert) use ($expectedProject) {
            $assert->component('EditProject')
                ->where('defaultProject', $expectedProject);
        });
    }

    public function test_update_method_updates_project()
    {
        $project = Project::factory()->create($this->getProjectDataFromDB());

        $project->client()->associate($this->client);
        $project->save();

        $updatedData = $this->getProjectData();

        $response = $this->put("/projects/$project->id", $updatedData);

        $this->assertDatabaseHas('Projects', $this->getProjectDataFromDB());
        $response->assertStatus(302);
    }

    public function test_destroy_method_deletes_project()
    {
        $project = Project::factory()->create($this->getProjectDataFromDB());

        $project->client()->associate($this->client);
        $project->save();

        $response = $this->delete("/projects/{$project->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
