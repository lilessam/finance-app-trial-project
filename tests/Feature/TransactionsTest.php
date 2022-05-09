<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Tests\TestCase;

class TransactionsTest extends TestCase
{
    /**
     * Test list endpoint.
     *
     * @return void
     */
    public function testListEndpoint()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/transactions');

        $response->assertStatus(200);
    }

    /**
     * Test storing endpoint.
     *
     * @return void
     */
    public function testStoreEndpoint()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->postJson('/transactions', [
            'label' => 'Test',
            'amount' => 100,
            'amount_date' => now(),
        ]);

        $response->assertStatus(201)->assertJsonFragment([
            'label' => 'Test',
        ]);
    }

    /**
     * Test update endpoint.
     *
     * @return void
     */
    public function testUpdateEndpoint()
    {
        $this->actingAs(User::factory()->create());

        $transaction = Transaction::factory()->create();

        $response = $this->putJson('/transactions/'.$transaction->id, [
            'label' => 'Test Updated',
        ]);

        $response->assertStatus(200)->assertJsonFragment([
            'label' => 'Test Updated',
        ]);
    }

    /**
     * Test delete endpoint.
     *
     * @return void
     */
    public function testDeleteEndpoint()
    {
        $this->actingAs(User::factory()->create());

        $transaction = Transaction::factory()->create();

        $response = $this->delete('/transactions/'.$transaction->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('transactions', [
            'id' => $transaction->id,
        ]);
    }
}
