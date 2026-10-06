<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>Заявка №{{ $request->number }}</title>
</head>
<body style="margin:0; padding:32px 12px; background-color:#f1f5f4; color:#1c2928; font-family:Arial,Helvetica,sans-serif;">
    @php
        $contextLabel = match ($request->context) {
            'cart' => 'Запрос из корзины',
            'service' => 'Запрос по услуге',
            default => 'Обращение с сайта',
        };
    @endphp

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width:640px; margin:0 auto;">
        <tr>
            <td style="padding:0 0 14px; color:#647572; font-size:12px; letter-spacing:1.5px; text-transform:uppercase;">
                {{ config('app.name') }}
            </td>
        </tr>
        <tr>
            <td style="overflow:hidden; border:1px solid #dce5e2; border-radius:12px; background:#ffffff;">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td style="padding:28px 30px; background:#173b39; color:#ffffff;">
                            <div style="margin-bottom:10px; color:#c4e6a1; font-size:11px; font-weight:bold; letter-spacing:1.2px; text-transform:uppercase;">
                                {{ $forCompany ? 'Новая заявка' : 'Заявка принята' }}
                            </div>
                            <h1 style="margin:0; font-size:25px; line-height:1.3; font-weight:700;">
                                {{ $forCompany ? ($request->subject ?: $contextLabel) : 'Спасибо за обращение' }}
                            </h1>
                            <p style="margin:12px 0 0; color:#d7e4e1; font-size:14px; line-height:1.6;">
                                {{ $forCompany ? 'Новая заявка с сайта. Свяжитесь с клиентом по указанным контактам.' : 'Мы получили вашу заявку и скоро свяжемся с вами.' }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:26px 30px 30px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom:20px;">
                                <tr>
                                    <td style="padding:0 0 12px; color:#71817e; font-size:12px;">Номер заявки</td>
                                    <td align="right" style="padding:0 0 12px; color:#173b39; font-size:14px; font-weight:bold;">№{{ $request->number }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0; border-top:1px solid #e8eeec; color:#71817e; font-size:12px;">Тип обращения</td>
                                    <td align="right" style="padding:12px 0; border-top:1px solid #e8eeec; color:#273937; font-size:13px;">{{ $contextLabel }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0; border-top:1px solid #e8eeec; color:#71817e; font-size:12px;">Дата</td>
                                    <td align="right" style="padding:12px 0; border-top:1px solid #e8eeec; color:#273937; font-size:13px;">{{ $request->created_at?->format('d.m.Y H:i') }}</td>
                                </tr>
                            </table>

                            <h2 style="margin:24px 0 12px; color:#173b39; font-size:15px;">Контактные данные</h2>
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="border:1px solid #e2eae7; border-radius:8px; background:#f8faf9;">
                                <tr>
                                    <td style="padding:14px 16px; color:#71817e; font-size:12px;">Имя</td>
                                    <td align="right" style="padding:14px 16px; color:#273937; font-size:13px; font-weight:bold;">{{ $request->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 16px 14px; color:#71817e; font-size:12px;">Телефон</td>
                                    <td align="right" style="padding:0 16px 14px; color:#273937; font-size:13px;">{{ $request->phone }}</td>
                                </tr>
                                @if($request->email)
                                    <tr>
                                        <td style="padding:0 16px 14px; color:#71817e; font-size:12px;">Email</td>
                                        <td align="right" style="padding:0 16px 14px; font-size:13px;"><a href="mailto:{{ $request->email }}" style="color:#17665e; text-decoration:underline;">{{ $request->email }}</a></td>
                                    </tr>
                                @endif
                            </table>

                            @if($request->subject)
                                <h2 style="margin:24px 0 8px; color:#173b39; font-size:15px;">Тема</h2>
                                <p style="margin:0; color:#354441; font-size:13px; line-height:1.7;">{{ $request->subject }}</p>
                            @endif

                            @if($request->comment)
                                <h2 style="margin:24px 0 8px; color:#173b39; font-size:15px;">Комментарий</h2>
                                <p style="margin:0; color:#354441; font-size:13px; line-height:1.7;">{!! nl2br(e($request->comment)) !!}</p>
                            @endif

                            @if($request->items->isNotEmpty())
                                <h2 style="margin:24px 0 12px; color:#173b39; font-size:15px;">Товары в заявке</h2>
                                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="border-collapse:collapse;">
                                    @foreach($request->items as $item)
                                        @php
                                            $itemName = is_array($item->product_name)
                                                ? ($item->product_name['ru'] ?? $item->product_name['en'] ?? '')
                                                : $item->product_name;
                                        @endphp
                                        <tr>
                                            <td style="padding:12px 8px; border-top:1px solid #e8eeec; color:#354441; font-size:13px;">
                                                <strong style="color:#71817e;">{{ $item->article }}</strong><br>
                                                {{ $itemName }}
                                            </td>
                                            <td align="right" style="padding:12px 8px; border-top:1px solid #e8eeec; color:#173b39; font-size:13px; white-space:nowrap;">{{ $item->quantity }} шт.</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:18px 8px 0; color:#879592; font-size:11px; line-height:1.6; text-align:center;">
                Это автоматическое сообщение с сайта {{ config('app.name') }}.
            </td>
        </tr>
    </table>
</body>
</html>
