@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">



            <h1>@lang('site.categories')</h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li><a href="{{route('categories.index')}}"><i class="fa fa-dashboard"></i>@lang('site.categories')</a></li>
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

                    <form action="{{route('categories.store')}}" method="post">

                        {{csrf_field()}}
                        {{method_field('post')}}

                        <div class="form-group">
                            <label>@lang('site.name')</label>
                            <input type="text" name="name" class="form-control" value="{{old('name')}}" required>
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
