@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">



            <h1>@lang('site.clients')</h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li><a href="{{route('clients.index')}}"><i class="fa fa-dashboard"></i>@lang('site.clients')</a></li>
                <li><i class="fa fa-dashboard"></i>@lang('site.add')</li>

            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="header">
                    <h3 class="box-title">@lang('site.add')</h3>
                </div><!-- ens of box header -->
                <div class="box-body">
                    @include('partials._errors')

                    <form action="{{route('clients.store')}}" method="post">

                        {{csrf_field()}}
                        {{method_field('post')}}

                        <div class="form-group">
                            <label>@lang('site.name')</label>
                            <input type="text" name="name" class="form-control" value="{{old('name')}}">
                        </div>
                        @for($i =0 ; $i < 2; $i++ )
                        <div class="form-group">
                            <label>@lang('site.phone')</label>
                            <input type="number" name="phone[]" class="form-control">
                        </div>
                        @endfor

                        <div class="form-group">
                            <label>@lang('site.address')</label>
                            <input type="text" name="address" class="form-control" value="{{old('address')}}">
                        </div>


                        <div class="form-group">
                          <button type="submit" class="btn btn-primary"><i class="fa fa-plus"> @lang('site.add')</i></button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div>

        </section>
    </div>
@endsection
