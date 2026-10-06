<?php

namespace Tests\Feature;

use Tests\TestCase;

class RequestValidationTest extends TestCase
{
    public function test_validation_errors_use_the_requested_application_locale(): void
    {
        $this->postJson('/api/requests', [], [
            'X-App-Locale' => 'ru',
        ])
            ->assertUnprocessable()
            ->assertJsonPath('errors.name.0', 'Поле имя обязательно для заполнения.')
            ->assertJsonPath('errors.phone.0', 'Поле телефон обязательно для заполнения.')
            ->assertJsonPath('errors.email.0', 'Поле электронная почта обязательно для заполнения.');

        $this->postJson('/api/requests', [
            'name' => 'Test User',
            'phone' => 'not-a-phone',
        ], [
            'X-App-Locale' => 'en',
        ])
            ->assertUnprocessable()
            ->assertJsonPath('errors.phone.0', 'Please enter a valid phone number with 7–15 digits.')
            ->assertJsonPath('errors.email.0', 'The email field is required.');

        $this->postJson('/api/requests', [
            'name' => 'Test User',
            'phone' => '+1 555 123 4567',
            'email' => 'not-an-email',
        ], [
            'X-App-Locale' => 'en',
        ])
            ->assertUnprocessable()
            ->assertJsonPath('errors.email.0', 'Please enter a valid email address.');
    }

    public function test_honeypot_submission_is_discarded_without_creating_a_request(): void
    {
        $this->postJson('/api/requests', [
            'website' => 'https://spam.example',
        ])
            ->assertAccepted()
            ->assertJsonPath('request', null);
    }
}