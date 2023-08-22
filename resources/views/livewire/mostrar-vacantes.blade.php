<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        views/livewire/mostrar-vacantes
        @forelse ($vacantes as $vacante)
            <div class="p-4 bg-white border-b border-gray-200 md:flex md:justify-between md:items-center">
                <div class="space-y-3">
                    <a href="{{ route('vacantes.show',$vacante->id) }}" class="text-xl font-bold hover:text-gray-300 ">
                        {{$vacante->titulo}}
                    </a>
                    <p class="text-sm text-gray-600 font-bold">{{$vacante->empresa}}</p>
                    <p class="text-sm text-gray-500">Último día: {{$vacante->ultimo_dia->format('d/m/Y')}}</p>
                </div>
                <div class="flex flex-col md:flex-row gap-3 items-stretch mt-5 md:mt-0">
                    <a href="{{route('candidatos.index',$vacante)}}" class="bg-slate-800 py-2 px-4 rounded-lg text-white text-xs font-bold uppercase text-center">
                        {{-- Con la relación que hicimos de candidatos podemos usar el método count para que muestre cuantos candidatos hay. --}}
                        {{$vacante->candidatos->count()}}
                        Candidatos
                    </a>
                    <a href="{{ route('vacantes.edit', $vacante->id)}}" class="bg-blue-800 py-2 px-4 rounded-lg text-white text-xs font-bold uppercase text-center">
                        Editar
                    </a>
                    {{-- La función emit emite un evento, es reservada de livewire --}}
                    <button wire:click="$emit('mostrarAlerta', {{$vacante->id}}) " class="bg-red-600 py-2 px-4 rounded-lg text-white text-xs font-bold uppercase text-center">
                        Eliminar
                    </button>
                </div>
            </div>
            
        {{-- Se itera sobre los resultados del array y en caso de que no haya nada se muestra el mensaje. De esta forma es más corto
        que añadir un if y luego un foreach. --}}
        @empty
            <p class="p-3 text-center text-sm text-gray-600">No hay vacantes para mostrar</p>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $vacantes->links() }}
    </div>
</div>

    {{-- Le agregamos la librería de sweetalert. Esto lo definimos previamente al final de la vista app.blade --}}
    @push('scripts')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Tenemos acceso a una global. Y podemos ejecutar una arrow function, que es igual que usar una función anónima.
            // Forma de ejecutarla sin pasar parámetros:
            // Livewire.on('prueba', () => {

            // De esta otra forma ejecutamos la arrow function pasándole la variable vacanteId que enviamos 
            // desde $emit('prueba', {{}})
            Livewire.on('mostrarAlerta', vacanteId => {
                Swal.fire({
                    title: 'Eliminar vacante',
                    text: "No se podrá recuperar!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Borrar!'
                    }).then((result) => {
                    if (result.isConfirmed) {

                        //Emitimos un evento para eliminar la vacante
                        Livewire.emit('eliminarVacante',vacanteId)
                        Swal.fire(
                        'Eliminada!',
                        'La vacante ha sido eliminada.',
                        'success'
                        )
                    }
                })
            })
        </script>
    @endpush
