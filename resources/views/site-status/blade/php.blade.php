<h2>Website Status Alert</h2>

<p>
    URL:
    {{ $monitor->url }}
</p>

<p>
    Status:
    <strong>
        {{ strtoupper($status) }}
    </strong>
</p>

@if($status === 'down')
<p>
    The site appears unavailable.
</p>
@endif

@if($status === 'up')
<p>
    The site is back online.
</p>
@endif