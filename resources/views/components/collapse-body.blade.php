<div {{ $attributes->merge(['class' => 'collapse ']) }} style="width:100%" id="{{ $collapseId }}">

    <div class="card mb-0 card-body">

        {{ $slot }}
    </div>
</div>
