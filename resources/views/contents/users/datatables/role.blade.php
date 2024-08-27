@if ($query->roles->count())
    <ol class="mb-0" style="padding-left: 1rem;">
        @forelse ($query->roles->sortBy('name')->pluck('name') as $value)
            <li class="small text-nowrap">{{ $value }}</li>
        @empty
        @endforelse
    </ol>
@else
    <span class="text-muted fst-italic">
        {{ __('None') }}
    </span>
@endif
