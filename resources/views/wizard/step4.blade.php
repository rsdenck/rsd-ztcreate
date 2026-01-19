@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">Passo 4: Low Level Discovery (LLD)</h2>
    <p class="text-gray-600">Defina as regras de descoberta automática.</p>
</div>

<form action="{{ route('wizard.step4.post') }}" method="POST">
    @csrf
    
    <div id="lld-container">
        <div class="bg-blue-50 p-4 rounded-lg mb-6 border border-blue-200 lld-block">
            <h3 class="font-bold text-blue-800 mb-4">Discovery Rule</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Nome da Descoberta</label>
                    <input type="text" name="discovery_rules[0][name]" class="mt-1 block w-full rounded-md border-gray-300 border p-2" placeholder="Ex: Network Interface Discovery">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipo</label>
                    <select name="discovery_rules[0][type]" class="mt-1 block w-full rounded-md border-gray-300 border p-2">
                        <option value="0">Zabbix Agent</option>
                        <option value="20">SNMP Agent</option>
                        <option value="16">HTTP Agent</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Chave</label>
                    <input type="text" name="discovery_rules[0][key]" class="mt-1 block w-full rounded-md border-gray-300 border p-2" placeholder="net.if.discovery">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Intervalo</label>
                    <input type="text" name="discovery_rules[0][delay]" class="mt-1 block w-full rounded-md border-gray-300 border p-2" value="1h">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700">SNMP OID / API URL</label>
                    <input type="text" name="discovery_rules[0][snmp_oid]" class="mt-1 block w-full rounded-md border-gray-300 border p-2" placeholder="discovery[{#IFNAME}, IF-MIB::ifName]">
                </div>
            </div>
        </div>
    </div>

    <button type="button" onclick="addLLD()" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
        <i class="fas fa-plus mr-1"></i> Adicionar Outra Regra de Descoberta
    </button>

    <div class="mt-8 flex justify-between">
        <a href="{{ route('wizard.step3') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-150">
            <i class="fas fa-arrow-left mr-2"></i> Voltar
        </a>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-150">
            Próximo Passo <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </div>
</form>

<script>
    let lldCount = 1;

    function addLLD() {
        const container = document.getElementById('lld-container');
        const firstBlock = container.querySelector('.lld-block');
        const newBlock = firstBlock.cloneNode(true);
        
        const inputs = newBlock.querySelectorAll('input, select');
        const index = lldCount++;

        inputs.forEach(input => {
            if (input.tagName === 'SELECT') {
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
