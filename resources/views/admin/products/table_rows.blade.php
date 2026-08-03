@foreach ($productAttributes as $product)
    <tr>
        <td>{{ $product->id }}</td>
        <td>{{ $product->sku }}</td>
        
        <td>{{ $product->size }}</td>
        <td>{{ $product->color }}</td>
        <td>
            <form action="{{ url('product-attributes.update-stock', $product->id) }}" method="POST" class="update-stock-form">
                @csrf
                @method('PUT')
                <input type="number" name="stock" value="{{ $product->stock }}" class="form-control" required>
                <button type="submit" class="btn btn-success mt-2">Update Stock</button>
            </form>
        </td>
       
    </tr>
@endforeach
