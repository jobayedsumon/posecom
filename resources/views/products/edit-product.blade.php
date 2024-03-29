@extends('layouts.app', ['activePage' => 'edit-product', 'titlePage' => __('Edit Product')])

@canany(['access-all-data', 'access-admin-data', 'access-manager-data'])
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('products.update', $product->id) }}" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="card ">
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">{{ __('Edit Product') }}</h4>
                                <p class="card-category">{{ __('Product information') }}</p>
                            </div>
                            <div class="card-body ">
                                @if (session('status'))
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="alert alert-success">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <i class="material-icons">close</i>
                                                </button>
                                                <span>{{ session('status') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Product Name') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text"
                                                   placeholder="{{ __('Product Name') }}" value="{{ $product->name }}" required="true" aria-required="true"/>
                                            @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Category') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                                <div class="inline-block relative w-64">
                                                    <select name="category_id" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                                        @forelse($categories as $category)
                                                            <option {{ $category->id == $product->category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                                            <hr>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>

                                                @if ($errors->has('category_id'))
                                                    <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('category_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Sub Category') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
                                                <div class="inline-block relative w-64">
                                                    <select name="sub_category_id" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                                        @forelse($sub_categories as $sub_category)
                                                            <option {{ $sub_category->id == $product->sub_category->id ? 'selected' : '' }}  value="{{ $sub_category->id }}">{{ $sub_category->name }}</option>
                                                            <hr>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>

                                                @if ($errors->has('sub_category_id'))
                                                    <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('sub_category_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Brand') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
                                                <div class="inline-block relative w-64">
                                                    <select name="brand_id"
                                                            class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                                        @forelse($brands as $brand)
                                                            <option {{ $brand->id == $product->brand->id ? 'selected' : '' }} value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                            <hr>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>

                                                @if ($errors->has('sub_category_id'))
                                                    <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('sub_category_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Color') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
                                                <div class="inline-block relative w-64 flex items-center" id="colorDiv">
                                                    @forelse($product->colors as $color)
                                                    <input class="{ $errors->has('color') ? ' is-invalid' : '' }}" name="color[]" type="color"
                                                           value="{{ $color->name }}" required="true" aria-required="true"/>
                                                    @empty
                                                    @endforelse

                                                </div>

                                                <a id="colorPlus"><span class="fa fa-plus"></span></a>&nbsp;
                                                &nbsp;<a id="colorMinus"><span class="fa fa-minus"></span></a>

                                                @if ($errors->has('sub_category_id'))
                                                    <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('sub_category_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Size') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
                                                <div class="inline-block relative w-64">
                                                    <input class="form-control{{ $errors->has('size') ? ' is-invalid' : '' }}" name="size" id="input-name" type="text"
                                                           placeholder="{{ __('Product Size') }}" value="@forelse($product->sizes as $size){{ $size->name }}{!! !$loop->last ? ', ' : '' !!}@empty @endforelse" required="true" aria-required="true"/>

                                                </div>

                                                @if ($errors->has('sub_category_id'))
                                                    <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('sub_category_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Price') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price"
                                                   id="input-price" type="number" placeholder="{{ __('Price') }}" value="{{ $product->price }}" required />
                                            @if ($errors->has('price'))
                                                <span id="price-error" class="error text-danger" for="input-price">{{ $errors->first('price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                    <br>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Quantity') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity"
                                                       id="input-quantity" type="number" placeholder="{{ __('Product Quantity') }}" value="{{ $product->quantity }}" required />
                                                @if ($errors->has('quantity'))
                                                    <span id="quantity-error" class="error text-danger" for="input-quantity">{{ $errors->first('quantity') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Discount') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('discount') ? ' is-invalid' : '' }}" name="discount"
                                                       id="input-discount" type="number" placeholder="{{ __('Discount') }}" value="{{ $product->discount }}" required />
                                                @if ($errors->has('discount'))
                                                    <span id="discount-error" class="error text-danger" for="input-discount_price">{{ $errors->first('discount') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Image') }}</label>
                                        <div class="col-sm-4">
                                            <p>Primary</p>
                                            <div class="{{ $errors->has('image_primary') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('image_primary') ? ' is-invalid' : '' }}" name="image_primary" id="input-image_primary" type="file"  />
                                                @if ($errors->has('image_primary'))
                                                    <span id="image_primary-error" class="error text-danger" for="input-image_primary">{{ $errors->first('image_primary') }}</span>
                                                @endif
                                                <img src="{{ asset($product->image_primary) }}" alt="" width="100px">
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <p>Secondary</p>
                                            <div class="{{ $errors->has('image_secondary') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('image_secondary') ? ' is-invalid' : '' }}" name="image_secondary" id="input-image_secondary" type="file"  />
                                                @if ($errors->has('image_secondary'))
                                                    <span id="image_secondary-error" class="error text-danger" for="input-image_secondary">{{ $errors->first('image_secondary') }}</span>
                                                @endif
                                                <img src="{{ asset($product->image_secondary) }}" alt="" width="100px">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-4">
                                            <p>Left</p>
                                            <div class="{{ $errors->has('image_primary') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('image_primary') ? ' is-invalid' : '' }}" name="image_left" id="input-image_primary" type="file"  />
                                                @if ($errors->has('image_primary'))
                                                    <span id="image_primary-error" class="error text-danger" for="input-image_primary">{{ $errors->first('image_primary') }}</span>
                                                @endif
                                                <img src="{{ asset($product->image_left) }}" alt="" width="100px">
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <p>Right</p>
                                            <div class="{{ $errors->has('image_secondary') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('image_secondary') ? ' is-invalid' : '' }}" name="image_right" id="input-image_secondary" type="file"  />
                                                @if ($errors->has('image_secondary'))
                                                    <span id="image_secondary-error" class="error text-danger" for="input-image_secondary">{{ $errors->first('image_secondary') }}</span>
                                                @endif
                                                <img src="{{ asset($product->image_right) }}" alt="" width="100px">

                                            </div>
                                        </div>

                                    </div>


                                    <br>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Compositions') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="compositions" id="input-name" type="text"
                                                       placeholder="{{ __('Compositions') }}" value="{{ $product->specifications ? $product->specifications->compositions : '' }}" />
                                                @if ($errors->has('name'))
                                                    <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Styles') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="styles" id="input-name" type="text"
                                                       placeholder="{{ __('Styles') }}" value="{{ $product->specifications ? $product->specifications->styles : '' }}" />
                                                @if ($errors->has('name'))
                                                    <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Properties') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="properties" id="input-name" type="text"
                                                       placeholder="{{ __('Properties') }}" value="{{ $product->specifications ? $product->specifications->properties : '' }}" />
                                                @if ($errors->has('name'))
                                                    <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label" for="input-password">{{ __('Short Description') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('short_description') ? ' has-danger' : '' }}">
                                                <textarea class="w-100" name="short_description" id="" cols="" rows="10">{{ $product->short_description }}</textarea>
                                                @if ($errors->has('short_description'))
                                                    <span id="short_description-error" class="error text-danger" for="input-short_description">{{ $errors->first('short_description') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label" for="input-password">{{ __('Full Description') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                                <textarea class="w-100" name="description" id="" cols="" rows="10">{{ $product->description }}</textarea>
                                                @if ($errors->has('description'))
                                                    <span id="description-error" class="error text-danger" for="input-product_description">{{ $errors->first('description') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Product Tags') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('tags') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('tags') ? ' is-invalid' : '' }}" name="tags" id="input-tags" type="text"
                                                       placeholder="{{ __('Use , separator only') }}"
                                                       value="@forelse($product->tags as $tag){{ $tag->name }}{!! !$loop->last ? ', ' : '' !!}@empty @endforelse" required="true" aria-required="true"/>
                                                @if ($errors->has('tags'))
                                                    <span id="tags-error" class="error text-danger" for="input-tags">{{ $errors->first('tags') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-danger">{{ __('Update') }}</button>
                            </div>

                        </div>


                    </form>
                </div>


            </div>
        </div>

    </div>
    </div>
@endsection
@endcanany

@push('js')
    <script>
        $('#colorPlus').click(function () {

            let element = "<input class=\"{ $errors->has('color') ? ' is-invalid' : '' }}\" name=\"color[]\" id=\"input-name\" type=\"color\"\n" +
                "value=\"\" required=\"true\" aria-required=\"true\"/>";

            $('#colorDiv').append(element);
        });

        $('#colorMinus').click(function () {

            el = $('#colorDiv').children().last().remove();
            console.log(el);
        });
    </script>
@endpush
