@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Dashboard</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Overview</li>
            </ul>
        </div>

        <div class="row gy-4">
            <div class="col-xxl-8">
                <div class="row gy-4">

                    @if (session('status'))
                        <div class="alert mx-4 alert-info my-4 bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                            role="alert">
                            <div class="d-flex align-items-center gap-2">
                                <iconify-icon icon="mingcute:emoji-line" class="icon text-xl"></iconify-icon>
                                {{ session('status') }}
                            </div>
                            <button class="remove-button text-success-600 text-xxl line-height-1"> <iconify-icon
                                    icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button>
                        </div>
                    @endif

                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-1">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">

                                    <div class="d-flex align-items-center gap-2">
                                        <span
                                            class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">New Users</span>
                                            <h6 class="fw-semibold">15,000</h6>
                                        </div>
                                    </div>

                                    <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                                </div>
                                <p class="text-sm mb-0">Increase by <span
                                        class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+200</span>
                                    this week</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">

                                    <div class="d-flex align-items-center gap-2">
                                        <span
                                            class="mb-0 w-48-px h-48-px bg-success-main flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Active
                                                Users</span>
                                            <h6 class="fw-semibold">8,000</h6>
                                        </div>
                                    </div>

                                    <div id="active-user-chart" class="remove-tooltip-title rounded-tooltip-value">
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Increase by <span
                                        class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+200</span>
                                    this week</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">

                                    <div class="d-flex align-items-center gap-2">
                                        <span
                                            class="mb-0 w-48-px h-48-px bg-yellow text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="iconamoon:discount-fill" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Total
                                                Sales</span>
                                            <h6 class="fw-semibold">$5,00,000</h6>
                                        </div>
                                    </div>

                                    <div id="total-sales-chart" class="remove-tooltip-title rounded-tooltip-value">
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Increase by <span
                                        class="bg-danger-focus px-1 rounded-2 fw-medium text-danger-main text-sm">-$10k</span>
                                    this week</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-4">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">

                                    <div class="d-flex align-items-center gap-2">
                                        <span
                                            class="mb-0 w-48-px h-48-px bg-purple text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mdi:message-text" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Conversion</span>
                                            <h6 class="fw-semibold">25%</h6>
                                        </div>
                                    </div>

                                    <div id="conversion-user-chart" class="remove-tooltip-title rounded-tooltip-value">
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Increase by <span
                                        class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+5%</span>
                                    this week</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-5">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">

                                    <div class="d-flex align-items-center gap-2">
                                        <span
                                            class="mb-0 w-48-px h-48-px bg-pink text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mdi:leads" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Leads</span>
                                            <h6 class="fw-semibold">250</h6>
                                        </div>
                                    </div>

                                    <div id="leads-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                                </div>
                                <p class="text-sm mb-0">Increase by <span
                                        class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+20</span>
                                    this week</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-6">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">

                                    <div class="d-flex align-items-center gap-2">
                                        <span
                                            class="mb-0 w-48-px h-48-px bg-cyan text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="streamline:bag-dollar-solid" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Total
                                                Profit</span>
                                            <h6 class="fw-semibold">$3,00,700</h6>
                                        </div>
                                    </div>

                                    <div id="total-profit-chart" class="remove-tooltip-title rounded-tooltip-value">
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Increase by <span
                                        class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+$15k</span>
                                    this week</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Revenue Growth start -->
            <div class="col-xxl-4">
                <div class="card h-100 radius-8 border">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <div>
                                <h6 class="mb-2 fw-bold text-lg">Revenue Growth</h6>
                                <span class="text-sm fw-medium text-secondary-light">Weekly Report</span>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-2 fw-bold text-lg">$50,000.00</h6>
                                <span
                                    class="bg-success-focus ps-12 pe-12 pt-2 pb-2 rounded-2 fw-medium text-success-main text-sm">$10k</span>
                            </div>
                        </div>
                        <div id="revenue-chart" class="mt-28"></div>
                    </div>
                </div>
            </div>
            <!-- Revenue Growth End -->

            <!-- Earning Static start -->
            <div class="col-xxl-8">
                <div class="card h-100 radius-8 border-0">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <div>
                                <h6 class="mb-2 fw-bold text-lg">Earning Statistic</h6>
                                <span class="text-sm fw-medium text-secondary-light">Yearly earning overview</span>
                            </div>
                            <div class="">
                                <select class="form-select form-select-sm w-auto bg-base border text-secondary-light">
                                    <option>Yearly</option>
                                    <option>Monthly</option>
                                    <option>Weekly</option>
                                    <option>Today</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-20 d-flex justify-content-center flex-wrap gap-3">

                            <div
                                class="d-inline-flex align-items-center gap-2 p-2 radius-8 border pe-36 br-hover-primary group-item">
                                <span
                                    class="bg-neutral-100 w-44-px h-44-px text-xxl radius-8 d-flex justify-content-center align-items-center text-secondary-light group-hover:bg-primary-600 group-hover:text-white">
                                    <iconify-icon icon="fluent:cart-16-filled" class="icon"></iconify-icon>
                                </span>
                                <div>
                                    <span class="text-secondary-light text-sm fw-medium">Sales</span>
                                    <h6 class="text-md fw-semibold mb-0">$200k</h6>
                                </div>
                            </div>

                            <div
                                class="d-inline-flex align-items-center gap-2 p-2 radius-8 border pe-36 br-hover-primary group-item">
                                <span
                                    class="bg-neutral-100 w-44-px h-44-px text-xxl radius-8 d-flex justify-content-center align-items-center text-secondary-light group-hover:bg-primary-600 group-hover:text-white">
                                    <iconify-icon icon="uis:chart" class="icon"></iconify-icon>
                                </span>
                                <div>
                                    <span class="text-secondary-light text-sm fw-medium">Income</span>
                                    <h6 class="text-md fw-semibold mb-0">$200k</h6>
                                </div>
                            </div>

                            <div
                                class="d-inline-flex align-items-center gap-2 p-2 radius-8 border pe-36 br-hover-primary group-item">
                                <span
                                    class="bg-neutral-100 w-44-px h-44-px text-xxl radius-8 d-flex justify-content-center align-items-center text-secondary-light group-hover:bg-primary-600 group-hover:text-white">
                                    <iconify-icon icon="ph:arrow-fat-up-fill" class="icon"></iconify-icon>
                                </span>
                                <div>
                                    <span class="text-secondary-light text-sm fw-medium">Profit</span>
                                    <h6 class="text-md fw-semibold mb-0">$200k</h6>
                                </div>
                            </div>
                        </div>

                        <div id="barChart"></div>
                    </div>
                </div>
            </div>
            <!-- Earning Static End -->

            <!-- Campaign Static start -->
            <div class="col-xxl-4">
                <div class="row gy-4">
                    <div class="col-xxl-12 col-sm-6">
                        <div class="card h-100 radius-8 border-0">
                            <div class="card-body p-24">
                                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                                    <h6 class="mb-2 fw-bold text-lg">Campaigns</h6>
                                    <div class="">
                                        <select
                                            class="form-select form-select-sm w-auto bg-base border text-secondary-light">
                                            <option>Yearly</option>
                                            <option>Monthly</option>
                                            <option>Weekly</option>
                                            <option>Today</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-3">

                                    <div class="d-flex align-items-center justify-content-between gap-3 mb-12">
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0 text-orange">
                                                <iconify-icon icon="majesticons:mail" class="icon"></iconify-icon>
                                            </span>
                                            <span class="text-primary-light fw-medium text-sm ps-12">Email</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 w-100">
                                            <div class="w-100 max-w-66 ms-auto">
                                                <div class="progress progress-sm rounded-pill" role="progressbar"
                                                    aria-label="Success example" aria-valuenow="25" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    <div class="progress-bar bg-orange rounded-pill" style="width: 80%;">
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="text-secondary-light font-xs fw-semibold">80%</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between gap-3 mb-12">
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0 text-success-main">
                                                <iconify-icon icon="eva:globe-2-fill" class="icon"></iconify-icon>
                                            </span>
                                            <span class="text-primary-light fw-medium text-sm ps-12">Website</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 w-100">
                                            <div class="w-100 max-w-66 ms-auto">
                                                <div class="progress progress-sm rounded-pill" role="progressbar"
                                                    aria-label="Success example" aria-valuenow="25" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    <div class="progress-bar bg-success-main rounded-pill"
                                                        style="width: 60%;"></div>
                                                </div>
                                            </div>
                                            <span class="text-secondary-light font-xs fw-semibold">60%</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between gap-3 mb-12">
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0 text-info-main">
                                                <iconify-icon icon="fa6-brands:square-facebook"
                                                    class="icon"></iconify-icon>
                                            </span>
                                            <span class="text-primary-light fw-medium text-sm ps-12">Facebook</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 w-100">
                                            <div class="w-100 max-w-66 ms-auto">
                                                <div class="progress progress-sm rounded-pill" role="progressbar"
                                                    aria-label="Success example" aria-valuenow="25" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    <div class="progress-bar bg-info-main rounded-pill"
                                                        style="width: 49%;"></div>
                                                </div>
                                            </div>
                                            <span class="text-secondary-light font-xs fw-semibold">49%</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between gap-3">
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0 text-indigo">
                                                <iconify-icon icon="fluent:location-off-20-filled"
                                                    class="icon"></iconify-icon>
                                            </span>
                                            <span class="text-primary-light fw-medium text-sm ps-12">Email</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 w-100">
                                            <div class="w-100 max-w-66 ms-auto">
                                                <div class="progress progress-sm rounded-pill" role="progressbar"
                                                    aria-label="Success example" aria-valuenow="25" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    <div class="progress-bar bg-indigo rounded-pill" style="width: 70%;">
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="text-secondary-light font-xs fw-semibold">70%</span>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-sm-6">
                        <div class="card h-100 radius-8 border-0 overflow-hidden">
                            <div class="card-body p-24">
                                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                                    <h6 class="mb-2 fw-bold text-lg">Customer Overview</h6>
                                    <div class="">
                                        <select
                                            class="form-select form-select-sm w-auto bg-base border text-secondary-light">
                                            <option>Yearly</option>
                                            <option>Monthly</option>
                                            <option>Weekly</option>
                                            <option>Today</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap align-items-center mt-3">
                                    <ul class="flex-shrink-0">
                                        <li class="d-flex align-items-center gap-2 mb-28">
                                            <span class="w-12-px h-12-px rounded-circle bg-success-main"></span>
                                            <span class="text-secondary-light text-sm fw-medium">Total: 500</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-2 mb-28">
                                            <span class="w-12-px h-12-px rounded-circle bg-warning-main"></span>
                                            <span class="text-secondary-light text-sm fw-medium">New: 500</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-2">
                                            <span class="w-12-px h-12-px rounded-circle bg-primary-600"></span>
                                            <span class="text-secondary-light text-sm fw-medium">Active: 1500</span>
                                        </li>
                                    </ul>
                                    <div id="donutChart"
                                        class="flex-grow-1 apexcharts-tooltip-z-none title-style circle-none"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Campaign Static End -->


            <div class="col-xxl-6">
                <div class="card h-100">
                    <div
                        class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center justify-content-between">
                        <h6 class="text-lg fw-semibold mb-0">Last Transaction</h6>
                        <a href="javascript:void(0)"
                            class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                            View All
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                        </a>
                    </div>
                    <div class="card-body p-24">
                        <div class="table-responsive scroll-sm">
                            <table class="table bordered-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Transaction ID</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>5986124445445</td>
                                        <td>27 Mar 2024</td>
                                        <td> <span
                                                class="bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm">Pending</span>
                                        </td>
                                        <td>$20,000.00</td>
                                    </tr>
                                    <tr>
                                        <td>5986124445445</td>
                                        <td>27 Mar 2024</td>
                                        <td> <span
                                                class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Rejected</span>
                                        </td>
                                        <td>$20,000.00</td>
                                    </tr>
                                    <tr>
                                        <td>5986124445445</td>
                                        <td>27 Mar 2024</td>
                                        <td> <span
                                                class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Completed</span>
                                        </td>
                                        <td>$20,000.00</td>
                                    </tr>
                                    <tr>
                                        <td>5986124445445</td>
                                        <td>27 Mar 2024</td>
                                        <td> <span
                                                class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Completed</span>
                                        </td>
                                        <td>$20,000.00</td>
                                    </tr>
                                    <tr>
                                        <td>5986124445445</td>
                                        <td>27 Mar 2024</td>
                                        <td> <span
                                                class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Completed</span>
                                        </td>
                                        <td>$20,000.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Latest Performance End -->
        </div>
    </div>


@endsection

@push('scripts')
    <script src="{{ asset('adminpage/assets/js/homeTwoChart.js') }}"></script>
    <script>
        $('.remove-button').on('click', function() {
            $(this).closest('.alert').addClass('d-none')
        });
    </script>
@endpush
