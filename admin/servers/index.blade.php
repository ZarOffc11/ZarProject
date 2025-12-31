@extends('layouts.admin')

@section('title')
    Server List
@endsection

@section('content-header')
@endsection

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<style>
    /* LOCAL STYLE OVERRIDES */
    /* Variabel diambil dari Layout Global, tapi kita definisikan ulang komponen spesifik di sini */
    :root {
        --btn-bg: #ffffff; --btn-text: #1f2937; --btn-border: #d1d5db; --btn-hover: #f3f4f6; --badge-bg: #f3f4f6;
    }
    body.dark-mode {
        --btn-bg: #1b1e24; --btn-text: #e2e8f0; --btn-border: #4a5568; --btn-hover: #2d3748; --badge-bg: #2a2e36;
    }

    .content { padding-top: 10px !important; }

    /* CARD STYLE */
    .theme-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        overflow: hidden;
        margin-top: 10px;
    }

    /* HEADER */
    .card-header-unified {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-title h1 { font-size: 20px; font-weight: 800; margin: 0; color: var(--text-main); letter-spacing: -0.5px; }
    .header-title small { display: block; font-size: 13px; color: var(--text-sub); margin-top: 4px; font-weight: 500; }

    /* TOOLBAR */
    .header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-grow: 1;
        justify-content: flex-end;
    }

    /* SEARCH BOX */
    .search-box { position: relative; max-width: 300px; width: 100%; }
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
        padding: 0 16px; height: 38px; border-radius: 8px; font-weight: 600; font-size: 13px;
        display: inline-flex; align-items: center; gap: 6px; cursor: pointer; transition: all 0.2s;
        text-decoration: none !important; white-space: nowrap;
    }
    .btn-simple:hover { background: var(--btn-hover); border-color: var(--text-sub); color: var(--text-main); }
    
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

    /* COMPONENTS */
    .user-info { display: flex; align-items: center; gap: 10px; color: var(--text-main); font-weight: 600; text-decoration: none !important; }
    .avatar-icon {
        width: 32px; height: 32px; background: var(--badge-bg); border-radius: 50%;
        display: flex; align-items: center; justify-content: center; color: var(--text-sub);
    }
    .status-badge {
        padding: 4px 10px; border-radius: 30px; font-size: 11px; font-weight: 700;
        display: inline-flex; align-items: center; gap: 4px;
    }
    .status-active { background: #dcfce7; color: #15803d; }
    .status-install { background: #ffedd5; color: #c2410c; }
    .status-suspend { background: #fee2e2; color: #b91c1c; }
    
    .material-symbols-rounded { font-size: 18px; vertical-align: middle; }
    
    @media(max-width: 768px) {
        .card-header-unified { flex-direction: column; align-items: stretch; gap: 15px; }
        .header-actions { flex-direction: column; width: 100%; }
        .search-box { max-width: 100%; }
        .btn-simple { width: 100%; justify-content: center; }
    }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>Servers</h1>
                    <small>Manage infrastructure</small>
                </div>

                <div class="header-actions">
                    <form action="{{ route('admin.servers') }}" method="GET" style="width:100%; max-width:300px;">
                        <div class="search-box">
                            <span class="material-symbols-rounded search-icon-i">search</span>
                            <input type="text" name="filter[name]" class="search-input" placeholder="Search servers..." value="{{ request()->input('filter.name') }}">
                        </div>
                    </form>

                    <a href="{{ route('admin.servers.new') }}" class="btn-simple">
                        <span class="material-symbols-rounded">add_circle</span> New
                    </a>
                    {{-- TOMBOL THEME DISINI SUDAH DIHAPUS --}}
                </div>
            </div>

            <div class="table-responsive">
                <table class="theme-table">
                    <thead>
                        <tr>
                            <th>Server Name</th>
                            <th>Owner</th>
                            <th>Node</th>
                            <th>Connection</th>
                            <th class="text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($servers as $server)
                            <tr>
                                <td>
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <div style="width:36px; height:36px; background:var(--badge-bg); border-radius:10px; display:flex; align-items:center; justify-content:center; color:var(--text-sub);">
                                            <span class="material-symbols-rounded">dns</span>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.servers.view', $server->id) }}" style="text-decoration:none; color:var(--text-main); font-weight:700; display:block;">{{ $server->name }}</a>
                                            <span style="font-size:12px; color:var(--text-sub); font-family:monospace;">{{ $server->uuid_short }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.view', $server->user->id) }}" class="user-info">
                                        <div class="avatar-icon"><span class="material-symbols-rounded">person</span></div>
                                        {{ $server->user->username }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.nodes.view', $server->node->id) }}" class="user-info" style="font-size:13px; color:var(--text-sub);">
                                        <span class="material-symbols-rounded" style="font-size:18px;">hub</span> {{ $server->node->name }}
                                    </a>
                                </td>
                                <td>
                                    <code style="background:var(--input-bg); color:var(--text-main); border:1px solid var(--border-color); padding: 4px 8px; border-radius: 6px; font-family: 'Menlo', monospace;">
                                        {{ $server->allocation->alias }}:{{ $server->allocation->port }}
                                    </code>
                                </td>
                                <td class="text-right">
                                    @if($server->isSuspended())
                                        <span class="status-badge status-suspend">Suspended</span>
                                    @elseif(!$server->isInstalled())
                                        <span class="status-badge status-install">Installing</span>
                                    @else
                                        <span class="status-badge status-active">Active</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($servers->hasPages())
                <div style="padding:15px; border-top:1px solid var(--border-color); text-align:center;">
                    {!! $servers->render() !!}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

