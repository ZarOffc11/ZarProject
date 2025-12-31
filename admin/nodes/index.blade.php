@extends('layouts.admin')

@section('title')
    List Nodes
@endsection

@section('scripts')
    @parent
    {{-- Kita tidak butuh animate.css bawaan lagi, kita buat animasi sendiri di CSS --}}
@endsection

@section('content-header')
    {{-- Header Kosong (Unified) --}}
@endsection

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<style>
    /* === LOCAL STYLE OVERRIDES === */
    :root {
        --bg-app: #f3f4f6; --bg-card: #ffffff; --text-main: #1f2937; --text-sub: #6b7280;
        --border-color: #e5e7eb; --input-bg: #f9fafb; --btn-bg: #ffffff; --btn-text: #1f2937;
        --btn-border: #d1d5db; --btn-hover: #f3f4f6; --badge-bg: #f3f4f6;
    }
    body.dark-mode {
        --btn-bg: #1b1e24; --btn-text: #e2e8f0; --btn-border: #4a5568; --btn-hover: #2d3748; --badge-bg: #2a2e36;
    }

    .content { padding-top: 10px !important; }
    .content-header { display: none !important; }

    /* CARD STYLE */
    .theme-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        margin-bottom: 20px;
        overflow: hidden;
        margin-top: 10px;
    }

    /* HEADER UNIFIED */
    .card-header-unified {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;
    }
    .header-title h1 { font-size: 20px; font-weight: 800; margin: 0; color: var(--text-main); letter-spacing: -0.5px; }
    .header-title small { display: block; font-size: 13px; color: var(--text-sub); margin-top: 4px; font-weight: 500; }

    /* TOOLBAR ACTIONS */
    .header-actions { display: flex; align-items: center; gap: 10px; }

    /* SEARCH BOX */
    .search-box { position: relative; width: 250px; }
    .search-input {
        width: 100%; background: var(--input-bg); border: 1px solid var(--border-color);
        color: var(--text-main); padding: 8px 12px 8px 38px; border-radius: 8px;
        outline: none; height: 38px; font-size: 13px; transition: all 0.2s;
    }
    .search-input:focus { border-color: #6366f1; background: var(--bg-card); }
    .search-icon-i { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-sub); font-size: 18px; }

    /* BUTTONS */
    .btn-simple {
        background: var(--btn-bg); color: var(--btn-text); border: 1px solid var(--btn-border);
        padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
        text-decoration: none !important; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-simple:hover { background: var(--btn-hover); border-color: var(--text-main); }

    /* TABLE */
    .theme-table { width: 100%; border-collapse: collapse; }
    .theme-table th {
        text-align: left; padding: 12px 24px; color: var(--text-sub); font-size: 11px;
        text-transform: uppercase; border-bottom: 1px solid var(--border-color); font-weight: 700; letter-spacing: 0.05em;
    }
    .theme-table td {
        padding: 14px 24px; border-bottom: 1px solid var(--border-color);
        color: var(--text-main); vertical-align: middle; font-size: 14px;
    }
    .theme-table tr:hover { background-color: var(--input-bg); }
    .theme-table tr:last-child td { border-bottom: none; }

    /* CUSTOM BADGES & ICONS */
    .badge-maintenance { background: #fefce8; color: #a16207; border: 1px solid #fde047; padding: 2px 6px; border-radius: 4px; font-size: 11px; margin-right: 5px; }
    
    .status-icon { transition: all 0.3s; font-size: 20px; }
    .spin-anim { animation: spin 2s linear infinite; color: var(--text-sub); }
    .pulse-anim { animation: pulse-green 2s infinite; }
    
    @keyframes spin { 100% { transform: rotate(360deg); } }
    @keyframes pulse-green {
        0% { transform: scale(0.95); opacity: 0.7; }
        70% { transform: scale(1.1); opacity: 1; }
        100% { transform: scale(0.95); opacity: 0.7; }
    }

    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; font-family: 'Menlo', monospace; }
    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            
            {{-- HEADER --}}
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>Nodes</h1>
                    <small>All nodes available on the system.</small>
                </div>

                <div class="header-actions">
                    <form action="{{ route('admin.nodes') }}" method="GET">
                        <div class="search-box">
                            <span class="material-symbols-rounded search-icon-i">search</span>
                            <input type="text" name="filter[name]" class="search-input" value="{{ request()->input('filter.name') }}" placeholder="Search Nodes...">
                        </div>
                    </form>
                    
                    <a href="{{ route('admin.nodes.new') }}" class="btn-simple">
                        <span class="material-symbols-rounded">add_circle</span> Create New
                    </a>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="theme-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;"></th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Memory</th>
                            <th>Disk</th>
                            <th class="text-center">Servers</th>
                            <th class="text-center">SSL</th>
                            <th class="text-center">Public</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nodes as $node)
                            <tr>
                                <td class="text-center left-icon" data-action="ping" data-secret="{{ $node->getDecryptedKey() }}" data-location="{{ $node->scheme }}://{{ $node->fqdn }}:{{ $node->daemonListen }}/api/system">
                                    {{-- Loading Icon Default --}}
                                    <span class="material-symbols-rounded status-icon spin-anim">sync</span>
                                </td>
                                <td>
                                    @if($node->maintenance_mode)
                                        <span class="badge-maintenance" title="Maintenance Mode">
                                            <span class="material-symbols-rounded" style="font-size:12px;">build</span>
                                        </span>
                                    @endif
                                    <a href="{{ route('admin.nodes.view', $node->id) }}" style="font-weight: 600; color: #6366f1; text-decoration: none;">{{ $node->name }}</a>
                                </td>
                                <td>{{ $node->location->short }}</td>
                                <td>{{ $node->memory }} MiB</td>
                                <td>{{ $node->disk }} MiB</td>
                                <td class="text-center">{{ $node->servers_count }}</td>
                                <td class="text-center">
                                    @if($node->scheme === 'https')
                                        <span class="material-symbols-rounded" style="color: #15803d;" title="Secure (HTTPS)">lock</span>
                                    @else
                                        <span class="material-symbols-rounded" style="color: #b91c1c;" title="Insecure (HTTP)">no_encryption</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($node->public)
                                        <span class="material-symbols-rounded" style="color: var(--text-main);">visibility</span>
                                    @else
                                        <span class="material-symbols-rounded" style="color: var(--text-sub);">visibility_off</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($nodes->hasPages())
                <div class="card-footer-theme" style="display:flex; justify-content:center; padding: 15px;">
                    {!! $nodes->appends(['query' => Request::input('query')])->render() !!}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    (function pingNodes() {
        $('td[data-action="ping"]').each(function(i, element) {
            $.ajax({
                type: 'GET',
                url: $(element).data('location'),
                headers: {
                    'Authorization': 'Bearer ' + $(element).data('secret'),
                },
                timeout: 5000
            }).done(function (data) {
                // Success: Change icon to Heartbeat (Green & Pulsing)
                let icon = $(element).find('span');
                icon.text('monitor_heart'); 
                icon.removeClass('spin-anim').addClass('pulse-anim');
                icon.css('color', '#15803d'); // Green

                $(element).tooltip({
                    title: 'v' + data.version,
                    placement: 'right'
                });
            }).fail(function (error) {
                // Fail: Change icon to Error (Red)
                var errorText = 'Error connecting to node! Check browser console for details.';
                try {
                    errorText = error.responseJSON.errors[0].detail || errorText;
                } catch (ex) {}

                let icon = $(element).find('span');
                icon.text('heart_broken'); // Or 'error'
                icon.removeClass('spin-anim');
                icon.css('color', '#b91c1c'); // Red

                $(element).tooltip({ title: errorText, placement: 'right' });
            });
        }).promise().done(function () {
            setTimeout(pingNodes, 10000);
        });
    })();
    </script>
@endsection

