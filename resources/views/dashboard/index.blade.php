@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.dashboard')</h1>

            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</li>
            </ol>
        </section>

        <section class="content">


            <div class="box box-solid">

                <div class="box-header">
                    <h3 class="box-title">This is Dashboard</h3>
                </div>
                <div class="box-body border-radius-none">
                    <div class="chart" id="line-chart" style="height: 250px;"></div>
                </div>
                <!-- /.box-body -->
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection

@push('scripts')

    {{--    <script>--}}

    {{--        //line chart--}}
    {{--        var line = new Morris.Line({--}}
    {{--            element: 'line-chart',--}}
    {{--            resize: true,--}}
    {{--            data: [--}}
    {{--                @foreach ($sales_data as $data)--}}
    {{--                {--}}
    {{--                    ym: "{{ $data->year }}-{{ $data->month }}", sum: "{{ $data->sum }}"--}}
    {{--                },--}}
    {{--                @endforeach--}}
    {{--            ],--}}
    {{--            xkey: 'ym',--}}
    {{--            ykeys: ['sum'],--}}
    {{--            labels: ['@lang('site.total')'],--}}
    {{--            lineWidth: 2,--}}
    {{--            hideHover: 'auto',--}}
    {{--            gridStrokeWidth: 0.4,--}}
    {{--            pointSize: 4,--}}
    {{--            gridTextFamily: 'Open Sans',--}}
    {{--            gridTextSize: 10--}}
    {{--        });--}}
    {{--    </script>--}}

@endpush
