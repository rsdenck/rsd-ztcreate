@extends('layouts.app')

@section('content')
<div class="mb-8 text-center">
    <div class="inline-block p-4 rounded-full bg-green-100 text-green-600 mb-4">
        <i class="fas fa-check-circle fa-3x"></i>
    </div>
    <h2 class="text-3xl font-bold text-gray-800">Configuração Concluída!</h2>
    <p class="text-gray-600">Seu template Zabbix está pronto para ser gerado.</p>
</div>

<div class="bg-white border rounded-lg overflow-hidden mb-8">
    <div class="bg-gray-50 px-6 py-4 border-b">
        <h3 class="font-bold text-gray-700">Resumo do Template</h3>
    </div>
    <div class="p-6">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
            <div>
                <dt class="text-sm font-medium text-gray-500">Nome do Template</dt>
                <dd class="text-lg text-gray-900">{{ $data['name'] }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Versão do Zabbix</dt>
                <dd class="text-lg text-gray-900">{{ $data['zabbix_version'] }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Itens Regulares</dt>
                <dd class="text-lg text-gray-900">{{ count($data['items'] ?? []) }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Regras de Descoberta (LLD)</dt>
                <dd class="text-lg text-gray-900">{{ count($data['discovery_rules'] ?? []) }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Web Scenarios</dt>
                <dd class="text-lg text-gray-900">{{ count($data['web_scenarios'] ?? []) }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Gatilhos</dt>
                <dd class="text-lg text-gray-900">{{ count($data['triggers'] ?? []) }}</dd>
            </div>
        </dl>
    </div>
</div>

<div class="flex flex-col items-center space-y-4">
    <form action="{{ route('wizard.export') }}" method="POST" class="w-full max-w-md">
        @csrf
        <button type="submit" class="w-full bg-blue-600 text-white px-8 py-4 rounded-lg font-bold text-xl hover:bg-blue-700 transition duration-150 shadow-lg">
            <i class="fas fa-download mr-2"></i> Baixar Template JSON
        </button>
    </form>
    
    <a href="{{ route('wizard.index') }}" class="text-blue-600 hover:underline">
        Criar outro template
    </a>
</div>
@endsection
