{{-- Pterodactyl Admin Dashboard - Redesign Style --}}
@extends('layouts.admin')

@section('title')
    Administration
@endsection

@section('content-header')
    <h1>Dashboard Utama<small>Statistik real-time infrastruktur panel Anda.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="active">Index</li>
    </ol>
@endsection

@section('content')
<style>
    /* Styling Custom untuk Meniru Tampilan Screenshot */
    .content-wrapper { background-color: #1a202c; color: #fff; } /* Dark Background fix */
    
    .dashboard-card {
        border-radius: 8px;
        color: #fff;
        padding: 15px 20px;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.3);
    }
    .dashboard-card h2 { margin: 0; font-size: 32px; font-weight: bold; }
    .dashboard-card p { margin: 0; font-size: 14px; opacity: 0.9; margin-top: 5px; }
    .dashboard-card .icon-bg {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 50px;
        opacity: 0.2;
    }

    /* Warna Gradient Sesuai Foto */
    .card-blue { background: linear-gradient(90deg, #00C6FF 0%, #0072FF 100%); }
    .card-green { background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%); }
    .card-orange { background: linear-gradient(90deg, #F2994A 0%, #F2C94C 100%); }
    .card-red { background: linear-gradient(90deg, #FF416C 0%, #FF4B2B 100%); }

    /* Kotak Gelap untuk Monitor */
    .dark-box {
        background: #2d3748;
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #4a5568;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .dark-box-header {
        border-bottom: 1px solid #4a5568;
        padding-bottom: 10px;
        margin-bottom: 15px;
        font-weight: bold;
        font-size: 16px;
        color: #e2e8f0;
    }
    
    .resource-grid {
        display: flex;
        justify-content: space-between;
        text-align: center;
    }
    .resource-item h4 { font-size: 12px; color: #a0aec0; text-transform: uppercase; margin-bottom: 5px; }
    .resource-item span { font-size: 18px; font-weight: bold; color: #fff; }

    /* Progress Bar Custom */
    .progress-custom {
        height: 10px;
        background-color: #1a202c;
        border-radius: 5px;
        overflow: hidden;
        margin-top: 10px;
    }
    .progress-bar-fill {
        background: #FF416C; /* Merah sesuai foto */
        height: 100%;
    }
</style>

{{-- PHP Helper untuk menghitung Disk Usage VPS Panel --}}
@php
    $diskTotal = disk_total_space('/');
    $diskFree = disk_free_space('/');
    $diskUsed = $diskTotal - $diskFree;
    $diskPercentage = round(($diskUsed / $diskTotal) * 100);
    $diskTotalGB = round($diskTotal / 1073741824, 2);
    $diskUsedGB = round($diskUsed / 1073741824, 2);
    
    // Mengambil data Count dari Database Pterodactyl
    $usersCount = \Pterodactyl\Models\User::count();
    $serversCount = \Pterodactyl\Models\Server::count();
    $nodesCount = \Pterodactyl\Models\Node::count();
@endphp

<div class="row">
    {{-- Card 1: Total Pengguna (Biru) --}}
    <div class="col-md-12 col-xs-12">
        <div class="dashboard-card card-blue">
            <h2>{{ $usersCount }}</h2>
            <p>Total Pengguna</p>
            <i class="fa fa-users icon-bg"></i>
        </div>
    </div>

    {{-- Card 2: Server Berjalan (Hijau) --}}
    <div class="col-md-12 col-xs-12">
        <div class="dashboard-card card-green">
            <h2>{{ $serversCount }}</h2>
            <p>Server Terinstall</p>
            <i class="fa fa-server icon-bg"></i>
        </div>
    </div>

    {{-- Card 3: Node Aktif (Orange) --}}
    <div class="col-md-12 col-xs-12">
        <div class="dashboard-card card-orange">
            <h2>{{ $nodesCount }}</h2>
            <p>Node Aktif</p>
            <i class="fa fa-sitemap icon-bg"></i>
        </div>
    </div>

    {{-- Card 4: VPS Info (Merah) --}}
    <div class="col-md-12 col-xs-12">
        <div class="dashboard-card card-red">
            <h2>VPS</h2>
            <p>PANEL MODIFICATION</p>
            <i class="fa fa-shield icon-bg"></i>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        {{-- Resource Monitor --}}
        <div class="dark-box">
            <div class="dark-box-header">
                Resource Monitor
            </div>
            <div class="resource-grid">
                <div class="resource-item">
                    <h4>CPU Cores</h4>
                    <span>{{ shell_exec('nproc') }} Core</span>
                </div>
                <div class="resource-item">
                    <h4>PHP Version</h4>
                    <span>{{ phpversion() }}</span>
                </div>
                <div class="resource-item">
                    <h4>RAM Usage (Est)</h4>
                    {{-- Note: Mengambil RAM akurat butuh akses shell/exec yang mungkin diblokir, ini estimasi --}}
                    <span>{{ round(memory_get_usage(true) / 1024 / 1024) }} MB</span>
                </div>
                <div class="resource-item">
                    <h4>Uptime</h4>
                    <span>{{ trim(shell_exec("uptime -p")) }}</span>
                </div>
            </div>
        </div>

        {{-- Penyimpanan --}}
        <div class="dark-box">
            <div class="dark-box-header">
                Penyimpanan (Disk Usage)
            </div>
            <div style="display:flex; justify-content:space-between; color:#ccc; font-size:12px;">
                <span>Used: {{ $diskUsedGB }} GB</span>
                <span>Total: {{ $diskTotalGB }} GB</span>
            </div>
            <div class="progress-custom">
                <div class="progress-bar-fill" style="width: {{ $diskPercentage }}%"></div>
            </div>
            <div style="text-align:right; margin-top:5px; font-size:12px; color:#fff;">
                {{ $diskPercentage }}%
            </div>
            <div style="margin-top:10px; font-size:10px; color:#666;">
                Versi Panel: {{ config('app.version') }}
            </div>
        </div>
    </div>
</div>
@endsection

