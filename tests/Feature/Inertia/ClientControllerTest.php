<?php

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function transformClient($client)
    {
        return [
            'id' => $client->id,
            'name' => $client->name,
            'rate' => $client->rate,
            'status' => $client->status ? 1 : 0,
            'updated_at' => $client->updated_at->toISOString(),
            'created_at' => $client->created_at->toISOString(),
        ];
    }

    public function test_index_method_displays_clients_page()
    {
        $clients = Client::factory(5)->create();

        $expectedClients = $clients->map(function ($client) {
            return $this->transformClient($client);
        });

        $response = $this->get(route('clients.index'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $assert) use ($expectedClients) {
            $assert->component('Clients')
                ->where('clients', $expectedClients);
        });
    }

    public function test_create_method_displays_add_client_page()
    {
        $response = $this->get(route('clients.create'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $assert) {
            $assert->component('AddClient');
        });
    }

    public function test_store_method_creates_client()
    {
        $clientData = [
            'name' => 'name',
            'rate' => 222,
            'status' => 1,
        ];

        $response = $this->post(route('clients.store'), $clientData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('clients', [
            'name' => 'name',
            'rate' => 222,
            'status' => 1,
        ]);
    }

    public function test_edit_method_displays_edit_client_page()
    {
        $client = Client::factory()->create();

        $response = $this->get("/clients/$client->id/edit");

        $response->assertStatus(200);

        $expectedClient = $this->transformClient($client);

        $response->assertInertia(function (AssertableInertia $assert) use ($expectedClient) {
            $assert->component('EditClient')->where('defaultClient', $expectedClient);
        });
    }

    public function test_update_method_updates_client()
    {
        $client = Client::factory()->create();
        $updatedData = [
            'name' => 'name',
            'rate' => 222,
            'status' => 1,
        ];

        $response = $this->put("/clients/$client->id", $updatedData);

        $this->assertDatabaseHas('clients', $updatedData);
        $response->assertStatus(302);
    }

    public function test_destroy_method_deletes_client()
    {
        $client = Client::factory()->create();

        $response = $this->delete("/clients/{$client->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}
