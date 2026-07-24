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
                                <li class="breadcrumb-item"><a href="{{ \Illuminate\Support\Str::startsWith($breadcrumb['url'], '/') ? url($breadcrumb['url']) : $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a></li>
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
                            <a href="{{ ! empty($stat['link']) && \Illuminate\Support\Str::startsWith($stat['link'], '/') ? url($stat['link']) : ($stat['link'] ?? '#') }}" class="small-box-footer link-{{ $stat['link_theme'] ?? 'light' }} link-underline-opacity-0 link-underline-opacity-50-hover">
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
                            <h3 class="card-title">Visits Last 7 Days</h3>
                        </div>
                        <div class="card-body">
                            <div id="visit-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 connectedSortable">
                    <div class="card mb-4">
                        <div class="card-header border-0">
                            <h3 class="card-title">Content Summary</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover mb-0">
                                <tbody>
                                    @foreach ($contentCounts ?? [] as $item)
                                        <tr>
                                            <td><a href="{{ \Illuminate\Support\Str::startsWith($item['url'], '/') ? url($item['url']) : $item['url'] }}">{{ $item['label'] }}</a></td>
                                            <td class="text-end fw-semibold">{{ $item['value'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header"><h3 class="card-title">Top Visited Pages</h3></div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Page</th>
                                        <th class="text-end">Visits</th>
                                        <th class="text-end">Unique Users</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($topPages ?? [] as $page)
                                        <tr>
                                            <td class="text-break">{{ $page->path }}</td>
                                            <td class="text-end">{{ $page->total }}</td>
                                            <td class="text-end">{{ $page->unique_total }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center text-secondary py-4">No visits tracked yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Recent Visits</h3>
                            <div class="card-tools"><a href="{{ url('/admin/page-visits') }}" class="btn btn-primary btn-sm">View All</a></div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Page</th>
                                        <th>IP</th>
                                        <th>User</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentVisits ?? [] as $visit)
                                        <tr>
                                            <td class="text-break">{{ $visit->path }}</td>
                                            <td>{{ $visit->ip_address ?? '-' }}</td>
                                            <td>{{ $visit->user?->email ?? 'Guest' }}</td>
                                            <td>{{ $visit->visited_at?->format('Y-m-d H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center text-secondary py-4">No visits tracked yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.connectedSortable').forEach(function (element) {
                new Sortable(element, {
                    group: 'shared',
                    handle: '.card-header',
                });
            });

            new ApexCharts(document.querySelector('#visit-chart'), {
                series: @json($visitChart['series'] ?? []),
                chart: { height: 300, type: 'area', toolbar: { show: false } },
                legend: { show: false },
                colors: @json($visitChart['colors'] ?? ['#0d6efd']),
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth' },
                xaxis: {
                    type: 'datetime',
                    categories: @json($visitChart['categories'] ?? []),
                },
                tooltip: {
                    x: {
                        format: 'MMMM yyyy',
                    },
                },
            }).render();

        });
    </script>
@endpush
