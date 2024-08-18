<button {{ $attributes->merge(['class' => 'btn btn-'.$color]) }} type="button" data-bs-toggle="collapse"
    data-bs-target="#{{ $collapseId }}"
    aria-expanded="false" aria-controls="{{ $collapseId }}" {{ $attributes }}>
    {{$slot}}
</button>



{{-- collapse component --}}
{{-- <div class="d-flex">

    <x-collapse-button color="secondary" collapse-id="collapseExample">
        button
    </x-collapse-button>

    <x-collapse-body collapse-id="collapseExample">
        Some placeholder content for the collapse component. This panel is hidden by default but revealed
        when the user
        activates the relevant trigger.
    </x-collapse-body>
</div> --}}
{{-- end collapse component --}}
