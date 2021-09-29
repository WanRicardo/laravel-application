@if (!isset($show) || $show)
    <span class="badge badge-{{ $type == '' ? 'success' : $type }}">
        {{ $message }}
    </span>
@endif