@extends('layouts.admin')

@section('title')
    {{ $node->name }}: Servers
@endsection

{{-- HEADER BAWAAN DIHILANGKAN --}}
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

    /* SUB-HEADER (UNTUK CARD TABLE) */
    .card-header-theme {
        padding: 15px 24px;
        border-bottom: 1px solid var(--border-color);
        font-weight: 700; font-size: 15px; display: flex; align-items: center; gap: 8px; color: var(--text-main);
    }
    .card-footer-theme {
        padding: 15px 24px; background: var(--input-bg); border-top: 1px solid var(--border-color);
        display: flex; justify-content: center;
    }

    /* NAVIGATION PILLS */
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

    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; font-family: 'Menlo', monospace; }
    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            {{-- UNIFIED HEADER --}}
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>{{ $node->name }}</h1>
                    <small>All servers currently assigned to this node.</small>
                </div>
                <span class="material-symbols-rounded" style="color: #6366f1; font-size: 30px;">hub</span>
            </div>
            
            {{-- NAVIGATION TABS --}}
            <div style="margin-top: 20px;">
                <ul class="nav-pills-modern">
                    <li><a href="{{ route('admin.nodes.view', $node->id) }}"><span class="material-symbols-rounded">info</span> About</a></li>
                    <li><a href="{{ route('admin.nodes.view.settings', $node->id) }}"><span class="material-symbols-rounded">settings</span> Settings</a></li>
                    <li><a href="{{ route('admin.nodes.view.configuration', $node->id) }}"><span class="material-symbols-rounded">settings_applications</span> Configuration</a></li>
                    <li><a href="{{ route('admin.nodes.view.allocation', $node->id) }}"><span class="material-symbols-rounded">share_location</span> Allocation</a></li>
                    <li class="active"><a href="{{ route('admin.nodes.view.servers', $node->id) }}"><span class="material-symbols-rounded">dns</span> Servers</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="theme-card">
            <div class="card-header-theme">
                <span class="material-symbols-rounded" style="color: #6366f1;">list_alt</span> Process Manager
            </div>
            
            <div class="table-responsive">
                <table class="theme-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Server Name</th>
                            <th>Owner</th>
                            <th>Service</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servers as $server)
                            <tr data-server="{{ $server->uuid }}">
                                <td><code>{{ $server->uuidShort }}</code></td>
                                <td>
                                    <a href="{{ route('admin.servers.view', $server->id) }}" style="font-weight: 600; color: #6366f1; text-decoration: none;">
                                        {{ $server->name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.view', $server->owner_id) }}" style="color: var(--text-main); text-decoration: none; display: flex; align-items: center; gap: 5px;">
                                        <span class="material-symbols-rounded" style="font-size: 16px; color: var(--text-sub);">person</span>
                                        {{ $server->user->username }}
                                    </a>
                                </td>
                                <td>
                                    {{ $server->nest->name }} 
                                    <span style="color: var(--text-sub); font-size: 12px;">({{ $server->egg->name }})</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($servers->hasPages())
                <div class="card-footer-theme">
                    {!! $servers->render() !!}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

