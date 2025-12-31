@extends('layouts.admin')

@section('title')
    Server — {{ $server->name }}: Delete
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
        height: 100%;
        display: flex; flex-direction: column;
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
    .nav-container-unified { padding: 0 24px 20px 24px; margin-top: 20px; }
    .nav-container-unified ul { margin-bottom: 0 !important; border-bottom: 1px solid var(--border-color); }

    /* SUB HEADER */
    .card-header-theme {
        padding: 15px 24px; border-bottom: 1px solid var(--border-color);
        font-weight: 700; font-size: 15px; display: flex; align-items: center; gap: 8px; color: var(--text-main);
    }
    .header-danger { background: rgba(239, 68, 68, 0.05); color: #ef4444; border-bottom-color: #fca5a5; }

    .card-body-theme { padding: 24px; color: var(--text-main); flex-grow: 1; }
    .card-footer-theme {
        padding: 15px 24px; background: var(--input-bg); border-top: 1px solid var(--border-color);
        display: flex; justify-content: flex-end;
    }

    /* BUTTONS */
    .btn-danger-theme {
        background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; width: 100%;
        padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-danger-theme:hover { background: #b91c1c; color: #fff; border-color: #b91c1c; }

    /* ALERTS */
    .alert-danger-theme {
        background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3);
        color: #ef4444; padding: 15px; border-radius: 10px; font-size: 13px; margin-top: 15px; line-height: 1.6;
    }

    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>{{ $server->name }}</h1>
                    <small>Permanently delete this server.</small>
                </div>
                <span class="material-symbols-rounded" style="color: #ef4444; font-size: 30px;">delete_forever</span>
            </div>
            
            <div class="nav-container-unified">
                @include('admin.servers.partials.navigation')
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- SAFE DELETE --}}
    <div class="col-md-6">
        <div class="theme-card">
            <div class="card-header-theme">
                <span class="material-symbols-rounded" style="color: #f59e0b;">delete</span> Safely Delete Server
            </div>
            <div class="card-body-theme">
                <p style="margin:0;">
                    This action will attempt to delete the server from both the panel and daemon. 
                    If either one reports an error, the action will be cancelled to prevent data inconsistency.
                </p>
                <div class="alert-danger-theme">
                    <span class="material-symbols-rounded" style="vertical-align:bottom; margin-right:5px;">warning</span>
                    <strong>Warning:</strong> Deleting a server is an irreversible action. All server data (files, databases, allocations) will be removed.
                </div>
            </div>
            <div class="card-footer-theme">
                <form id="deleteform" action="{{ route('admin.servers.view.delete', $server->id) }}" method="POST" style="width: 100%;">
                    {!! csrf_field() !!}
                    <button id="deletebtn" class="btn-danger-theme">Safely Delete Server</button>
                </form>
            </div>
        </div>
    </div>

    {{-- FORCE DELETE --}}
    <div class="col-md-6">
        <div class="theme-card" style="border: 1px solid #ef4444;">
            <div class="card-header-theme header-danger">
                <span class="material-symbols-rounded">bomb</span> Force Delete Server
            </div>
            <div class="card-body-theme">
                <p style="margin:0;">
                    This action attempts to delete the server regardless of errors. If the daemon does not respond or reports an error, the deletion will continue on the panel side.
                </p>
                <div class="alert-danger-theme">
                    <span class="material-symbols-rounded" style="vertical-align:bottom; margin-right:5px;">error</span>
                    <strong>Danger:</strong> This method may leave dangling files on your daemon if it reports an error. Only use this if "Safely Delete" fails.
                </div>
            </div>
            <div class="card-footer-theme" style="background: #fef2f2; border-top-color: #fca5a5;">
                <form id="forcedeleteform" action="{{ route('admin.servers.view.delete', $server->id) }}" method="POST" style="width: 100%;">
                    {!! csrf_field() !!}
                    <input type="hidden" name="force_delete" value="1" />
                    <button id="forcedeletebtn" class="btn-danger-theme" style="background: #ef4444; color: #fff; border-color: #dc2626;">Forcibly Delete Server</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#deletebtn').click(function (event) {
        event.preventDefault();
        swal({
            title: 'Confirm Deletion',
            type: 'warning',
            text: 'Are you sure that you want to delete this server? There is no going back, all data will immediately be removed.',
            showCancelButton: true,
            confirmButtonText: 'Delete Server',
            confirmButtonColor: '#d9534f',
            closeOnConfirm: false
        }, function () {
            $('#deleteform').submit()
        });
    });

    $('#forcedeletebtn').click(function (event) {
        event.preventDefault();
        swal({
            title: 'Confirm Force Deletion',
            type: 'warning',
            text: 'This will remove the server from the database even if the daemon reports an error. This can leave junk files on your node.',
            showCancelButton: true,
            confirmButtonText: 'Force Delete',
            confirmButtonColor: '#d9534f',
            closeOnConfirm: false
        }, function () {
            $('#forcedeleteform').submit()
        });
    });
    </script>
@endsection
