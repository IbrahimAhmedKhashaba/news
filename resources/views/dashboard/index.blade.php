@extends('layouts.dashboard.app')
@section('title')
    Home
@endsection
@section('body')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    
</div>

<!-- Content Row -->
@livewire('admin.statistics')

<!-- Content Row -->

{{-- charts js --}}
<div class="row">

        <!-- Content Column -->
        <div class="col-lg-6 mb-4">

            <div class="card-body shadow">

                <h4>{{ $chart1->options['chart_title'] }}</h4>
                {!! $chart1->renderHtml() !!}

            </div>



        </div>

        <div class="col-lg-6 mb-4 ">
            <div class="card-body shadow">

                <h4>{{ $chart2->options['chart_title'] }}</h4>
                {!! $chart2->renderHtml() !!}

            </div>
    </div>



    {{-- <div class="col-lg-6 mb-4 shadow">
        
    </div>
    <div class="col-lg-6 mb-4 shadow">
        
    </div> --}}
</div>

<!-- Content Row -->
@can('posts')
@livewire('admin.latest_posts_comments')
@endcan
@endsection

@push('js')
{!! $chart1->renderChartJsLibrary() !!}
{!! $chart1->renderJs() !!}
{!! $chart2->renderChartJsLibrary() !!}
{!! $chart2->renderJs() !!}
@endpush