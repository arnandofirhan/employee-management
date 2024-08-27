@if ($query->is_active)
    <div class="badge badge-success fw-bold py-2 px-3">{{ strtoupper(__('Active')) }}</div>
@else
    <div class="badge badge-secondary fw-bold py-2 px-3">{{ strtoupper(__('Inactive')) }}</div>
@endif
