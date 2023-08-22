{{-- space-y-5 separa los componentes "hijos" de 1er nivel del formulario. Añadimos la propiedad wire:submit.prevent para
enviar la información. Le pasamos una función --}}
<form class="md:w-1/2 space-y-5" wire:submit.prevent='crearVacante'> 
    <div>
        <x-input-label for="titulo" :value="__('Titulo vacante')" />

        <x-text-input id="titulo" class="block mt-1 w-full" type="text" wire:model="titulo" :value="old('titulo')" placeholder="Título vacante" autofocus />

        <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
        
    </div>

    <div>
        <x-input-label for="salario" :value="__('Salario mensual')" />
        <select wire:model="salario" id="salario" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option>-- Seleccione --</option>
            {{-- Recogemos el array de la clase crearVacante y mostramos los resultados --}}
            @foreach ($salarios as $salario)
                <option value="{{ $salario->id }}">{{ $salario->salario }}</option>            
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('salario')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="categoria" :value="__('Categoría')" />
        <select wire:model="categoria" id="categoria" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option>-- Seleccione --</option>
            {{-- Recogemos el array de la clase crearVacante y mostramos los resultados --}}
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->categoria }}</option>            
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('categoria')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="empresa" :value="__('Empresa')" />

        <x-text-input id="empresa" class="block mt-1 w-full" type="text" wire:model="empresa" :value="old('empresa')" placeholder="Nombre de la empresa" autofocus />
       
        <x-input-error :messages="$errors->get('empresa')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="ultimo_dia" :value="__('Último día para postularse')" />

        <x-text-input id="ultimo_dia" class="block mt-1 w-full" type="date" wire:model="ultimo_dia" :value="old('ultimo_dia')" autofocus />
        
        <x-input-error :messages="$errors->get('ultimo_dia')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="descripcion" :value="__('Descripción puesto')" />
        <textarea wire:model="descripcion" id="descripcion" placeholder="Descripción del puesto" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-50">
        </textarea>
    </div>

    <div>
        <x-input-label for="imagen" :value="__('Imagen')" />

        {{-- Con la propiedad accept de html5 podemos indicarle que acepte sólo archivos de imágenes, en cualquier formato --}}
        <x-text-input id="imagen" class="block mt-1 w-full" type="file" wire:model="imagen" accept="image/*" />

        <div class="my-5 w-80">
            @if ($imagen)
                {{-- Podemos mostrar una preview de la imagen con este método --}}
                <img src=" {{$imagen->temporaryURL() }} " />
            @endif
        </div>
        <x-input-error :messages="$errors->get('imagen')" class="mt-2" />
    </div>

    <x-primary-button>Crear vacante</x-primary-button>
</form>