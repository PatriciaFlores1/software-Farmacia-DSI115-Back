<h2>Productos por expirar pronto</h2>
<ul>
@foreach($products as $product)
    <li>{{ $product->title }} - {{ $product->description }} — expira en {{ $product->expiration_days }} dias</li>
@endforeach
</ul>
