@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">Passo 1: Metadados do Template</h2>
    <p class="text-gray-600">Defina as informações básicas do seu template Zabbix.</p>
</div>

<form action="{{ route('wizard.step1') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Nome do Template</label>
            <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2" placeholder="Ex: Linux by Zabbix Agent Active">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Grupos (separados por vírgula)</label>
            <input type="text" name="groups" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2" placeholder="Ex: Templates/Operating Systems, Linux">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Vendor (Fabricante)</label>
            <input type="text" name="vendor_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2" placeholder="Ex: Zabbix">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Versão do Vendor</label>
            <input type="text" name="vendor_version" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2" placeholder="Ex: 1.0">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Descrição</label>
            <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2" placeholder="Descrição detalhada do template..."></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Versão do Zabbix</label>
            <select name="zabbix_version" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                <option value="6.0">Zabbix 6.0 LTS</option>
                <option value="6.4">Zabbix 6.4</option>
                <option value="7.0" selected>Zabbix 7.0 LTS</option>
            </select>
        </div>
    </div>

    <div class="mt-8 flex justify-end">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-150">
            Próximo Passo <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </div>
</form>
@endsection
