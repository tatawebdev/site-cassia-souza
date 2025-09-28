@extends('layout')

@section('content')
    <h1>Serviços</h1>
    <ul>
        <li><a href="{{ route('tax-consulting') }}">Consultoria Tributária</a></li>
        <li><a href="/services/administrative-defense">Defesa Administrativa</a></li>
        <li><a href="/services/tax-planning">Planejamento Tributário</a></li>
        <li><a href="/services/credit-recovery">Recuperação de Crédito</a></li>
        <li><a href="/services/tax-compliance">Compliance Tributário</a></li>
    </ul>
@endsection
