@extends("layouts.app")
@section("title","Dashboard")
@section("content")
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
        {{-- <span class="info-box-icon text-bg-primary shadow-sm">
        <i class="bi bi-gear-fill"></i>
        </span>
        <div class="info-box-content">
            <span class="info-box-text">Total Users</span>
            <span class="info-box-number">{{ $totalUsers }}</span>
        </div> --}}
        <span class="info-box-icon text-bg-warning shadow-sm">
            <i class="bi bi-people-fill"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Users</span>
                <span class="info-box-number">{{ $totalUsers }}</span>
            </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
        <span class="info-box-icon text-bg-danger shadow-sm">
        <i class="bi bi-hand-thumbs-up-fill"></i>
        </span>
        <div class="info-box-content">
            <span class="info-box-text">Total Posts</span>
            <span class="info-box-number">{{ $totalPosts }}</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <!-- fix for small devices only -->
    <!-- <div class="clearfix hidden-md-up"></div> -->
    <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
        <span class="info-box-icon text-bg-success shadow-sm">
        <i class="bi bi-cart-fill"></i>
        </span>
        <div class="info-box-content">
            <span class="info-box-text">Published</span>
            <span class="info-box-number">{{ $publishedPosts }}</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
        {{-- <span class="info-box-icon text-bg-warning shadow-sm">
        <i class="bi bi-people-fill"></i>
        </span>
        <div class="info-box-content">
            <span class="info-box-text">Draft</span>
            <span class="info-box-number">{{ $draftPosts }}</span>
        </div> --}}
        <span class="info-box-icon text-bg-primary shadow-sm">
            <i class="bi bi-gear-fill"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Draft</span>
                <span class="info-box-number">{{ $draftPosts }}</span>
            </div>
        <!-- /.info-box-content -->

    </div>
    {{-- Online Users --}}


    <div class="info-box" align-item="center">

        <span class="info-box-icon text-bg-primary shadow-sm">
            <i class="bi bi-people-fill"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Online Users</span>
                <span class="info-box-number">{{ $activeUsers }}</span>
            </div>
        <!-- /.info-box-content -->
    </div>

    <!-- /.info-box -->
    {{-- <span class="info-box-icon text-bg-warning shadow-sm">
        <i class="bi bi-people-fill"></i>
        </span>
        <div class="info-box-content">
            <span class="info-box-text">Online Users</span>
            <span class="info-box-number">{{ $activeUsers }}</span>
        </div>
    </div> --}}

    <!-- /.info-box -->
    </div>
    {{-- chart --}}
    <div class="card mt-4">
        <div class="card-header">
            <h5>Website Statistics</h5>
        </div>
        <div class="card-body">
            <canvas id="statsChart"></canvas>
        </div>
    </div>
    <!-- /.col -->

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('statsChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                'Jan','Feb','Mar','Apr','May','Jun',
                'Jul','Aug','Sep','Oct','Nov','Dec'
            ],
            datasets: [
                {
                    label: 'Users',
                    data: @json($usersChart),
                    borderWidth: 2,
                    tension: 0.4
                },
                {
                    label: 'Posts',
                    data: @json($postsChart),
                    borderWidth: 2,
                    tension: 0.4
                }
            ]
        }
    });
    </script>
@endsection
