<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Perfil
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Mensaje de éxito -->
                    @if (session('status') === 'profile-updated')
                        <div class="mb-4 text-green-600">
                            Perfil actualizado correctamente.
                        </div>
                    @endif

                    <!-- Formulario para actualizar perfil -->
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-6">
                            <!-- Nombre -->
                            <div>
                                <x-input-label for="name" :value="__('Nombre')" />
                                <x-text-input
                                    id="name"
                                    name="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    :value="old('name', $user->name)"
                                    required
                                    autofocus
                                    autocomplete="name"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input
                                    id="email"
                                    name="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    :value="old('email', $user->email)"
                                    required
                                    autocomplete="username"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <x-input-label for="phone" :value="__('Teléfono')" />
                                <x-text-input
                                    id="phone"
                                    name="phone"
                                    type="text"
                                    class="mt-1 block w-full"
                                    :value="old('phone', $user->phone)"
                                    autocomplete="tel"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Guardar') }}</x-primary-button>
                            </div>
                        </div>
                    </form>

                    <!-- Formulario para eliminar cuenta -->
                    <div class="mt-12 border-t border-gray-200 pt-6">
                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('DELETE')

                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Eliminar Cuenta') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Una vez eliminada tu cuenta, todos tus datos serán borrados permanentemente.') }}
                            </p>

                            <div class="mt-6">
                                <x-input-label for="password" :value="__('Contraseña Actual')" class="sr-only" />
                                <x-text-input
                                    id="password"
                                    name="password"
                                    type="password"
                                    class="mt-1 block w-1/2"
                                    placeholder="{{ __('Tu contraseña actual') }}"
                                    required
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>

                            <div class="mt-6">
                                <x-danger-button>
                                    {{ __('Eliminar Cuenta') }}
                                </x-danger-button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
