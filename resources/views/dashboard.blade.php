<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bienvenido al Sistema de Reciclaje') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">¡Estás logueado con éxito!</h3>
                    <p class="mt-4">Puedes empezar a gestionar tu cuenta y explorar las diferentes opciones de recolección.</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium">Opciones rápidas:</h3>
                <ul class="mt-4 list-disc list-inside">
                    <li><a href="{{ route('collections.index') }}" class="text-blue-500">Solicitar Recolección de Residuos</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="text-blue-500">Editar Perfil</a></li>
                    <li><a href="#" class="text-blue-500">Historial de Recolecciones</a></li>
                    <li><a href="#" class="text-blue-500">Ver Métricas y Reportes</a></li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
