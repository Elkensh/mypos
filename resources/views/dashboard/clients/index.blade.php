@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.clients')</h1>

            <ol class="breadcrumb">

            <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
            <li><i class="fa fa-dashboard"></i>@lang('site.clients')</li>
            </ol>
        </section>

        <section class="content">
                    <!-- /.card-header -->
            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">  @lang('site.dashboard')</h3><small></small>

                    <form action="{{route('clients.index')}}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control"placeholder="@lang('site.search') " value="{{request()->search}}">
                            </div>


                            <div class="col-md-4">

                                <button class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>

                                @if(auth()->user()->hasPermission('clients_create'))
                                    <a href="{{route('clients.create')}}" class="btn btn-primary">@lang('site.add')</a>
                                @else
                                    <a href="#" class="btn btn-primary disabled">@lang('site.add')</a>
                                @endif


                            </div>
                        </div>
                    </form>
                </div>

                    <div class="box-body">

                        @if($clients->count() > 0)
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('site.name')</th>
                                    <th>@lang('site.phone')</th>
                                    <th>@lang('site.address')</th>
                                    <th>@lang('site.add_order')</th>
                                    <th>@lang('site.action')</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($clients as $index => $client)
                                    <tr>
                                        <td>{{$index +1}}</td>
                                        <td>{{$client->name}}</td>
                                        <td>{{implode($client->phone,'-')}}</td> {{--@foreach($client->phone as $phone){{$phone}}-@endforeach--}}
                                        <td>{{$client->address}}</td>
                                        @if(auth()->user()->hasPermission('orders_create'))
                                        <td><a href="{{route('clients.orders.create',$client->id)}}" class="btn btn-primary btn-sm">@lang('site.add_order')</a></td>
                                        @else
                                            <td><a href="#" class="btn btn-primary btn-sm disabled">@lang('site.add_order')</a></td>
                                        @endif
                                            <td>
                                            @if(auth()->user()->hasPermission('clients_update'))
                                                <a href="{{route('clients.edit',$client->id)}}"class="btn btn-info btn-sm">@lang('site.edit')</a>
                                            @else
                                                <a href="#"class="btn btn-info btn-sm disabled">@lang('site.edit')</a>
                                            @endif



                                            @if(auth()->user()->hasPermission('clients_delete'))
                                                    <form action="{{route('clients.destroy',$client->id)}}" method="post" style="display: inline-block">

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

                            {{$clients->appends(request()->query())->links()}}
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
