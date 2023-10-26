<?php

use App\Http\Controllers\DashboardController;
use App\Models\Developer;
use App\Models\Project;
use App\Models\User;
use App\Models\WorkLog;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_dashboard_displays_correct_data()
    {
        $date = Carbon::now();

        $response = $this->get("/work-logs/{$date->year}/{$date->format('F')}");

        $response->assertStatus(200);

        $response->assertInertia(function ($assert) {
            $assert->component('Dashboard');
        });
    }

    public function test_get_work_logs_by_developers()
    {
        $workLogs = [
            (object) [
                'developer' => (object) ['first_name' => 'John', 'last_name' => 'Doe'],
                'date' => '2023-10-01',
                'hrs' => 5,
            ],
            (object) [
                'developer' => (object) ['first_name' => 'Jane', 'last_name' => 'Smith'],
                'date' => '2023-10-01',
                'hrs' => 3,
            ],
            (object) [
                'developer' => (object) ['first_name' => 'John', 'last_name' => 'Doe'],
                'date' => '2023-10-02',
                'hrs' => 2,
            ],
        ];

        $dashboardController = new DashboardController;
        $result = $dashboardController->getWorkLogsByDevelopers($workLogs);

        $expectedResult = [
            [
                'developer' => 'John Doe',
                'logs' => [
                    ['date' => '2023-10-01', 'hrs' => 5],
                    ['date' => '2023-10-02', 'hrs' => 2],
                ],
            ],
            [
                'developer' => 'Jane Smith',
                'logs' => [
                    ['date' => '2023-10-01', 'hrs' => 3],
                ],
            ],
        ];

        $this->assertEquals($expectedResult, $result);
    }

    public function test_get_paid_this_month_amount()
    {
        $developer = Developer::factory()->create();
        $project = Project::factory()->create();

        $workLogPaid = WorkLog::factory()->create([
            'developer_id' => $developer->id,
            'project_id' => $project->id,
            'status' => 200,
            'date' => now()->format('Y-m-d'),
            'rate' => 12,
            'hrs' => 12321,
            'total' => 123,
        ]);

        WorkLog::factory()->create([
            'developer_id' => $developer->id,
            'project_id' => $project->id,
            'status' => 100,
            'date' => now()->format('Y-m-d'),
            'rate' => 12,
            'hrs' => 12321,
            'total' => 123,
        ]);

        $dashboardController = new DashboardController();
        $paidThisMonth = $dashboardController->getPaidThisMonthAmount();

        $this->assertEquals($workLogPaid->total, $paidThisMonth);
    }

    public function testGetUnpaidAmount()
    {
        WorkLog::factory()->create(['status' => 100, 'total' => 50]);
        WorkLog::factory()->create(['status' => 200, 'total' => 100]);
        WorkLog::factory()->create(['status' => 100, 'total' => 75]);

        $controller = new DashboardController();

        $unpaidAmount = $controller->getUnpaidAmount();

        $this->assertEquals(125, $unpaidAmount);
    }
}
