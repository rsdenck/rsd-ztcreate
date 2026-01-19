@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">Passo 2: Macros e Tags Globais</h2>
    <p class="text-gray-600">Defina as macros de usuário e tags que serão aplicadas a todo o template.</p>
</div>

<form action="{{ route('wizard.step2.post') }}" method="POST">
    @csrf
    
    <div class="mb-8">
        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Macros do Template</h3>
        <div id="macros-container">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 macro-row">
                <input type="text" name="macros[0][macro]" class="rounded-md border-gray-300 border p-2" placeholder="{$MACRO}">
                <input type="text" name="macros[0][value]" class="rounded-md border-gray-300 border p-2" placeholder="Valor">
                <select name="macros[0][type]" class="rounded-md border-gray-300 border p-2">
                    <option value="0">Texto</option>
                    <option value="1">Secret</option>
                    <option value="2">Vault</option>
                </select>
                <input type="text" name="macros[0][description]" class="rounded-md border-gray-300 border p-2" placeholder="Descrição">
            </div>
        </div>
        <button type="button" onclick="addRow('macros-container', 'macro-row')" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
            <i class="fas fa-plus mr-1"></i> Adicionar Macro
        </button>
    </div>

    <div class="mb-8">
        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Tags Globais</h3>
        <div id="tags-container">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 tag-row">
                <input type="text" name="tags[0][tag]" class="rounded-md border-gray-300 border p-2" placeholder="Tag">
                <input type="text" name="tags[0][value]" class="rounded-md border-gray-300 border p-2" placeholder="Valor">
                <div></div>
            </div>
        </div>
        <button type="button" onclick="addRow('tags-container', 'tag-row')" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
            <i class="fas fa-plus mr-1"></i> Adicionar Tag
        </button>
    </div>

    <div class="mt-8 flex justify-between">
        <a href="{{ route('wizard.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-150">
            <i class="fas fa-arrow-left mr-2"></i> Voltar
        </a>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-150">
            Próximo Passo <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </div>
</form>

<script>
    let macroCount = 1;
    let tagCount = 1;

    function addRow(containerId, rowClass) {
        const container = document.getElementById(containerId);
        const firstRow = container.querySelector('.' + rowClass);
        const newRow = firstRow.cloneNode(true);
        
        const inputs = newRow.querySelectorAll('input, select');
        const index = containerId === 'macros-container' ? macroCount++ : tagCount++;
        const namePrefix = containerId === 'macros-container' ? 'macros' : 'tags';

        inputs.forEach(input => {
            input.value = '';
            const name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace(/\[\d+\]/, '[' + index + ']'));
            }
        });

        container.appendChild(newRow);
    }
</script>
@endsection
