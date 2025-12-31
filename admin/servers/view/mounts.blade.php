@extends('layouts.admin')

@section('title')
    Server — {{ $server->name }}: Mounts
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
    
    /* UNIFIED HEADER */
    .card-header-unified {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex; justify-content: space-between; align-items: center;
    }
    .header-title h1 { font-size: 20px; font-weight: 800; margin: 0; color: var(--text-main); letter-spacing: -0.5px; }
    .header-title small { display: block; font-size: 13px; color: var(--text-sub); margin-top: 4px; font-weight: 500; }

    /* NAVIGATION CONTAINER */
    .nav-container-unified {
        padding: 0 24px 20px 24px;
        margin-top: 20px;
    }
    .nav-container-unified ul { margin-bottom: 0 !important; border-bottom: 1px solid var(--border-color); }

    /* SUB HEADER */
    .card-header-theme {
        padding: 15px 24px;
        border-bottom: 1px solid var(--border-color);
        font-weight: 700; font-size: 15px; display: flex; align-items: center; gap: 8px; color: var(--text-main);
    }

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

    /* BADGES */
    .badge-status {
        padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;
    }
    .status-mounted { background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
    .status-unmounted { background: var(--input-bg); color: var(--text-sub); border: 1px solid var(--border-color); }

    /* BUTTONS */
    .btn-icon-only {
        width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
        border-radius: 8px; transition: 0.2s; border: 1px solid transparent; cursor: pointer; background: transparent;
    }
    .btn-add { color: #10b981; background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2); }
    .btn-add:hover { background: #10b981; color: #fff; }

    .btn-remove { color: #ef4444; background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.2); }
    .btn-remove:hover { background: #ef4444; color: #fff; }

    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; font-family: 'Menlo', monospace; }
    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>{{ $server->name }}</h1>
                    <small>Manage server mounts.</small>
                </div>
                <span class="material-symbols-rounded" style="color: #6366f1; font-size: 30px;">dns</span>
            </div>
            
            {{-- NAVIGATION --}}
            <div class="nav-container-unified">
                @include('admin.servers.partials.navigation')
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="theme-card">
            <div class="card-header-theme">
                <span class="material-symbols-rounded" style="color: #6366f1;">folder_zip</span> Available Mounts
            </div>

            <div class="table-responsive">
                <table class="theme-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Source</th>
                            <th>Target</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mounts as $mount)
                            <tr>
                                <td><code>{{ $mount->id }}</code></td>
                                <td>
                                    <a href="{{ route('admin.mounts.view', $mount->id) }}" style="font-weight: 600; color: #6366f1; text-decoration: none;">
                                        {{ $mount->name }}
                                    </a>
                                </td>
                                <td><code>{{ $mount->source }}</code></td>
                                <td><code>{{ $mount->target }}</code></td>

                                @if (! in_array($mount->id, $server->mounts->pluck('id')->toArray()))
                                    {{-- UNMOUNTED STATE --}}
                                    <td>
                                        <span class="badge-status status-unmounted">
                                            <span class="material-symbols-rounded" style="font-size: 14px;">radio_button_unchecked</span> Unmounted
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <form action="{{ route('admin.servers.view.mounts.store', [ 'server' => $server->id ]) }}" method="POST">
                                            {!! csrf_field() !!}
                                            <input type="hidden" value="{{ $mount->id }}" name="mount_id" />
                                            <button type="submit" class="btn-icon-only btn-add" title="Mount">
                                                <span class="material-symbols-rounded">add_link</span>
                                            </button>
                                        </form>
                                    </td>
                                @else
                                    {{-- MOUNTED STATE --}}
                                    <td>
                                        <span class="badge-status status-mounted">
                                            <span class="material-symbols-rounded" style="font-size: 14px;">check_circle</span> Mounted
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <form action="{{ route('admin.servers.view.mounts.delete', [ 'server' => $server->id, 'mount' => $mount->id ]) }}" method="POST">
                                            @method('DELETE')
                                            {!! csrf_field() !!}
                                            <button type="submit" class="btn-icon-only btn-remove" title="Unmount">
                                                <span class="material-symbols-rounded">link_off</span>
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

