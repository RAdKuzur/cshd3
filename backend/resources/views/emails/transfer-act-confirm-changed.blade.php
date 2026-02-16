@extends('emails.layouts.base')

@section('header', '📄 Акт приёма/передачи/списания')
@section('title', 'Акт приёма/передачи/списания')
@section('message', '✅ Был подтверждён МОЛ!!!')

@section('details')
    • Тип документа: Акт приёма/передачи/списания<br>
@endsection

@section('button_url', $url ?? '#')
@section('button_text', '🔗 ОТКРЫТЬ ДОКУМЕНТ')
