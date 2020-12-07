<div class="brand_area brand_padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="brand_container owl-carousel owl-theme">
                    @forelse(\App\Brand::all() as $brand)
                        <div class="single_brand">
                            <a href="{{ route('brand-search', $brand->title) }}"><img class="h-full" src="{{ brandImage($brand->image) }}" class="img-fluid" alt=""></a>
                        </div>
                    @empty
                    @endforelse


                </div>
            </div>
        </div>
    </div>
</div>
