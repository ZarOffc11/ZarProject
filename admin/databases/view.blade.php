@extends('layouts.admin')

@section('title')
    {{ $host->name }}
@endsection

{{-- KOSONGKAN HEADER BAWAAN --}}
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
    
    /* HILANGKAN TOTAL HEADER BAWAAN (GAP HILANG) */
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

    /* HEADER STYLE (UNIFIED) - Untuk Card Utama */
    .card-header-unified {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex; justify-content: space-between; align-items: center;
    }
    .header-title h1 { font-size: 20px; font-weight: 800; margin: 0; color: var(--text-main); letter-spacing: -0.5px; }
    .header-title small { display: block; font-size: 13px; color: var(--text-sub); margin-top: 4px; font-weight: 500; }

    /* HEADER STYLE (STANDARD) - Untuk Card Biasa */
    .card-header-theme {
        padding: 15px 24px;
        border-bottom: 1px solid var(--border-color);
        font-weight: 700; font-size: 15px; display: flex; align-items: center; gap: 8px; color: var(--text-main);
        height: 85px; /* Menyamakan tinggi dengan header sebelah kiri */
    }

    .card-body-theme { padding: 24px; }
    .card-footer-theme {
        padding: 15px 24px; background: var(--input-bg); border-top: 1px solid var(--border-color);
        display: flex; justify-content: space-between; align-items: center;
    }

    /* FORM INPUTS */
    label { color: var(--text-main); font-weight: 600; font-size: 13px; margin-bottom: 6px; }
    .form-control {
        background: var(--input-bg) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important; border-radius: 10px !important; height: 42px; box-shadow: none !important;
    }
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    .help-block, .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }

    /* BUTTONS */
    .btn-simple {
        background: var(--btn-bg); color: var(--btn-text); border: 1px solid var(--btn-border);
        padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
        text-decoration: none !important; font-size: 13px;
    }
    .btn-simple:hover { background: var(--btn-hover); border-color: var(--text-main); }
    
    .btn-primary-theme {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 8px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-primary-theme:hover { background: #374151; border-color: #374151; }

    .btn-danger-theme {
        background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;
        padding: 8px 16px; border-radius: 8px; font-weight: 600; transition: all 0.2s; display: inline-flex; align-items: center;
    }
    .btn-danger-theme:hover { background: #b91c1c; color: #fff; border-color: #b91c1c; }

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

    /* SELECT2 FIX */
    .select2-container--default .select2-selection--single { background: var(--input-bg) !important; border: 1px solid var(--border-color) !important; height: 42px !important; border-radius: 10px !important; }
    .select2-selection__rendered { color: var(--text-main) !important; line-height: 40px !important; }
    .select2-selection__arrow { height: 40px !important; }
    .select2-dropdown { background: var(--bg-card) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; }

    /* ALERT BOX */
    .alert-warning-theme {
        background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3);
        color: #d97706; padding: 15px; border-radius: 10px; font-size: 13px; font-weight: 500;
        margin-top: 15px; line-height: 1.6;
    }
    body.dark-mode .alert-warning-theme { color: #fbbf24; }
    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; }

    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<form action="{{ route('admin.databases.view', $host->id) }}" method="POST">
    <div class="row">
        {{-- HOST DETAILS (SEKARANG JD UTAMA KARENA ADA TITLE) --}}
        <div class="col-sm-6">
            <div class="theme-card">
                {{-- HEADER MENYATU: TITLE ADA DI SINI --}}
                <div class="card-header-unified" style="height: 85px;">
                    <div class="header-title">
                        <h1>{{ $host->name }}</h1>
                        <small>Host Details Configuration</small>
                    </div>
                    <span class="material-symbols-rounded" style="color: #6366f1; font-size: 28px;">dns</span>
                </div>

                <div class="card-body-theme">
                    <div class="form-group">
                        <label for="pName" class="form-label">Name</label>
                        <input type="text" id="pName" name="name" class="form-control" value="{{ old('name', $host->name) }}" />
                    </div>
                    <div class="form-group">
                        <label for="pHost" class="form-label">Host</label>
                        <input type="text" id="pHost" name="host" class="form-control" value="{{ old('host', $host->host) }}" />
                        <p class="text-muted small">IP address or FQDN for panel connection.</p>
                    </div>
                    <div class="form-group">
                        <label for="pPort" class="form-label">Port</label>
                        <input type="text" id="pPort" name="port" class="form-control" value="{{ old('port', $host->port) }}" />
                        <p class="text-muted small">Port MySQL is running on.</p>
                    </div>
                    <div class="form-group">
                        <label for="pNodeId" class="form-label">Linked Node</label>
                        <select name="node_id" id="pNodeId" class="form-control">
                            <option value="">None</option>
                            @foreach($locations as $location)
                                <optgroup label="{{ $location->short }}">
                                    @foreach($location->nodes as $node)
                                        <option value="{{ $node->id }}" {{ $host->node_id !== $node->id ?: 'selected' }}>{{ $node->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <p class="text-muted small">Defaults to this host when adding databases to a server on this node.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- USER DETAILS --}}
        <div class="col-sm-6">
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">person</span> User Details
                </div>
                <div class="card-body-theme">
                    <div class="form-group">
                        <label for="pUsername" class="form-label">Username</label>
                        <input type="text" name="username" id="pUsername" class="form-control" value="{{ old('username', $host->username) }}" />
                        <p class="text-muted small">Account with enough permissions to create users/databases.</p>
                    </div>
                    <div class="form-group">
                        <label for="pPassword" class="form-label">Password</label>
                        <input type="password" name="password" id="pPassword" class="form-control" />
                        <p class="text-muted small">Leave blank to continue using the assigned password.</p>
                    </div>
                    
                    <div class="alert-warning-theme">
                        <span class="material-symbols-rounded" style="vertical-align:bottom; margin-right:5px;">warning</span>
                        The account defined <strong>must</strong> have the <code>WITH GRANT OPTION</code> permission. Do not use the same account details as the panel itself.
                    </div>
                </div>
                <div class="card-footer-theme">
                    {!! csrf_field() !!}
                    <button name="_method" value="DELETE" class="btn-danger-theme" onclick="return confirm('Are you sure you want to delete this host?')">
                        <span class="material-symbols-rounded">delete</span>
                    </button>
                    <button name="_method" value="PATCH" class="btn-primary-theme">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- DATABASE LIST --}}
<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            <div class="card-header-theme" style="height: auto;">
                <span class="material-symbols-rounded" style="color: #6366f1;">database</span> Databases
            </div>
            <div class="table-responsive">
                <table class="theme-table">
                    <thead>
                        <tr>
                            <th>Server</th>
                            <th>Database Name</th>
                            <th>Username</th>
                            <th>Connections From</th>
                            <th>Max Connections</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($databases as $database)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.servers.view', $database->getRelation('server')->id) }}" style="color: #6366f1; font-weight:600; text-decoration:none;">
                                        {{ $database->getRelation('server')->name }}
                                    </a>
                                </td>
                                <td>{{ $database->database }}</td>
                                <td>{{ $database->username }}</td>
                                <td>{{ $database->remote }}</td>
                                <td>
                                    @if($database->max_connections != null)
                                        {{ $database->max_connections }}
                                    @else
                                        <span class="label-default">Unlimited</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.servers.view.database', $database->getRelation('server')->id) }}" class="btn-simple" style="padding: 4px 10px; font-size: 12px;">
                                        Manage
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($databases->hasPages())
                <div class="card-footer-theme" style="justify-content: center;">
                    {!! $databases->render() !!}
                </div>
            @endif
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

