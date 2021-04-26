@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">



            <h1>@lang('site.clients')</h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li><a href="{{route('clients.index')}}"><i class="fa fa-dashboard"></i>@lang('site.clients')</a></li>
                <li><i class="fa fa-dashboard"></i>@lang('site.edit')</li>

            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="header">
                    <h3 class="box-title">@lang('site.edit')</h3>
                </div><!-- ens of box header -->
                <div class="box-body">
                    @include('partials._errors')
                    <h1>body</h1>

                </div><!-- end of box body -->

            </div>

        </section>
    </div>
@endsection
