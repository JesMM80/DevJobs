<div class="bg-gray-100 p-5 mt-10 flex flex-col justify-center items-center">
    <h3 class="text-center text-2xl font-bold my-4">
        Postularme a esta vacante
    </h3>

    {{-- Comprobamos si nos  llega llena la sesión con un mensaje desde la clase del componente livewire y mostramos mensaje. --}}
    @if(session()->has('mensaje'))
        <p class="uppercase border rounded-lg border-green-600 bg-green-100 text-green-600 font-bold p-2 my-5">
            {{session('mensaje')}}
        </p>
    @else

        <form wire:submit.prevent='postularme' class="w-96 mt-5">
            <div class="mb-4">
                <x-input-label for="cv" :value="('Currículum')" />

                <x-text-input id="cv" class="block mt-1 w-full" type="file" wire:model="cv" accept=".pdf" />
            </div>

            @error('cv')
                {{-- Si hubiera un error en la validación de la clase del componente, se mostraría este mensaje. --}}
                <livewire:mostrar-alerta :message="$message">
            @enderror

            <x-primary-button class="my-5">Postularme</x-primary-button>
        </form>
    @endif

</div>
