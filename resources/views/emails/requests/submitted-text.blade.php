@php
    $contextLabel = match ($request->context) {
        'cart' => 'Запрос из корзины',
        'service' => 'Запрос по услуге',
        default => 'Обращение с сайта',
    };
@endphp

{{ $forCompany ? 'НОВАЯ ЗАЯВКА' : 'ЗАЯВКА ПРИНЯТА' }}
{{ $forCompany ? ($request->subject ?: $contextLabel) : 'Спасибо за обращение. Мы скоро свяжемся с вами.' }}

Номер: №{{ $request->number }}
Тип: {{ $contextLabel }}
Дата: {{ $request->created_at?->format('d.m.Y H:i') }}

Контактные данные
Имя: {{ $request->name }}
Телефон: {{ $request->phone }}
@if($request->email)
Email: {{ $request->email }}
@endif
@if($request->subject)
Тема: {{ $request->subject }}
@endif
@if($request->comment)
Комментарий:
{{ $request->comment }}
@endif
@if($request->items->isNotEmpty())
Товары:
@foreach($request->items as $item)
@php
    $itemName = is_array($item->product_name)
        ? ($item->product_name['ru'] ?? $item->product_name['en'] ?? '')
        : $item->product_name;
@endphp
- {{ $item->article }} {{ $itemName }} — {{ $item->quantity }} шт.
@endforeach
@endif

{{ config('app.name') }}
