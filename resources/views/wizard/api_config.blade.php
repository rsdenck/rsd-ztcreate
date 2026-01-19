@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">Configuração de API para Geração Automática</h2>
    <p class="text-gray-600">Informe os detalhes da API para que o sistema analise e gere o template automaticamente.</p>
</div>

<form action="{{ route('wizard.api_config.post') }}" method="POST">
    @csrf
    
    <div class="bg-white p-6 rounded-lg border mb-8">
        <h3 class="text-lg font-bold mb-4 border-b pb-2">1. Configuração Base</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">API BASE URL</label>
                <input type="url" name="base_url" required class="mt-1 block w-full rounded-md border-gray-300 border p-2" placeholder="https://api.exemplo.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tipo de API</label>
                <select name="api_type" class="mt-1 block w-full rounded-md border-gray-300 border p-2">
                    <option value="REST">REST (JSON)</option>
                    <option value="SOAP">SOAP (XML)</option>
                    <option value="GraphQL">GraphQL</option>
                    <option value="Custom">Custom/Other</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tipo de Autenticação</label>
                <select name="auth_type" class="mt-1 block w-full rounded-md border-gray-300 border p-2">
                    <option value="None">Nenhuma</option>
                    <option value="ApiKey">API Key (Header)</option>
                    <option value="Bearer">Bearer Token</option>
                    <option value="Basic">Basic Auth</option>
                    <option value="OAuth2">OAuth2 (Client Credentials)</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg border mb-8">
        <h3 class="text-lg font-bold mb-4 border-b pb-2">2. Endpoints para Análise</h3>
        <div id="endpoints-container">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 pb-4 border-b endpoint-row">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Endpoint Path</label>
                    <input type="text" name="endpoints[0][path]" required class="mt-1 block w-full rounded-md border-gray-300 border p-2" placeholder="/v1/metrics">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Método</label>
                    <select name="endpoints[0][method]" class="mt-1 block w-full rounded-md border-gray-300 border p-2">
                        <option value="GET">GET</option>
                        <option value="POST">POST</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Intervalo</label>
                    <input type="text" name="endpoints[0][delay]" value="1m" class="mt-1 block w-full rounded-md border-gray-300 border p-2">
                </div>
            </div>
        </div>
        <button type="button" onclick="addEndpoint()" class="text-blue-600 hover:text-blue-800 font-medium">+ Adicionar Outro Endpoint</button>
    </div>

    <div class="mt-8 flex justify-between">
        <a href="{{ route('wizard.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-150">Voltar</a>
        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-md font-bold hover:bg-blue-700 transition duration-150 shadow-lg">
            Analisar API e Gerar Template <i class="fas fa-magic ml-2"></i>
        </button>
    </div>
</form>

<script>
    let endpointCount = 1;
    function addEndpoint() {
        const container = document.getElementById('endpoints-container');
        const row = container.querySelector('.endpoint-row').cloneNode(true);
        const index = endpointCount++;
        row.querySelectorAll('input, select').forEach(el => {
            el.name = el.name.replace('[0]', `[${index}]`);
            if (el.tagName !== 'SELECT') el.value = el.defaultValue || '';
        });
        container.appendChild(row);
    }
</script>
@endsection
