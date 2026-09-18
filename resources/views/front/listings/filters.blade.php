<?php  use App\Product; ?>
<div class="col-lg-3 col-md-12 col-12">
    <aside class="listing-filter desktop-filter">

        <div class="filter-head d-flex justify-content-between align-items-center">
            <h4>Filters</h4>
            <button class="filter-clear-btn" type="button">Clear All</button>
        </div>

        <!-- Categories -->
        <div class="filter-group">

            <h5>Categories</h5>

            @foreach($categories as $category)
                @if($category['seo_unique'] == 'winter-collection')
                    @if(!empty($category['subcategories']))
                        @foreach($category['subcategories'] as $subcategory)
                            <label class="filter-check">
                                <input type="checkbox" name="category[]" onclick="window.location.href='{{ $subcategory['seo_unique'] }}'" value="{{ $subcategory['seo_unique'] }}">
                                <span>{{ $subcategory['name'] }}</span>
                            </label>
                        @endforeach
                    @endif
                @endif
            @endforeach

        </div>

        <!-- Price -->
        <div class="filter-group">

            <h5>Price</h5>

            @foreach($priceRanges as $value => $label)
                <label class="filter-check">
                    <input type="checkbox" class="filterAjax" name="price" value="{{ $value }}" @if(isset($search['price']) && in_array($value, $search['price'])) checked @endif>
                    <span>{{ $label }}</span>
                </label>
            @endforeach

        </div>

        @if(count($colors) > 0)
        <!-- Color -->
        <div class="filter-group">

            <h5>Color</h5>

            @foreach($colors as $ckey => $color)
                @if($color->productcolor != '')
                    <?php $get_color_code = Product::product_code($color->productcolor); ?>
                    <label class="filter-check color-filter">
                        <input type="checkbox" class="filterAjax" name="color" id="color-{{ $ckey }}" value="{{ $color->productcolor }}" @if(isset($search['color']) && in_array($color->productcolor, $search['color'])) checked @endif>
                        <i class="color-dot" style="background-color: {{ $get_color_code }}"></i>
                        <span>{{ $color->productcolor }}</span>
                    </label>
                @endif
            @endforeach

        </div>
        @endif

        @if(count($sizes) > 0)
        <!-- Size -->
        <div class="filter-group">

            <h5>Size</h5>

            <div class="size-filter-list">
                @foreach($sizes as $sizekey => $size)
                    <label>
                        <input type="checkbox" name="size" class="filterAjax" value="{{ $size->size }}" @if(isset($search['size']) && in_array($size->size, $search['size'])) checked @endif>
                        <span>{{ $size->size }}</span>
                    </label>
                @endforeach
            </div>

        </div>
        @endif

    </aside>
</div>