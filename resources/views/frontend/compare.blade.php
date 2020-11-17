@extends('frontend.layout.master')

@section('header')

    @include('frontend.layout.header')

@endsection

@section('content')


    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-10">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li>Compare</li>
                        </ul>
                    </div>
                </div>
                <div class="col-2">
                    <a class="text-danger" href="/compare/remove">Clear <i class="fa fa-remove"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    @php
      $compare = \session()->get('compare') ?? [];
    @endphp

    <div class="container">
        <div class="row">
            @forelse($compare as $data)

                @php $product = \App\Product::findOrFail($data); @endphp

            <div class="col-4">
                <table class="table table-striped table-hover">
                    <img src="{{ asset($product->image_primary) }}" class="m-auto" alt="" width="200px">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">{{ $product->name }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Price</td>
                        <td>{{ $product->price }}</td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td>{{ $product->discount }}%</td>
                    </tr>
                    <tr>
                        <td>Color</td>
                        <td>
                            @forelse($product->colors as $color)
                                <span style="background-color: {{ $color ? $color->name : '' }}" class="p-3"> &nbsp;</span>
                            @empty
                            @endforelse
                        </td>
                    </tr>
                    <tr>
                        <td>Size</td>
                        <td>
                        @forelse($product->sizes as $size)
                            {{ $size->name }} <br>
                        @empty
                        @endforelse
                            </td>

                    </tr>
                    <tr>
                        <td>Brand</td>
                        <td>{{ $product->brand->name }}</td>
                    </tr>

                    <tr>
                        <th>Specification</th>
                    </tr>
                    <tr>
                        <td>Compositions</td>
                        <td>{{ $product->specification ? $product->specification->compostions : '' }}</td>
                    </tr>
                    <tr>
                        <td>Styles</td>
                        <td>{{ $product->specification ? $product->specification->styles : '' }}</td>
                    </tr>
                    <tr>
                        <td>Properties</td>
                        <td>{{ $product->specification ? $product->specification->properties : '' }}</td>
                    </tr>

                    </tbody>
                </table>
            </div>

            @empty
            @endforelse

        </div>
    </div>



   <!--brand area start-->
   @include('frontend.layout.brand')
    <!--brand area end-->

@endsection

@section('modal')
    @include('frontend.layout.modal')
@endsection


@section('footer')

    @include('frontend.layout.footer')

@endsection


