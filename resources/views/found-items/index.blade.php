<!-- resources/views/found-items/index.blade.php -->

<h1>Found Items</h1>


@if($foundItems)
<ul>
    @foreach($foundItems as $foundItem)
        <li>{{ $foundItem->name }}</li>
    @endforeach
</ul>@else
    <p>No items found.</p>
@endif
