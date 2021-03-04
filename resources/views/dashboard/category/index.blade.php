@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.categories')</h1>

            <ol class="breadcrumb">

            <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
            <li><i class="fa fa-dashboard"></i>@lang('site.categories')</li>
            </ol>
        </section>

        <section class="content">
                    <!-- /.card-header -->
            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">  @lang('site.dashboard')</h3><small></small>

                    <form action="{{route('categories.index')}}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control"placeholder="@lang('site.search') " value="{{request()->search}}">
                            </div>

                            <div class="col-md-4">

                                <button class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>

                                {{--@if(auth()->category()->hasPermission('categories_create'))--}}
                                    <a href="{{route('categories.create')}}" class="btn btn-primary">@lang('site.add')</a>



                            </div>
                        </div>
                    </form>
                </div>

                    <div class="box-body">

                        @if($categories->count() > 0)
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('site.name')</th>
                                    <th>@lang('site.action')</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($categories as $index => $category)
                                    <tr>
                                        <td>{{$index +1}}</td>
                                        <td>{{$category->name}}</td>
                                        <td>
                                            {{--@if(auth()->category()->hasPermission('categories_update'))--}}
                                                <a href="{{route('categories.edit',$category->id)}}"class="btn btn-info btn-sm">@lang('site.edit')</a>
                                            {{--@else--}}



                                            {{--@if(auth()->category()->hasPermission('categories_delete'))--}}
                                                    <form action="{{route('categories.destroy',$category->id)}}" method="post" style="display: inline-block">

                                                        {{csrf_field()}}

                                                        {{method_field('delete')}}

                                                        <button type="submit"class="btn btn-danger delete btn-sm">@lang('site.delete')</button>

                                                    </form>
                                                {{--@else--}}

                                                {{--@endif--}}

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>

                            {{$categories->appends(request()->query())->links()}}
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
