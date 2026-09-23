@foreach($getsearchproducts as $product)
    <a href="{{ url('product/'.$product->seo_url) }}" class="search-prod-card" data-category="{{ $product->category->name ?? '' }}">
        <div class="search-prod-img-wrap">
            <img src="{{ asset('images/ProductImages/xlarge/'.($product->productimages->first()->image ?? '')) }}" alt="{{ $product->product_name }}" loading="lazy">
        </div>
        <div class="search-prod-info">
            <span class="search-prod-cat">{{ $product->category->name ?? '' }}</span>
            <h6 class="search-prod-title">{{ $product->product_name }}</h6>
            <div class="search-prod-price-wrap">
                {!! productPriceHtml($product) !!}
            </div>
        </div>
    </a>
@endforeach