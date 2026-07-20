@extends('admin.layout')

@section('title', ($pageTitle ?? 'Dashboard') . ' | Admin')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ $pageTitle ?? 'Dashboard' }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        @foreach ($breadcrumbs ?? [] as $breadcrumb)
                            @if (! empty($breadcrumb['url']))
                                <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a></li>
                            @else
                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['label'] }}</li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                @foreach ($stats ?? [] as $stat)
                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-{{ $stat['theme'] ?? 'primary' }}">
                            <div class="inner">
                                <h3>
                                    {{ $stat['value'] }}
                                    @isset($stat['suffix'])
                                        <sup class="fs-5">{{ $stat['suffix'] }}</sup>
                                    @endisset
                                </h3>
                                <p>{{ $stat['label'] }}</p>
                            </div>
                            <i class="small-box-icon bi {{ $stat['icon'] ?? 'bi-circle' }}"></i>
                            <a href="{{ $stat['link'] ?? '#' }}" class="small-box-footer link-{{ $stat['link_theme'] ?? 'light' }} link-underline-opacity-0 link-underline-opacity-50-hover">
                                More info <i class="bi bi-link-45deg"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-lg-7 connectedSortable">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Sales Value</h3>
                        </div>
                        <div class="card-body">
                            <div id="revenue-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 connectedSortable">
                    <div class="card text-white bg-primary bg-gradient border-primary mb-4">
                        <div class="card-header border-0">
                            <h3 class="card-title">Sales Value</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary btn-sm" data-lte-toggle="card-collapse">
                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="world-map" style="height: 220px"></div>
                        </div>
                        <div class="card-footer border-0">
                            <div id="sales-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.connectedSortable').forEach(function (element) {
                new Sortable(element, {
                    group: 'shared',
                    handle: '.card-header',
                });
            });

            new ApexCharts(document.querySelector('#revenue-chart'), {
                series: [
                    @foreach ($revenueChart['series'] ?? [] as $series)
                        @json($series),
                    @endforeach
                ],
                chart: { height: 300, type: 'area', toolbar: { show: false } },
                legend: { show: false },
                colors: @json($revenueChart['colors'] ?? ['#0d6efd', '#20c997']),
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth' },
                xaxis: {
                    type: 'datetime',
                    categories: @json($revenueChart['categories'] ?? []),
                },
                tooltip: {
                    x: {
                        format: 'MMMM yyyy',
                    },
                },
            }).render();

            if (document.querySelector('#world-map') && typeof jsVectorMap !== 'undefined') {
                new jsVectorMap({
                    selector: '#world-map',
                    map: 'world',
                    backgroundColor: 'transparent',
                    regionStyle: {
                        initial: {
                            fill: 'rgba(255, 255, 255, 0.75)',
                            stroke: 'rgba(255, 255, 255, 0.35)',
                        },
                    },
                });
            }

            new ApexCharts(document.querySelector('#sales-chart'), {
                series: @json($salesSparkline['series'] ?? []),
                chart: { height: 50, type: 'area', sparkline: { enabled: true } },
                stroke: { curve: 'straight' },
                fill: { opacity: 0.3 },
                yaxis: { min: 0 },
                colors: ['#DCE6EC'],
                tooltip: { enabled: false },
            }).render();
        });
    </script>
@endpush
