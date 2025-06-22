<div class="container mx-auto my-8 px-4">
    <h2 class="text-2xl font-bold mb-6">LOGStation - ESTACIO PROJETO IOT</h2>

    <!-- Filtros: grid responsiva -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <input
            wire:model.debounce.500ms="search"
            type="text"
            class="w-full p-3 border border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200"
            placeholder="🔍 Buscar log ou observação"
        >

        <select wire:model="typeLog" class="w-full p-3 border border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200">
            <option value="">📂 Todos os tipos</option>
            <option value="INFO">INFO</option>
            <option value="SOFT">SOFT</option>
            <option value="WARN">WARN</option>
            <option value="URGENT">URGENT</option>
            <option value="CRITICAL">CRITICAL</option>
        </select>

        <input
            wire:model.debounce.500ms="source"
            type="text"
            class="w-full p-3 border border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200"
            placeholder="📌 Filtrar por Source"
        >
    </div>

    <!-- Indicador de carregamento -->
    <div wire:loading class="mb-4">
        <div class="text-blue-600 font-semibold animate-pulse">⏳ Carregando registros...</div>
    </div>

    <!-- Tabela responsiva com overflow-x -->
    <div class="w-full overflow-x-auto rounded shadow-sm border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">#ID</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Source</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Type</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Log</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Obs</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Timestamp</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-4 py-3 whitespace-nowrap">{{ $log->id }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $log->source }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                switch ($log->type_log) {
                                    case 'INFO':
                                        $badge = 'bg-green-100 text-green-800';
                                        break;
                                    case 'SOFT':
                                        $badge = 'bg-blue-100 text-blue-800';
                                        break;
                                    case 'WARN':
                                        $badge = 'bg-yellow-100 text-yellow-800';
                                        break;
                                    case 'URGENT':
                                        $badge = 'bg-red-100 text-red-800';
                                        break;
                                    case 'CRITICAL':
                                        $badge = 'bg-red-200 text-red-900 font-bold';
                                        break;
                                    default:
                                        $badge = 'bg-gray-200 text-gray-800';
                                }
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                {{ $log->type_log }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $log->log }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $log->textobs }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $log->updated_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500 italic">
                            😕 Nenhum log encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    <div class="mt-6">
        {{ $logs->links() }}
    </div>
</div>
