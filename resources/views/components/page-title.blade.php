@props([
'buttons'=>"",
])
<div class="card mb-2 page-title">
    <div class="card-header py-2 d-flex align-items-center justify-content-between">
        {{ $slot }}

        {{ $buttons ?? $buttons }}
    </div>
</div>
