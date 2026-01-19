@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">Passo 5: Triggers (Gatilhos)</h2>
    <p class="text-gray-600">Defina as condições de alerta para os itens do template.</p>
</div>

<form action="{{ route('wizard.step5.post') }}" method="POST">
    @csrf
    
    <div id="triggers-container">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 pb-4 border-b trigger-row">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Nome do Gatilho</label>
                <input type="text" name="triggers[0][name]" class="mt-1 block w-full rounded-md border-gray-300 border p-2" placeholder="Ex: High CPU usage on {HOST.NAME}">
            </div>
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Expressão</label>
                <input type="text" name="triggers[0][expression]" class="mt-1 block w-full rounded-md border-gray-300 border p-2" placeholder="Ex: last(/Tmpl/cpu.util) > 80">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Severidade</label>
                <select name="triggers[0][priority]" class="mt-1 block w-full rounded-md border-gray-300 border p-2">
                    <option value="0">Not classified</option>
                    <option value="1">Information</option>
                    <option value="2">Warning</option>
                    <option value="3">Average</option>
                    <option value="4">High</option>
                    <option value="5">Disaster</option>
                </select>
            </div>
        </div>
    </div>

    <button type="button" onclick="addTrigger()" class="text-blue-600 hover:text-blue-800 font-medium">
        + Adicionar Outro Gatilho
    </button>

    <div class="mt-8 flex justify-between">
        <a href="{{ route('wizard.step4') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-150">
            Voltar
        </a>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-150">
            Próximo Passo: Web Scenarios <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </div>
</form>

<script>
    let triggerCount = 1;
    function addTrigger() {
        const container = document.getElementById('triggers-container');
        const row = container.querySelector('.trigger-row').cloneNode(true);
        const index = triggerCount++;
        row.querySelectorAll('input, select').forEach(el => {
            el.name = el.name.replace('[0]', `[${index}]`);
            el.value = '';
        });
        container.appendChild(row);
    }
</script>
@endsection
