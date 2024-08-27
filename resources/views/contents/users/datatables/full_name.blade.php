<div class="d-flex align-items-center">
    <div class="symbol symbol-circle symbol-25px overflow-hidden me-3">
        <div class="symbol-label">
            <img src="{{ $query->full_image_url }}" alt="{{ $query->full_name }}" class="w-100" />
        </div>
    </div>
    <div class="d-flex flex-column">
        <span class="text-gray-800 @if ($query->short_name) mb-1 @endif">{{ $query->full_name }}</span>
        @if ($query->short_name)
            <span>{{ $query->short_name }}</span>
        @endif
    </div>
</div>
