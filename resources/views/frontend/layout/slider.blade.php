<section class="slider_section">
    <div class="slider_area owl-carousel stop owl-theme">

        @forelse($sliders as $slider)

            <div class="single_slider d-flex align-items-center w-full" style="background-image: url('{{ sliderImage($slider->image)}}')">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="slider_content">
                                <h1 class="text-white">{{ $slider->title }}</h1>
                                <p class="text-white">
                                    {{ $slider->exert }}
                                </p>
{{--                                <a href="{{ route('shop') }}">+ Shop Now </a>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
        @endforelse




    </div>
</section>
