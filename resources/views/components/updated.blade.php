<p class="text-muted">
    {{ $action != '' ? $action : 'Added ' }} {{ $date->diffForHumans() }}
    {{ $name != '' ? 'by ' . $name : '' }}
</p>