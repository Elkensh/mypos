@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.products')</h1>

            <ol class="breadcrumb">

            <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
            <li><i class="fa fa-dashboard"></i>@lang('site.products')</li>
            </ol>
        </section>

        <section class="content">
                    <!-- /.card-header -->
            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">  @lang('site.dashboard')</h3><small></small>

                    <form action="{{route('products.index')}}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" style="height: 40px" placeholder="@lang('site.search') " value="{{request()->search}}">
                            </div>

                            <div class="col-md-4">
                                <select name="category_id" class="form-control" style="height: 40px">
                                    <option value="">@lang('site.all_categories')</option>

                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{request()->category_id == $category->id ? 'selected' : ''}} >{{$category->name}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-4">

                                <button class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>

                                @if(auth()->user()->hasPermission('products_create'))
                                    <a href="{{route('products.create')}}" class="btn btn-primary">@lang('site.add')</a>
                                @else
                                    <a href="#" class="btn btn-primary disabled">@lang('site.add')</a>
                                @endif


                            </div>
                        </div>
                    </form>
                </div>

                    <div class="box-body">

                        @if($products->count() > 0)
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('site.name')</th>
                                    <th>@lang('site.description')</th>
                                    <th>@lang('site.image')</th>
                                    <th>@lang('site.categories')</th>
                                    <th>@lang('site.purchase_price')</th>
                                    <th>@lang('site.sale_price')</th>
                                    <th>@lang('site.stock')</th>
                                    <th>@lang('site.profit_percent') %</th>
                                    <th>@lang('site.action')</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($products as $index => $product)
                                    <tr>
                                        <td>{{$index +1}}</td>
                                        <td>{{$product->name}}</td>
                                        <td>{!! $product->description !!}</td>
                                        <td><img src="{{$product->image_path}}" style="width: 100px" class="img-thumbnail" alt="image"></td>
                                        <td>{{$product->category->name}}</td>
                                        <td>{{$product->purchase_price}}</td>
                                        <td>{{$product->sale_price}}</td>
                                        <td>{{$product->stock}}</td>
                                        <td>{{$product->profit_percent}} %</td>
                                        <td>
                                            @if(auth()->user()->hasPermission('products_update'))
                                                <a href="{{route('products.edit',$product->id)}}"class="btn btn-info btn-sm">@lang('site.edit')</a>
                                            @else
                                                <a href="#"class="btn btn-info btn-sm">@lang('site.edit')</a>
                                            @endif



                                            @if(auth()->user()->hasPermission('products_delete'))
                                                    <form action="{{route('products.destroy',$product->id)}}" method="post" style="display: inline-block">

                                                        {{csrf_field()}}

                                                        {{method_field('delete')}}

                                                        <button type="submit"class="btn btn-danger delete btn-sm">@lang('site.delete')</button>

                                                    </form>
                                                @else
                                                    <button type="submit"class="btn btn-danger delete btn-sm disabled">@lang('site.delete')</button>
                                                @endif

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>

                            {{$products->appends(request()->query())->links()}}
                        @else

                            <h2>@lang('site.no_data_found')</h2>
                        @endif
                    </div>
                    <!-- /.card-body -->
<!--                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul>
                    </div>-->

                <!-- /.card -->
            </div>


        </section>
    </div>
@endsection
