@props(['labelTextColor','labelColor'])

@php
 
    $labelTextColor = match ($labelTextColor) {
        'grey'      => 'text-grey-100',
        'yellow'    => 'text-yellow-100',
        'blue'     => 'text-blue-100',
        'green'     => 'text-green-100',
        default   => 'text-white-100',
    };

    $labelColor = match ($labelColor) {
        'grey'      => 'bg-grey-100',
        'yellow'    => 'bg-yellow-100',
        'blue'     => 'bg-blue-100',
        'green'     => 'bg-green-100',
        default   => 'bg-red-800',
    };

@endphp

<button {{$attributes}} class="{{$labelTextColor}} {{$labelColor}} text-white rounded-xl px-3 py-1 text-base">
    {{$slot}}
</button>