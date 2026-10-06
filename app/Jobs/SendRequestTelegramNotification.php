<?php

namespace App\Jobs;

use App\Models\Request\Request as RequestModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use RuntimeException;

class SendRequestTelegramNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public array $backoff = [60, 300, 900];

    public function __construct(
        public RequestModel $request,
        public string $chatId
    ) {}

    public function handle(): void
    {
        $botToken = config('services.telegram.bot_token');

        if (! $botToken) {
            return;
        }

        $this->request->loadMissing('items');

        $message = $this->formatMessage($this->request);

        try {
            $response = Http::timeout(10)->post(
                "https://api.telegram.org/bot{$botToken}/sendMessage",
                [
                    'chat_id' => $this->chatId,
                    'text' => $message,
                    'parse_mode' => 'HTML',
                    'disable_web_page_preview' => true,
                ]
            );
        } catch (ConnectionException) {
            $this->logFailure(null);
            throw new RuntimeException('Telegram notification delivery failed.');
        }

        if (! $response->successful() || ! $response->json('ok')) {
            $this->logFailure($response->status());
            throw new RuntimeException('Telegram notification delivery failed.');
        }
    }

    private function formatMessage(RequestModel $request): string
    {
        $context = match ($request->context) {
            'cart' => 'Заявка из корзины',
            'service' => 'Запрос по услуге',
            default => 'Обращение с сайта',
        };

        $lines = [];
        $characterCount = 0;
        $appendLine = function (string $line) use (&$lines, &$characterCount): bool {
            $plainText = html_entity_decode(
                strip_tags($line),
                ENT_QUOTES | ENT_HTML5,
                'UTF-8'
            );
            $lineLength = mb_strlen($plainText) + ($lines === [] ? 0 : 1);

            if ($characterCount + $lineLength > 4000) {
                return false;
            }

            $lines[] = $line;
            $characterCount += $lineLength;

            return true;
        };

        $createdAt = $request->created_at?->format('d.m.Y H:i');

        $appendLine('📨 <b>НОВАЯ ЗАЯВКА</b>');
        $appendLine('№ <code>'.$this->escape($request->number).'</code>'
            .($createdAt ? ' · '.$createdAt : ''));
        $appendLine('Тип: '.$this->escape($context));
        $appendLine('');
        $appendLine('👤 <b>КОНТАКТ</b>');
        $appendLine('Имя: '.$this->escape($request->name));
        $appendLine('☎️ '.$this->escape($request->phone));
        $appendLine('✉️ '.$this->escape($request->email));

        if ($request->subject) {
            $appendLine('');
            $appendLine('📌 <b>ТЕМА</b>');
            $appendLine($this->escape($request->subject));
        }

        if ($request->comment) {
            $appendLine('');
            $appendLine('💬 <b>КОММЕНТАРИЙ</b>');
            $appendLine($this->escape($request->comment));
        }

        if ($request->items->isNotEmpty()) {
            $appendLine('');
            $appendLine('🛒 <b>ТОВАРЫ · '.$request->items->count().' поз.</b>');

            foreach ($request->items as $index => $item) {
                if ($index >= 20) {
                    $appendLine('… и ещё товаров: '.($request->items->count() - $index));
                    break;
                }

                $name = is_array($item->product_name)
                    ? ($item->product_name['ru'] ?? $item->product_name['en'] ?? '')
                    : $item->product_name;

                $itemLine = '• <b>'.$this->escape($item->article).'</b> · '
                    .$this->escape($name).' × '.$item->quantity.' шт.';

                if (! $appendLine($itemLine)) {
                    $appendLine('… список сокращён');
                    break;
                }
            }
        }

        return implode("\n", $lines);
    }

    private function escape(?string $value): string
    {
        return htmlspecialchars(
            $value ?? '',
            ENT_QUOTES | ENT_SUBSTITUTE,
            'UTF-8'
        );
    }

    private function logFailure(?int $status): void
    {
        Log::warning('Telegram request notification failed.', [
            'request_id' => $this->request->id,
            'chat_id' => $this->chatId,
            'status' => $status,
        ]);
    }
}