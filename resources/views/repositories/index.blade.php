<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Respositorios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p class="text-right mb-4">
                <a class="bg-blue-500 text-white font-bold py-2 px-4 rounded-md text-xs"
                    href="{{ route('repositories.create') }}">
                    + Agregar nuevo repositorio
                </a>
            </p>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Enlace</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($repositories as $repository)
                            <tr>
                                <td class="border px-4 py-2">{{ $repository->id }}</td>
                                <td class="border px-4 py-2">{{ $repository->url }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ $repository->url }}">
                                        Ver
                                    </a>
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('repositories.edit', $repository->id) }}">
                                        Editar
                                    </a>
                                </td>
                                <td class="px-4 py-2">
                                    <form method="POST" action="{{ route('repositories.destroy', $repository->id) }}">
                                        @csrf @method('DELETE')
                                        <button class="px-4 rounded-md bg-red-600 text-white text-bold" type="submit">
                                            -Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No hay repositorios creados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
