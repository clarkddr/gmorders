@php
    use Carbon\Carbon;
    Carbon::setLocale('es');
@endphp
<x-layout>
    @if(session('banner'))
        <x-banner message="{{session('banner.message')}}" type="success" class=""/>
    @endif
    {{-- Encabezado con título y espacio para dropdowns --}}
    <x-titlePage title="Reportes de desempeño diario por Sucursal" >

    </x-titlePage>
    <div class="overflow-hidden shadow-xs dark:bg-gray-900 rounded-lg mb-6">
        <div class="rounded-lg">
            <div class="grid gap-6 md:grid-cols-8">
                {{-- Table --}}
                <div class="md:col-span-8 rounded-lg shadow-xs"> <!-- Ocupa 4/12 -->
                    <table id="table" class="py-0 w-full whitespace-no-wrap mx-0 rounded-lg shadow-xs">
                        <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3"></th>
                            <th class="px-4 py-3">Sucursal</th>
                            <th class="px-4 py-3">Abrir</th>
                            <th class="px-4 py-3">Copiar</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($branchTargets as $branchTarget)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">{{ $branchTarget->id }}</td>
                                <td class="px-4 py-3">{{ $branchTarget->branch->Name ?? 'Todas' }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('branchTarget.show', $branchTarget->slug) }}"
                                       class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-700 rounded-md"
                                        target="_blank">
                                        Abrir
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded"
                                            id="copyButton-{{ $branchTarget->id }}"
                                            data-link="{{ route('branchTarget.show', $branchTarget->slug) }}"
                                            onclick="copyLink(this)">
                                        Copiar link
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <tr>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                {{-- End Table --}}
            </div>
            {{-- <x-pagination/> --}}
        </div>
    </div>



</x-layout>
<script>
    let lastCopiedButton = null; // Guardamos el último botón copiado

    function copyLink(button) {
        const link = button.getAttribute('data-link');

        // Cambiar el texto del botón a "COPIADO"
        if (lastCopiedButton && lastCopiedButton !== button) {
            lastCopiedButton.innerText = "Copiar link"; // Restaurar el texto del botón anterior
        }
        button.innerText = "Copiado!!";  // Cambiar el texto del botón actual

        // Guardamos el botón actual como el último copiado
        lastCopiedButton = button;

        // Usamos la API moderna de clipboard si está disponible
        if (navigator.clipboard) {
            navigator.clipboard.writeText(link)
                .then(() => {
                    // Éxito al copiar el texto
                    console.log('Link copiado');
                })
                .catch(err => {
                    console.error('Error al copiar:', err);
                    alert('No se pudo copiar el link');
                });
        } else {
            // Método alternativo para navegadores sin clipboard API
            const textArea = document.createElement('textarea');
            textArea.value = link;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
        }
    }
</script>







<style>
    div.dt-container div.dt-layout-row {
        margin: 0 !important;
    }
    form {
        margin: 0;
        padding: 0;
        border: none;
    }
    input, button, select, textarea {
        border: none;
        outline: none;
        background: none; /* Quita el fondo predeterminado */
        padding: 0; /* Quita el padding */
    }
</style>
