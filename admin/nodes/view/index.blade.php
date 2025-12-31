@extends('layouts.admin')

@section('title')
    {{ $node->name }}
@endsection

{{-- HEADER BAWAAN DIHAPUS --}}
@section('content-header')
@endsection

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<style>
    /* === THEME VARIABLES === */
    :root {
        --bg-app: #f3f4f6; --bg-card: #ffffff; --text-main: #1f2937; --text-sub: #6b7280;
        --border-color: #e5e7eb; --input-bg: #f9fafb; --btn-bg: #ffffff; --btn-text: #1f2937;
        --btn-border: #d1d5db; --btn-hover: #f3f4f6; --badge-bg: #f3f4f6;
        --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --info: #3b82f6;
    }
    body.dark-mode {
        --bg-app: #121417; --bg-card: #1b1e24; --text-main: #e2e8f0; --text-sub: #94a3b8;
        --border-color: #2a2e36; --input-bg: #121417; --btn-bg: #1b1e24; --btn-text: #e2e8f0;
        --btn-border: #4a5568; --btn-hover: #2d3748; --badge-bg: #2a2e36;
    }

    /* GLOBAL FIXES */
    .content-wrapper, body, .wrapper { background-color: var(--bg-app) !important; color: var(--text-main) !important; transition: all 0.3s; }
    .content-header { display: none !important; }
    .content { padding-top: 20px !important; }

    /* CARD STYLE */
    .theme-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    /* UNIFIED HEADER (TITLE) */
    .card-header-unified {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex; justify-content: space-between; align-items: center;
    }
    .header-title h1 { font-size: 20px; font-weight: 800; margin: 0; color: var(--text-main); letter-spacing: -0.5px; }
    .header-title small { display: block; font-size: 13px; color: var(--text-sub); margin-top: 4px; font-weight: 500; }

    /* SUB-HEADER (UNTUK CARD KECIL) */
    .card-header-theme {
        padding: 15px 24px;
        border-bottom: 1px solid var(--border-color);
        font-weight: 700; font-size: 15px; display: flex; align-items: center; gap: 8px; color: var(--text-main);
    }
    .card-body-theme { padding: 24px; }
    .card-footer-theme {
        padding: 15px 24px; background: var(--input-bg); border-top: 1px solid var(--border-color);
        display: flex; justify-content: flex-end;
    }

    /* NAVIGATION PILLS (MODERN TABS) */
    .nav-pills-modern {
        display: flex; gap: 10px; padding: 0 24px 20px 24px; list-style: none; margin: 0;
        border-bottom: 1px solid var(--border-color); overflow-x: auto;
    }
    .nav-pills-modern li a {
        display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px;
        border-radius: 8px; background: var(--input-bg); color: var(--text-sub);
        border: 1px solid var(--border-color); font-weight: 600; font-size: 13px; text-decoration: none; transition: all 0.2s; white-space: nowrap;
    }
    .nav-pills-modern li a:hover { background: var(--btn-hover); color: var(--text-main); }
    .nav-pills-modern li.active a { background: #1f2937; color: #fff; border-color: #1f2937; }
    body.dark-mode .nav-pills-modern li.active a { background: #6366f1; border-color: #6366f1; }

    /* TABLE */
    .theme-table { width: 100%; border-collapse: collapse; }
    .theme-table td {
        padding: 12px 0; border-bottom: 1px solid var(--border-color);
        color: var(--text-main); vertical-align: middle; font-size: 14px;
    }
    .theme-table tr:last-child td { border-bottom: none; }
    .theme-table td:first-child { color: var(--text-sub); font-weight: 600; width: 40%; }

    /* STATS BOXES (KANAN) */
    .stat-item {
        background: var(--input-bg); border: 1px solid var(--border-color);
        border-radius: 12px; padding: 15px; margin-bottom: 15px;
    }
    .stat-header { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 13px; font-weight: 600; color: var(--text-sub); }
    .stat-value { font-size: 16px; font-weight: 700; color: var(--text-main); margin-bottom: 8px; display: block;}
    
    .progress-bar-container { width: 100%; height: 6px; background: var(--border-color); border-radius: 10px; overflow: hidden; }
    .progress-bar-fill { height: 100%; border-radius: 10px; transition: width 0.5s ease; }

    /* BUTTONS */
    .btn-danger-theme {
        background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;
        padding: 8px 16px; border-radius: 8px; font-weight: 600; transition: all 0.2s;
    }
    .btn-danger-theme:hover { background: #b91c1c; color: #fff; border-color: #b91c1c; }
    .btn-danger-theme:disabled { opacity: 0.6; cursor: not-allowed; }

    /* LOADING ANIMATION */
    .spin-anim { animation: spin 2s linear infinite; display: inline-block; }
    @keyframes spin { 100% { transform: rotate(360deg); } }

    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; font-family: 'Menlo', monospace; }
    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
    pre { background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 8px; padding: 10px; font-family: 'Menlo', monospace; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            {{-- UNIFIED HEADER --}}
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>{{ $node->name }}</h1>
                    <small>Quick overview of your node.</small>
                </div>
                <span class="material-symbols-rounded" style="color: #6366f1; font-size: 30px;">hub</span>
            </div>
            
            {{-- NAVIGATION TABS --}}
            <div style="margin-top: 20px;">
                <ul class="nav-pills-modern">
                    <li class="active"><a href="{{ route('admin.nodes.view', $node->id) }}"><span class="material-symbols-rounded">info</span> About</a></li>
                    <li><a href="{{ route('admin.nodes.view.settings', $node->id) }}"><span class="material-symbols-rounded">settings</span> Settings</a></li>
                    <li><a href="{{ route('admin.nodes.view.configuration', $node->id) }}"><span class="material-symbols-rounded">settings_applications</span> Configuration</a></li>
                    <li><a href="{{ route('admin.nodes.view.allocation', $node->id) }}"><span class="material-symbols-rounded">share_location</span> Allocation</a></li>
                    <li><a href="{{ route('admin.nodes.view.servers', $node->id) }}"><span class="material-symbols-rounded">dns</span> Servers</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- LEFT COLUMN --}}
    <div class="col-sm-8">
        {{-- SYSTEM INFORMATION --}}
        <div class="theme-card">
            <div class="card-header-theme">
                <span class="material-symbols-rounded" style="color: #6366f1;">memory</span> System Information
            </div>
            <div class="card-body-theme">
                <table class="theme-table">
                    <tr>
                        <td>Daemon Version</td>
                        <td>
                            <code data-attr="info-version"><span class="material-symbols-rounded spin-anim" style="font-size:14px;">sync</span></code>
                            <span style="font-size: 12px; color: var(--text-sub); margin-left: 5px;">(Latest: <code>{{ $version->getDaemon() }}</code>)</span>
                        </td>
                    </tr>
                    <tr>
                        <td>System Info</td>
                        <td data-attr="info-system"><span class="material-symbols-rounded spin-anim" style="font-size:16px;">sync</span></td>
                    </tr>
                    <tr>
                        <td>Total CPU Threads</td>
                        <td data-attr="info-cpus"><span class="material-symbols-rounded spin-anim" style="font-size:16px;">sync</span></td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- DESCRIPTION (IF EXISTS) --}}
        @if ($node->description)
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">description</span> Description
                </div>
                <div class="card-body-theme">
                    <pre>{{ $node->description }}</pre>
                </div>
            </div>
        @endif

        {{-- DELETE NODE --}}
        <div class="theme-card" style="border-color: #fca5a5;">
            <div class="card-header-theme" style="color: #b91c1c; border-bottom-color: #fca5a5; background: #fef2f2;">
                <span class="material-symbols-rounded">warning</span> Delete Node
            </div>
            <div class="card-body-theme">
                <p style="color: var(--text-main); margin: 0; line-height: 1.6;">
                    Deleting a node is an <strong>irreversible action</strong> and will immediately remove this node from the panel. There must be no servers associated with this node in order to continue.
                </p>
            </div>
            <div class="card-footer-theme" style="background: #fff1f2; border-top-color: #fca5a5;">
                <form action="{{ route('admin.nodes.view.delete', $node->id) }}" method="POST">
                    {!! csrf_field() !!}
                    {!! method_field('DELETE') !!}
                    <button type="submit" class="btn-danger-theme" {{ ($node->servers_count < 1) ?: 'disabled' }}>
                        Yes, Delete This Node
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- RIGHT COLUMN --}}
    <div class="col-sm-4">
        <div class="theme-card">
            <div class="card-header-theme">
                <span class="material-symbols-rounded" style="color: #6366f1;">analytics</span> At-a-Glance
            </div>
            <div class="card-body-theme">
                
                {{-- MAINTENANCE ALERT --}}
                @if($node->maintenance_mode)
                    <div style="background: #fffbeb; border: 1px solid #fcd34d; color: #92400e; padding: 12px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <span class="material-symbols-rounded">build</span>
                        <div style="font-weight: 700;">Node is under Maintenance</div>
                    </div>
                @endif

                {{-- DISK STATS --}}
                <div class="stat-item">
                    <div class="stat-header">
                        <span><span class="material-symbols-rounded" style="font-size: 16px; margin-right: 5px;">hard_drive</span> Disk Space</span>
                        <span class="{{ $stats['disk']['css'] }}" style="font-weight: 700;">{{ $stats['disk']['percent'] }}%</span>
                    </div>
                    <span class="stat-value">{{ $stats['disk']['value'] }} / {{ $stats['disk']['max'] }} MiB</span>
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" style="width: {{ $stats['disk']['percent'] }}%; background-color: {{ $stats['disk']['css'] == 'green' ? 'var(--success)' : ($stats['disk']['css'] == 'yellow' ? 'var(--warning)' : 'var(--danger)') }};"></div>
                    </div>
                </div>

                {{-- MEMORY STATS --}}
                <div class="stat-item">
                    <div class="stat-header">
                        <span><span class="material-symbols-rounded" style="font-size: 16px; margin-right: 5px;">memory</span> Memory</span>
                        <span class="{{ $stats['memory']['css'] }}" style="font-weight: 700;">{{ $stats['memory']['percent'] }}%</span>
                    </div>
                    <span class="stat-value">{{ $stats['memory']['value'] }} / {{ $stats['memory']['max'] }} MiB</span>
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" style="width: {{ $stats['memory']['percent'] }}%; background-color: {{ $stats['memory']['css'] == 'green' ? 'var(--success)' : ($stats['memory']['css'] == 'yellow' ? 'var(--warning)' : 'var(--danger)') }};"></div>
                    </div>
                </div>

                {{-- SERVER COUNT --}}
                <div class="stat-item" style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span class="material-symbols-rounded" style="color: #3b82f6; background: rgba(59, 130, 246, 0.1); padding: 8px; border-radius: 8px;">dns</span>
                        <span style="font-weight: 600; color: var(--text-sub);">Total Servers</span>
                    </div>
                    <span style="font-size: 20px; font-weight: 800; color: var(--text-main);">{{ $node->servers_count }}</span>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    function escapeHtml(str) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }

    (function getInformation() {
        $.ajax({
            method: 'GET',
            url: '/admin/nodes/view/{{ $node->id }}/system-information',
            timeout: 5000,
        }).done(function (data) {
            $('[data-attr="info-version"]').html(escapeHtml(data.version));
            $('[data-attr="info-system"]').html(escapeHtml(data.system.type) + ' (' + escapeHtml(data.system.arch) + ') <code>' + escapeHtml(data.system.release) + '</code>');
            $('[data-attr="info-cpus"]').html(data.system.cpus);
        }).fail(function (jqXHR) {
            // Optional: Handle error visual
        }).always(function() {
            setTimeout(getInformation, 10000);
        });
    })();
    </script>
@endsection

