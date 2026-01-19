@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">Passo 5: Trigger Creator (Inteligente)</h2>
    <p class="text-gray-600">Construa gatilhos avançados com validação e suporte a funções Zabbix.</p>
</div>

<form action="{{ route('wizard.step5.post') }}" method="POST">
    @csrf
    
    <div id="triggers-container" class="space-y-6">
        <!-- Template de Trigger -->
        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm trigger-card relative">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nome do Gatilho</label>
                    <input type="text" name="triggers[0][name]" class="mt-1 block w-full rounded-md border-gray-300 border p-2" placeholder="Ex: High CPU usage on {HOST.NAME}" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Severidade</label>
                    <select name="triggers[0][priority]" class="mt-1 block w-full rounded-md border-gray-300 border p-2">
                        <option value="0">Not classified</option>
                        <option value="1">Information</option>
                        <option value="2">Warning</option>
                        <option value="3">Average</option>
                        <option value="4" selected>High</option>
                        <option value="5">Disaster</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Expressão de Problema (Zabbix Expression)</label>
                <div class="flex gap-2">
                    <input type="text" name="triggers[0][expression]" id="expr_0" class="mt-1 block w-full rounded-md border-gray-300 border p-2 font-mono text-sm" placeholder="Ex: last(/host/cpu.util) > 80" required>
                    <button type="button" onclick="openExpressionBuilder(0)" class="mt-1 px-3 py-2 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200" title="Assistente de Expressão">
                        <i class="fas fa-magic"></i>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Modo de Recuperação</label>
                    <select name="triggers[0][recovery_mode]" onchange="toggleRecovery(this, 0)" class="mt-1 block w-full rounded-md border-gray-300 border p-2">
                        <option value="0">Expressão</option>
                        <option value="1">Expressão de Recuperação</option>
                        <option value="2">Nenhum</option>
                    </select>
                </div>
                <div id="recovery_expr_container_0" class="hidden">
                    <label class="block text-sm font-medium text-gray-700">Expressão de Recuperação</label>
                    <input type="text" name="triggers[0][recovery_expression]" class="mt-1 block w-full rounded-md border-gray-300 border p-2 font-mono text-sm" placeholder="Ex: last(/host/cpu.util) < 50">
                </div>
            </div>

            <div class="flex items-center gap-4 mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="triggers[0][manual_close]" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Permitir fechamento manual</span>
                </label>
            </div>

            <div class="border-t pt-4 mt-4">
                <h4 class="text-sm font-semibold text-gray-600 mb-2">Tags do Gatilho</h4>
                <div id="tags-container-0" class="space-y-2">
                    <div class="flex gap-2">
                        <input type="text" name="triggers[0][tags][0][tag]" class="block w-1/2 rounded-md border-gray-300 border p-1 text-sm" placeholder="Tag">
                        <input type="text" name="triggers[0][tags][0][value]" class="block w-1/2 rounded-md border-gray-300 border p-1 text-sm" placeholder="Valor">
                    </div>
                </div>
                <button type="button" onclick="addTag(0)" class="mt-2 text-xs text-blue-600 hover:text-blue-800">+ Adicionar Tag</button>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <button type="button" onclick="addTrigger()" class="flex items-center justify-center w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:border-blue-400 hover:text-blue-500 transition-colors">
            <i class="fas fa-plus mr-2"></i> Adicionar Outro Gatilho
        </button>
    </div>

    <div class="mt-8 flex justify-between">
        <a href="{{ route('wizard.step4') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-150">
            Voltar
        </a>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-150">
            Próximo Passo: Web Scenarios <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </div>
</form>

<!-- Modal Auxiliar (Simulado para o MVP) -->
<div id="expr-builder-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Assistente de Expressão</h3>
            <div class="mt-2 px-7 py-3 text-left">
                <label class="block text-xs font-bold text-gray-500 uppercase">Função</label>
                <select id="modal_func" class="w-full border p-2 rounded mt-1">
                    <option value="last">last() - Último valor</option>
                    <option value="avg">avg() - Média</option>
                    <option value="min">min() - Mínimo</option>
                    <option value="max">max() - Máximo</option>
                    <option value="nodata">nodata() - Sem dados</option>
                </select>
                
                <label class="block text-xs font-bold text-gray-500 uppercase mt-4">Operador</label>
                <select id="modal_op" class="w-full border p-2 rounded mt-1">
                    <option value=">">></option>
                    <option value="<"><</option>
                    <option value="=">=</option>
                    <option value="!=">!=</option>
                </select>

                <label class="block text-xs font-bold text-gray-500 uppercase mt-4">Valor/Threshold</label>
                <input type="text" id="modal_val" class="w-full border p-2 rounded mt-1" placeholder="Ex: 80">
            </div>
            <div class="items-center px-4 py-3">
                <button id="ok-btn" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Inserir
                </button>
                <button onclick="closeModal()" class="mt-2 px-4 py-2 bg-gray-100 text-gray-700 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-200">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let triggerCount = 1;
    let currentTargetInput = null;

    function addTrigger() {
        const container = document.getElementById('triggers-container');
        const card = container.querySelector('.trigger-card').cloneNode(true);
        const index = triggerCount++;
        
        card.querySelectorAll('input, select').forEach(el => {
            if (el.name) {
                el.name = el.name.replace(/\[\d+\]/, `[${index}]`);
            }
            if (el.id) {
                el.id = el.id.replace(/_\d+/, `_${index}`);
            }
            if (el.type !== 'checkbox' && el.tagName !== 'SELECT') {
                el.value = '';
            }
        });

        // Reset tags for new trigger
        const tagsContainer = card.querySelector('[id^="tags-container"]');
        tagsContainer.id = `tags-container-${index}`;
        tagsContainer.innerHTML = `
            <div class="flex gap-2">
                <input type="text" name="triggers[${index}][tags][0][tag]" class="block w-1/2 rounded-md border-gray-300 border p-1 text-sm" placeholder="Tag">
                <input type="text" name="triggers[${index}][tags][0][value]" class="block w-1/2 rounded-md border-gray-300 border p-1 text-sm" placeholder="Valor">
            </div>
        `;

        // Reset recovery container
        const recoveryContainer = card.querySelector('[id^="recovery_expr_container"]');
        recoveryContainer.id = `recovery_expr_container-${index}`;
        recoveryContainer.classList.add('hidden');

        // Update builder button
        const builderBtn = card.querySelector('button[onclick^="openExpressionBuilder"]');
        builderBtn.setAttribute('onclick', `openExpressionBuilder(${index})`);

        // Update tag button
        const tagBtn = card.querySelector('button[onclick^="addTag"]');
        tagBtn.setAttribute('onclick', `addTag(${index})`);

        container.appendChild(card);
    }

    function toggleRecovery(select, index) {
        const container = document.getElementById(`recovery_expr_container_${index}`) || document.getElementById(`recovery_expr_container-${index}`);
        if (select.value === '1') {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }

    function addTag(triggerIndex) {
        const container = document.getElementById(`tags-container-${triggerIndex}`) || document.getElementById(`tags-container_${triggerIndex}`);
        const tagCount = container.querySelectorAll('.flex').length;
        const div = document.createElement('div');
        div.className = 'flex gap-2 mt-2';
        div.innerHTML = `
            <input type="text" name="triggers[${triggerIndex}][tags][${tagCount}][tag]" class="block w-1/2 rounded-md border-gray-300 border p-1 text-sm" placeholder="Tag">
            <input type="text" name="triggers[${triggerIndex}][tags][${tagCount}][value]" class="block w-1/2 rounded-md border-gray-300 border p-1 text-sm" placeholder="Valor">
        `;
        container.appendChild(div);
    }

    function openExpressionBuilder(index) {
        currentTargetInput = document.getElementById(`expr_${index}`) || document.querySelector(`input[name="triggers[${index}][expression]"]`);
        document.getElementById('expr-builder-modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('expr-builder-modal').classList.add('hidden');
    }

    document.getElementById('ok-btn').onclick = function() {
        if (currentTargetInput) {
            const func = document.getElementById('modal_func').value;
            const op = document.getElementById('modal_op').value;
            const val = document.getElementById('modal_val').value;
            currentTargetInput.value = `${func}(/host/key) ${op} ${val}`;
        }
        closeModal();
    };
</script>
@endsection
