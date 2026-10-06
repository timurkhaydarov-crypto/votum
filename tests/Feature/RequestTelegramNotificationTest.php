<?php

namespace Tests\Feature;

use App\Jobs\SendRequestTelegramNotification;
use App\Models\Request\Request as RequestModel;
use App\Models\Request\RequestItem;
use Illuminate\Http\Client\Request as HttpRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RequestTelegramNotificationTest extends TestCase
{
    public function test_it_sends_request_details_to_the_configured_chat(): void
    {
        Config::set('services.telegram.bot_token', 'test-token');
        Http::fake([
            'api.telegram.org/*' => Http::response(['ok' => true], 200),
        ]);

        $request = new RequestModel([
            'number' => 'REQ-20261002-ABC123',
            'context' => 'contact',
            'name' => 'Test <b>User</b>',
            'phone' => '+1 555 123 4567',
            'email' => 'test@example.com',
            'subject' => 'Product question',
            'comment' => 'Please <contact & me.',
        ]);
        $request->created_at = '2026-10-02 13:40:00';
        $request->setRelation('items', collect([
            new RequestItem([
                'article' => 'ABC-1',
                'product_name' => ['ru' => 'Контрольный прибор'],
                'quantity' => 2,
            ]),
        ]));

        (new SendRequestTelegramNotification($request, '-1001234567890'))
            ->handle();

        Http::assertSent(fn (HttpRequest $httpRequest) =>
            $httpRequest->url() === 'https://api.telegram.org/bottest-token/sendMessage'
            && $httpRequest['chat_id'] === '-1001234567890'
            && $httpRequest['parse_mode'] === 'HTML'
            && str_contains($httpRequest['text'], '📨 <b>НОВАЯ ЗАЯВКА</b>')
            && str_contains($httpRequest['text'], 'REQ-20261002-ABC123')
            && str_contains($httpRequest['text'], '02.10.2026 13:40')
            && str_contains($httpRequest['text'], 'Test &lt;b&gt;User&lt;/b&gt;')
            && str_contains($httpRequest['text'], 'test@example.com')
            && str_contains($httpRequest['text'], 'Please &lt;contact &amp; me.')
            && str_contains($httpRequest['text'], 'ТОВАРЫ · 1 поз.')
            && str_contains($httpRequest['text'], 'ABC-1')
            && str_contains($httpRequest['text'], 'Контрольный прибор × 2 шт.')
        );
    }
}