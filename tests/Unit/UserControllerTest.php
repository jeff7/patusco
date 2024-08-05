<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Appointment;

class UserControllerTest extends TestCase
{
     use RefreshDatabase;
   
     #[\PHPUnit\Framework\Attributes\Test]
     public function it_can_store_a_user_and_return_a_token()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'user_type' => 'R',
        ];

        $response = $this->postJson(route('user.store'), $data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'user_type' => 'R',
        ]);

        $response->assertJson([
            'status' => 'success',
            'user' => [
                'name' => 'John Doe',
                'email' => 'john@example.com',
            ],
            'authorization' => [
                'type' => 'bearer',
            ],
        ]);

        $response->assertJsonStructure([
            'authorization' => [
                'token',
                'type',
            ],
        ]);

        $jsonResponse = $response->json();
        $token = $jsonResponse['authorization']['token'];

        $this->assertNotNull($token);

    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_show_a_user_with_appointments()
    {

        $user = User::factory()->create();
        $appointments = Appointment::factory()->count(3)->create(['user_id' => $user->id]);
        $response = $this->getJson(route('user.show', ['user' => $user->id]));
        $response->assertStatus(200);

    }

     #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_update_a_user()
    {
        $user = User::factory()->create();
        
        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
            'password' => 'newpassword123', 
            'user_type' => 'R', 
        ];

        $response = $this->putJson(route('user.update', ['user' => $user->id]), $updatedData);

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $updatedData['name'],
            'email' => $updatedData['email'],
            'user_type' => $updatedData['user_type'],
        ]);
    }

     #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();
        
        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
            'password' => 'newpassword123', 
            'user_type' => 'R', 
        ];

        $response = $this->deleteJson(route('user.destroy', ['user' => $user->id]));

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'deletado',
        ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
