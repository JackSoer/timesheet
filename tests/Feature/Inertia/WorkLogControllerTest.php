<?php

use App\Models\Client;
use App\Models\Developer;
use App\Models\Project;
use App\Models\User;
use App\Models\WorkLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class WorkLogControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $developer;
    protected $project;
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->developer = Developer::factory()->create();
        $this->client = Client::factory()->create();
        $this->project = Project::factory()->create(
            ['client_id' => $this->client->id,
                'name' => 'name',
                'status' => 1,
                'rate' => 22]);

        $this->project->client()->associate($this->client);
        $this->project->save();
    }

    private function getWorkLogData()
    {
        return [
            'projectId' => $this->project->id,
            'developerId' => $this->developer->id,
            'date' => '2023-10-10',
            'status' => 200,
            'rate' => 123,
            'hrs' => 12,
            'total' => 123,
        ];
    }

    private function getWorkLogDataFromDB()
    {
        return [
            'project_id' => $this->project->id,
            'developer_id' => $this->developer->id,
            'date' => '2023-10-10',
            'status' => 200,
            'rate' => 123,
            'hrs' => 12,
            'total' => 123,
        ];
    }

    public function test_index_method_displays_workLogs_page()
    {
        $workLog = WorkLog::factory()->create($this->getWorkLogDataFromDB());

        $workLog->developer()->associate($this->developer);
        $workLog->project()->associate($this->project);

        $workLog->save();

        $response = $this->get(route('work-logs.index'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $assert) use ($workLog) {
            $assert->component('WorkLogs');
        });
    }

    public function test_create_method_displays_add_workLog_page()
    {
        $response = $this->get(route('work-logs.create'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $assert) {
            $assert->component('AddWorkLog');
        });
    }

    public function test_store_method_creates_workLog()
    {
        $workLogData = $this->getWorkLogData();

        $this->post(route('work-logs.store'), $workLogData);

        $this->assertDatabaseHas('work_logs', $this->getWorkLogDataFromDB());
    }

    public function test_edit_method_displays_edit_workLog_page()
    {
        $workLog = WorkLog::factory()->create($this->getWorkLogDataFromDB());

        $workLog->developer()->associate($this->developer);
        $workLog->project()->associate($this->project);

        $workLog->save();

        $response = $this->get("/work-logs/$workLog->id/edit");

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $assert) use ($workLog) {
            $assert->component('EditWorkLog');
        });
    }

    public function test_update_method_updates_workLog()
    {
        $workLog = WorkLog::factory()->create($this->getWorkLogDataFromDB());

        $workLog->developer()->associate($this->developer);
        $workLog->project()->associate($this->project);

        $workLog->save();

        $updatedData = $this->getWorkLogData();

        $response = $this->put("/work-logs/$workLog->id", $updatedData);

        $this->assertDatabaseHas('work_logs', $this->getworkLogDataFromDB());
        $response->assertStatus(302);
    }

    public function test_destroy_method_deletes_workLog()
    {
        $workLog = WorkLog::factory()->create($this->getWorkLogDataFromDB());

        $workLog->developer()->associate($this->developer);
        $workLog->project()->associate($this->project);

        $workLog->save();

        $response = $this->delete("/work-logs/{$workLog->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('work_logs', ['id' => $workLog->id]);
    }
}
