@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">Passo 6: Web Scenarios (HTTP Tests)</h2>
    <p class="text-gray-600">Configure monitoramento de URL, APIs e fluxos HTTP.</p>
</div>

<form action="{{ route('wizard.step6.post') }}" method="POST">
    @csrf
    
    <div id="scenarios-container">
        <!-- Scenario Block -->
        <div class="bg-blue-50 p-6 rounded-lg mb-8 border border-blue-100 scenario-block">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Nome do Web Scenario</label>
                    <input type="text" name="web_scenarios[0][name]" class="mt-1 block w-full rounded-md border-gray-300 border p-2" placeholder="Ex: API Health Check">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Intervalo (Delay)</label>
                    <input type="text" name="web_scenarios[0][delay]" class="mt-1 block w-full rounded-md border-gray-300 border p-2" value="1m">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tentativas (Retries)</label>
                    <input type="number" name="web_scenarios[0][retries]" class="mt-1 block w-full rounded-md border-gray-300 border p-2" value="1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Agente HTTP</label>
                    <select name="web_scenarios[0][agent]" class="mt-1 block w-full rounded-md border-gray-300 border p-2">
                        <option value="Zabbix">Zabbix</option>
                        <option value="Mozilla/5.0">Mozilla/5.0 (Chrome/Firefox)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Autenticação</label>
                    <select name="web_scenarios[0][authentication]" class="mt-1 block w-full rounded-md border-gray-300 border p-2">
                        <option value="0">Nenhuma</option>
                        <option value="1">Basic Auth</option>
                        <option value="5">Bearer Token</option>
                    </select>
                </div>
            </div>

            <!-- Steps Container -->
            <div class="bg-white p-4 rounded border border-blue-100">
                <h4 class="font-bold text-gray-700 mb-4">Steps (Passos)</h4>
                <div class="steps-container">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 pb-4 border-b step-row">
                        <div class="md:col-span-1">
                            <label class="text-xs font-bold uppercase text-gray-500">Nome do Step</label>
                            <input type="text" name="web_scenarios[0][steps][0][name]" class="mt-1 block w-full text-sm border-gray-300 border p-1 rounded" placeholder="Check status">
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-xs font-bold uppercase text-gray-500">URL</label>
                            <input type="text" name="web_scenarios[0][steps][0][url]" class="mt-1 block w-full text-sm border-gray-300 border p-1 rounded" placeholder="https://api.example.com/v1/health">
                        </div>
                        <div>
                            <label class="text-xs font-bold uppercase text-gray-500">Status Code Esperado</label>
                            <input type="text" name="web_scenarios[0][steps][0][status_codes]" class="mt-1 block w-full text-sm border-gray-300 border p-1 rounded" value="200">
                        </div>
                    </div>
                </div>
                <button type="button" class="text-blue-600 hover:text-blue-800 text-xs font-bold uppercase mt-2">
                    + Adicionar Step
                </button>
            </div>
        </div>
    </div>

    <button type="button" onclick="addScenario()" class="bg-white border border-blue-600 text-blue-600 px-4 py-2 rounded-md hover:bg-blue-50 transition duration-150">
        <i class="fas fa-plus mr-1"></i> Adicionar Novo Web Scenario
    </button>

    <div class="mt-8 flex justify-between">
        <a href="{{ route('wizard.step5') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-150">
            <i class="fas fa-arrow-left mr-2"></i> Voltar
        </a>
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition duration-150">
            Finalizar Configuração <i class="fas fa-check-circle ml-2"></i>
        </button>
    </div>
</form>

<script>
    let scenarioCount = 1;

    function addScenario() {
        const container = document.getElementById('scenarios-container');
        const firstBlock = container.querySelector('.scenario-block');
        const newBlock = firstBlock.cloneNode(true);
        
        const index = scenarioCount++;
        const inputs = newBlock.querySelectorAll('input, select');

        inputs.forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                // Update web_scenarios[0] to web_scenarios[index]
                input.setAttribute('name', name.replace(/web_scenarios\[\d+\]/, `web_scenarios[${index}]`));
                if (input.tagName !== 'SELECT') input.value = input.defaultValue || '';
            }
        });

        container.appendChild(newBlock);
    }
</script>
@endsection
