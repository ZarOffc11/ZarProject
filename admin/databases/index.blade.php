@extends('layouts.admin')

@section('title')
    Database Hosts
@endsection

@section('content-header')
    {{-- Header Kosong (Unified) --}}
@endsection

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<style>
    /* === LOCAL STYLE OVERRIDES === */
    :root {
        --btn-bg: #ffffff; --btn-text: #1f2937; --btn-border: #d1d5db; --btn-hover: #f3f4f6; --badge-bg: #f3f4f6;
    }
    body.dark-mode {
        --btn-bg: #1b1e24; --btn-text: #e2e8f0; --btn-border: #4a5568; --btn-hover: #2d3748; --badge-bg: #2a2e36;
    }

    .content { padding-top: 10px !important; }
    .content-header { padding: 0 !important; margin-bottom: 15px !important; background: transparent !important; border: none !important; height: auto !important; }

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
        display: flex; justify-content: space-between; align-items: center;
    }
    .header-title h1 { font-size: 20px; font-weight: 800; margin: 0; color: var(--text-main); letter-spacing: -0.5px; }
    .header-title small { display: block; font-size: 13px; color: var(--text-sub); margin-top: 4px; font-weight: 500; }

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
    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 4px 8px; border-radius: 6px; font-family: 'Menlo', monospace; font-size: 12px; }
    .label-default { background: var(--border-color); color: var(--text-sub); padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }

    /* BUTTONS */
    .btn-simple {
        background: var(--btn-bg); color: var(--btn-text); border: 1px solid var(--btn-border);
        padding: 8px 16px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.2s;
        text-decoration: none !important; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-simple:hover { background: var(--btn-hover); border-color: var(--text-main); }
    
    .btn-primary-theme {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 8px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-primary-theme:hover { background: #374151; border-color: #374151; }

    /* === MODAL STYLING (DARK MODE FIX) === */
    .modal-content {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .modal-header {
        border-bottom: 1px solid var(--border-color);
        padding: 20px 24px;
        background: var(--bg-card);
        border-radius: 16px 16px 0 0;
        color: var(--text-main);
    }
    .modal-title { font-weight: 700; font-size: 18px; }
    .modal-body { padding: 24px; background: var(--bg-card); color: var(--text-main); }
    .modal-footer {
        border-top: 1px solid var(--border-color);
        padding: 15px 24px;
        background: var(--input-bg);
        border-radius: 0 0 16px 16px;
    }
    .close { color: var(--text-sub); opacity: 0.7; text-shadow: none; }
    .close:hover { color: var(--text-main); opacity: 1; }

    /* FORM INPUTS IN MODAL */
    .form-control {
        background: var(--input-bg) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important; border-radius: 10px !important; height: 42px; box-shadow: none !important;
    }
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    label { color: var(--text-main); font-weight: 600; font-size: 13px; margin-bottom: 6px; }
    .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }

    /* SELECT2 MODAL FIX */
    .select2-container--default .select2-selection--single { background: var(--input-bg) !important; border: 1px solid var(--border-color) !important; height: 42px !important; border-radius: 10px !important; }
    .select2-selection__rendered { color: var(--text-main) !important; line-height: 40px !important; }
    .select2-dropdown { background: var(--bg-card) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; }

    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            {{-- HEADER UNIFIED --}}
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>Database Hosts</h1>
                    <small>Hosts capable of handling databases.</small>
                </div>
                <div>
                    <button class="btn-simple" data-toggle="modal" data-target="#newHostModal">
                        <span class="material-symbols-rounded">add_circle</span> Create New
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="theme-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Host</th>
                            <th>Port</th>
                            <th>Username</th>
                            <th class="text-center">Databases</th>
                            <th class="text-center">Node</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hosts as $host)
                            <tr>
                                <td><code>{{ $host->id }}</code></td>
                                <td>
                                    <a href="{{ route('admin.databases.view', $host->id) }}" style="font-weight: 600; color: #6366f1; text-decoration: none;">
                                        {{ $host->name }}
                                    </a>
                                </td>
                                <td><code>{{ $host->host }}</code></td>
                                <td><code>{{ $host->port }}</code></td>
                                <td><span style="color: var(--text-main);">{{ $host->username }}</span></td>
                                <td class="text-center"><span class="badge" style="background: var(--input-bg); color: var(--text-main); border: 1px solid var(--border-color);">{{ $host->databases_count }}</span></td>
                                <td class="text-center">
                                    @if(! is_null($host->node))
                                        <a href="{{ route('admin.nodes.view', $host->node->id) }}" style="color: var(--text-sub); text-decoration: underline;">{{ $host->node->name }}</a>
                                    @else
                                        <span class="label-default">None</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL CREATE NEW --}}
<div class="modal fade" id="newHostModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.databases') }}" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create New Database Host</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="pName" class="form-label">Name</label>
                        <input type="text" name="name" id="pName" class="form-control" placeholder="e.g. Local Database" />
                        <p class="text-muted small">A short identifier used to distinguish this location from others.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pHost" class="form-label">Host</label>
                                <input type="text" name="host" id="pHost" class="form-control" placeholder="127.0.0.1" />
                                <p class="text-muted small">IP address or FQDN for panel connection.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pPort" class="form-label">Port</label>
                                <input type="text" name="port" id="pPort" class="form-control" value="3306"/>
                                <p class="text-muted small">Port MySQL is running on.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pUsername" class="form-label">Username</label>
                                <input type="text" name="username" id="pUsername" class="form-control" />
                                <p class="text-muted small">Account with grant permissions.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pPassword" class="form-label">Password</label>
                                <input type="password" name="password" id="pPassword" class="form-control" />
                                <p class="text-muted small">Account password.</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pNodeId" class="form-label">Linked Node</label>
                        <select name="node_id" id="pNodeId" class="form-control">
                            <option value="">None</option>
                            @foreach($locations as $location)
                                <optgroup label="{{ $location->short }}">
                                    @foreach($location->nodes as $node)
                                        <option value="{{ $node->id }}">{{ $node->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <p class="text-muted small">Default to this host when adding databases to a server on this node.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style="margin-bottom: 15px; text-align: left;">
                        <p class="small text-danger" style="line-height: 1.5;">
                            The account defined for this host <strong>must</strong> have the <code>WITH GRANT OPTION</code> permission. Do not use the same account details as the panel itself.
                        </p>
                    </div>
                    {!! csrf_field() !!}
                    <button type="button" class="btn-simple" data-dismiss="modal" style="float: left;">Cancel</button>
                    <button type="submit" class="btn-primary-theme">Create Host</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $('#pNodeId').select2();
    </script>
@endsection

