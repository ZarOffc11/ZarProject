@extends('layouts.admin')

@section('title')
    Server — {{ $server->name }}: Manage
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

    /* NAVIGATION CONTAINER STYLE (Agar partials pas posisinya) */
    .nav-container-unified {
        padding: 0 24px 20px 24px;
        margin-top: 20px;
    }
    /* Override style bawaan partial jika perlu agar border-bottom menyatu */
    .nav-container-unified ul { margin-bottom: 0 !important; border-bottom: 1px solid var(--border-color); }

    /* ACTION CARD HEADERS */
    .card-header-action {
        padding: 15px 24px; border-bottom: 1px solid var(--border-color);
        font-weight: 700; font-size: 15px; display: flex; align-items: center; gap: 8px;
    }
    .header-danger { color: #ef4444; background: rgba(239, 68, 68, 0.05); border-bottom-color: #fca5a5; }
    .header-warning { color: #f59e0b; background: rgba(245, 158, 11, 0.05); border-bottom-color: #fcd34d; }
    .header-success { color: #10b981; background: rgba(16, 185, 129, 0.05); border-bottom-color: #6ee7b7; }
    .header-primary { color: #6366f1; background: rgba(99, 102, 241, 0.05); border-bottom-color: #a5b4fc; }

    .card-body-theme { padding: 24px; flex-grow: 1; color: var(--text-main); font-size: 14px; line-height: 1.6; }
    .card-footer-theme {
        padding: 15px 24px; background: var(--input-bg); border-top: 1px solid var(--border-color);
    }

    /* BUTTONS */
    .btn-full { width: 100%; display: flex; justify-content: center; align-items: center; gap: 8px; padding: 10px; border-radius: 8px; font-weight: 600; transition: 0.2s; cursor: pointer; border: 1px solid transparent; }
    
    .btn-danger-theme { background: #fee2e2; color: #b91c1c; border-color: #fecaca; }
    .btn-danger-theme:hover { background: #b91c1c; color: #fff; }
    
    .btn-warning-theme { background: #fef3c7; color: #92400e; border-color: #fde68a; }
    .btn-warning-theme:hover { background: #d97706; color: #fff; }

    .btn-success-theme { background: #d1fae5; color: #065f46; border-color: #a7f3d0; }
    .btn-success-theme:hover { background: #059669; color: #fff; }

    .btn-primary-theme { background: #e0e7ff; color: #3730a3; border-color: #c7d2fe; }
    .btn-primary-theme:hover { background: #4f46e5; color: #fff; }

    .btn-disabled { opacity: 0.6; cursor: not-allowed; filter: grayscale(1); }

    /* MODAL */
    .modal-content { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; color: var(--text-main); }
    .modal-header { border-bottom: 1px solid var(--border-color); padding: 20px; }
    .modal-footer { border-top: 1px solid var(--border-color); background: var(--input-bg); padding: 15px 20px; border-radius: 0 0 16px 16px; }
    .close { color: var(--text-main); opacity: 0.7; }
    
    .form-control {
        background: var(--input-bg) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important; border-radius: 10px !important; height: 42px;
    }
    label { color: var(--text-main); font-weight: 600; font-size: 13px; margin-bottom: 6px; }

    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>{{ $server->name }}</h1>
                    <small>Additional actions to control this server.</small>
                </div>
                <span class="material-symbols-rounded" style="color: #6366f1; font-size: 30px;">dns</span>
            </div>
            
            {{-- MENGGUNAKAN INCLUDE PARTIAL --}}
            <div class="nav-container-unified">
                @include('admin.servers.partials.navigation')
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- REINSTALL SERVER --}}
    <div class="col-sm-4">
        <div class="theme-card" style="border: 1px solid #fca5a5;">
            <div class="card-header-action header-danger">
                <span class="material-symbols-rounded">refresh</span> Reinstall Server
            </div>
            <div class="card-body-theme">
                This will reinstall the server with the assigned service scripts. 
                <strong style="color: #ef4444;">Danger!</strong> This could overwrite server data.
            </div>
            <div class="card-footer-theme" style="border-top-color: #fca5a5; background: #fef2f2;">
                @if($server->isInstalled())
                    <form action="{{ route('admin.servers.view.manage.reinstall', $server->id) }}" method="POST">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn-full btn-danger-theme">Reinstall Server</button>
                    </form>
                @else
                    <button class="btn-full btn-danger-theme btn-disabled">Install Incomplete</button>
                @endif
            </div>
        </div>
    </div>

    {{-- INSTALL STATUS --}}
    <div class="col-sm-4">
        <div class="theme-card" style="border: 1px solid #a5b4fc;">
            <div class="card-header-action header-primary">
                <span class="material-symbols-rounded">build_circle</span> Install Status
            </div>
            <div class="card-body-theme">
                Need to change the install status from uninstalled to installed (or vice versa)? You may do so with the button below.
            </div>
            <div class="card-footer-theme" style="border-top-color: #a5b4fc; background: #eef2ff;">
                <form action="{{ route('admin.servers.view.manage.toggle', $server->id) }}" method="POST">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn-full btn-primary-theme">Toggle Install Status</button>
                </form>
            </div>
        </div>
    </div>

    {{-- SUSPEND / UNSUSPEND --}}
    <div class="col-sm-4">
        @if(! $server->isSuspended())
            <div class="theme-card" style="border: 1px solid #fcd34d;">
                <div class="card-header-action header-warning">
                    <span class="material-symbols-rounded">pause_circle</span> Suspend Server
                </div>
                <div class="card-body-theme">
                    This will stop any running processes and immediately block the user from accessing their files or managing the server.
                </div>
                <div class="card-footer-theme" style="border-top-color: #fcd34d; background: #fffbeb;">
                    <form action="{{ route('admin.servers.view.manage.suspension', $server->id) }}" method="POST">
                        {!! csrf_field() !!}
                        <input type="hidden" name="action" value="suspend" />
                        <button type="submit" class="btn-full btn-warning-theme @if(! is_null($server->transfer)) btn-disabled @endif">
                            Suspend Server
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="theme-card" style="border: 1px solid #6ee7b7;">
                <div class="card-header-action header-success">
                    <span class="material-symbols-rounded">play_circle</span> Unsuspend Server
                </div>
                <div class="card-body-theme">
                    This will unsuspend the server and restore normal user access immediately.
                </div>
                <div class="card-footer-theme" style="border-top-color: #6ee7b7; background: #ecfdf5;">
                    <form action="{{ route('admin.servers.view.manage.suspension', $server->id) }}" method="POST">
                        {!! csrf_field() !!}
                        <input type="hidden" name="action" value="unsuspend" />
                        <button type="submit" class="btn-full btn-success-theme">Unsuspend Server</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="row">
    {{-- TRANSFER SERVER --}}
    <div class="col-sm-12">
        @if(is_null($server->transfer))
            <div class="theme-card">
                <div class="card-header-action header-success">
                    <span class="material-symbols-rounded">move_up</span> Transfer Server
                </div>
                <div class="card-body-theme">
                    <p style="margin:0;">
                        Transfer this server to another node connected to this panel. 
                        <strong>Note:</strong> Ensure you have enough allocations on the target node.
                    </p>
                </div>
                <div class="card-footer-theme" style="display: flex; justify-content: space-between; align-items: center;">
                    @if($canTransfer)
                        <button class="btn-full btn-success-theme" style="width: auto; padding: 10px 30px;" data-toggle="modal" data-target="#transferServerModal">
                            Transfer Server
                        </button>
                    @else
                        <button class="btn-full btn-success-theme btn-disabled" style="width: auto; padding: 10px 30px;">
                            Transfer Server
                        </button>
                        <span class="text-muted">Requires multiple nodes configured.</span>
                    @endif
                </div>
            </div>
        @else
            <div class="theme-card">
                <div class="card-header-action header-warning">
                    <span class="material-symbols-rounded">hourglass_top</span> Transfer In Progress
                </div>
                <div class="card-body-theme">
                    <p>
                        This server is currently being transferred to another node.
                        Transfer initiated at: <strong>{{ $server->transfer->created_at }}</strong>
                    </p>
                </div>
                <div class="card-footer-theme">
                    <button class="btn-full btn-success-theme btn-disabled">Transfer Server</button>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- MODAL TRANSFER --}}
<div class="modal fade" id="transferServerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.servers.view.manage.transfer', $server->id) }}" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="font-weight: 700;">Transfer Server</h4>
                </div>

                <div class="modal-body" style="padding: 24px;">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="pNodeId">Target Node</label>
                            <select name="node_id" id="pNodeId" class="form-control">
                                @foreach($locations as $location)
                                    <optgroup label="{{ $location->long }} ({{ $location->short }})">
                                        @foreach($location->nodes as $node)
                                            @if($node->id != $server->node_id)
                                                <option value="{{ $node->id }}" @if($location->id === old('location_id')) selected @endif>{{ $node->name }}</option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <p class="small text-muted">Select the node to transfer this server to.</p>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="pAllocation">Default Allocation</label>
                            <select name="allocation_id" id="pAllocation" class="form-control"></select>
                            <p class="small text-muted">Main allocation IP/Port for the server.</p>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="pAllocationAdditional">Additional Allocation(s)</label>
                            <select name="allocation_additional[]" id="pAllocationAdditional" class="form-control" multiple></select>
                            <p class="small text-muted">Optional extra ports.</p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    {!! csrf_field() !!}
                    <button type="button" class="btn-full btn-primary-theme" style="width: auto; float: right; margin-left: 10px;" onclick="$(this).closest('form').submit()">Confirm Transfer</button>
                    <button type="button" class="btn-full btn-danger-theme" style="width: auto; float: left;" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}

    @if($canTransfer)
        {!! Theme::js('js/admin/server/transfer.js') !!}
    @endif
@endsection

