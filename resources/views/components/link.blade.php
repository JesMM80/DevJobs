<div>
    @php
        $classes= "text-xs text-gray-500 hover:text-gray-900"
    @endphp

    {{-- attributes es una variable que existe en los componentes de laravel. En este caso desde la otra página le pasamos
        una ruta con href y lo detecta como un atributo ya que existe en los componentes de laravel.
        Y con el método merge lo que hace es unir todos los atributos que se le pase a la etiqueta A, como pueden ser las clases
        o el href, etc. Las clases le indicamos en un array de dónde las va a tomar. El href que viene desde la vista login no hizo
        falta pasarlo en el array ya que lo toma automaticamente laravel y lo recibe en la variable attributes.--}}
    <a {{$attributes->merge(['class'=>$classes])}}>
        {{ $slot }}
    </a>
</div>