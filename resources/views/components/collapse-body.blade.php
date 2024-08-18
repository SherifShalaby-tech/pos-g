<div {{ $attributes->merge(['class' => 'collapse']) }} id="{{ $collapseId }}">

    <div class="card mb-0 card-body">

        {{ $slot }}
    </div>
</div>
