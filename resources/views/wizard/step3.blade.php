@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">Passo 3: Itens Regulares</h2>
    <p class="text-gray-600">Defina os itens de coleta direta (não LLD).</p>
</div>

<form action="{{ route('wizard.step3.post') }}" method="POST">
    @csrf
    
    <div id="items-container">
        <div class="bg-gray-50 p-4 rounded-lg mb-6 border item-block">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Nome do Item</label>
                    <input type="text" name="items[0][name]" class="mt-1 block w-full rounded-md border-gray-300 border p-2" placeholder="Ex: CPU load">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipo de Coleta</label>
                    <select name="items[0][type]" class="mt-1 block w-full rounded-md border-gray-300 border p-2">
                        <option value="0">Zabbix Agent</option>
                        <option value="7">Zabbix Agent (Active)</option>
                        <option value="20">SNMP Agent</option>
                        <option value="16">HTTP Agent</option>
                        <option value="18">Dependent Item</option>
                        <option value="19">Script</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Chave</label>
                    <input type="text" name="items[0][key]" class="mt-1 block w-full rounded-md border-gray-300 border p-2" placeholder="system.cpu.load">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipo de Informação</label>
                    <select name="items[0][value_type]" class="mt-1 block w-full rounded-md border-gray-300 border p-2">
                        <option value="0">Float</option>
                        <option value="3" selected>Unsigned</option>
                        <option value="4">Text</option>
                        <option value="1">Character</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Intervalo</label>
                    <input type="text" name="items[0][delay]" class="mt-1 block w-full rounded-md border-gray-300 border p-2" value="1m">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Unidade</label>
                    <input type="text" name="items[0][units]" class="mt-1 block w-full rounded-md border-gray-300 border p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">SNMP OID (se aplicável)</label>
                    <input type="text" name="items[0][snmp_oid]" class="mt-1 block w-full rounded-md border-gray-300 border p-2">
                </div>
            </div>
        </div>
    </div>

    <button type="button" onclick="addItem()" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
        <i class="fas fa-plus mr-1"></i> Adicionar Outro Item
    </button>

    <div class="mt-8 flex justify-between">
        <a href="{{ route('wizard.step2') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-150">
            <i class="fas fa-arrow-left mr-2"></i> Voltar
        </a>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-150">
            Próximo Passo <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </div>
</form>

<script>
    let itemCount = 1;

    function addItem() {
        const container = document.getElementById('items-container');
        const firstBlock = container.querySelector('.item-block');
        const newBlock = firstBlock.cloneNode(true);
        
        const inputs = newBlock.querySelectorAll('input, select');
        const index = itemCount++;

        inputs.forEach(input => {
            if (input.tagName === 'SELECT') {
                // Keep default values for selects or reset them
            } else {
                input.value = input.getAttribute('value') || '';
            }
            const name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace(/\[\d+\]/, '[' + index + ']'));
            }
        });

        container.appendChild(newBlock);
    }
</script>
@endsection
