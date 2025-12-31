@extends('layouts.admin')

@section('title')
    Nests
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

    /* ALERT BOX */
    .alert-danger-theme {
        background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3);
        color: #ef4444; padding: 15px; border-radius: 12px; font-size: 13px; margin-bottom: 20px; line-height: 1.6;
    }
    .alert-danger-theme code { background: rgba(239, 68, 68, 0.15); color: #ef4444; border:none; }

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

    /* BUTTONS */
    .btn-simple {
        background: var(--btn-bg); color: var(--btn-text); border: 1px solid var(--btn-border);
        padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
        text-decoration: none !important; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-simple:hover { background: var(--btn-hover); border-color: var(--text-main); }
    
    .btn-primary-theme {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 8px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; text-decoration: none !important;
    }
    .btn-primary-theme:hover { background: #374151; border-color: #374151; color: #fff; }

    .btn-success-theme {
        background: #10b981; color: #fff; border: 1px solid #10b981;
        padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-success-theme:hover { background: #059669; border-color: #059669; color: #fff; }

    /* MODAL STYLING */
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
    .modal-title { font-weight: 700; font-size: 18px; margin: 0; }
    .modal-body { padding: 24px; background: var(--bg-card); color: var(--text-main); }
    .modal-footer {
        border-top: 1px solid var(--border-color);
        padding: 15px 24px;
        background: var(--input-bg);
        border-radius: 0 0 16px 16px;
        display: flex; justify-content: space-between;
    }
    .close { color: var(--text-sub); opacity: 0.7; text-shadow: none; }
    .close:hover { color: var(--text-main); opacity: 1; }

    /* FORM INPUTS */
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

    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; font-family: 'Menlo', monospace; }
    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    <div class="col-xs-12">
        {{-- WARNING ALERT --}}
        <div class="alert-danger-theme">
            <div style="display:flex; gap:10px; align-items:flex-start;">
                <span class="material-symbols-rounded" style="font-size: 20px; margin-top:2px;">warning</span>
                <div>
                    <strong>Caution Required:</strong> Modifying eggs incorrectly can cause servers to crash or become unresponsive. 
                    Please avoid editing default eggs provided by <code>support@pterodactyl.io</code> unless you are absolutely sure of what you are doing.
                </div>
            </div>
        </div>

        <div class="theme-card">
            {{-- UNIFIED HEADER --}}
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>Nests</h1>
                    <small>All nests currently available on this system.</small>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button class="btn-success-theme" data-toggle="modal" data-target="#importServiceOptionModal">
                        <span class="material-symbols-rounded">upload</span> Import Egg
                    </button>
                    <a href="{{ route('admin.nests.new') }}" class="btn-primary-theme">
                        <span class="material-symbols-rounded">add_circle</span> Create New
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="theme-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="text-center">Eggs</th>
                            <th class="text-center">Servers</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nests as $nest)
                            <tr>
                                <td class="middle"><code>{{ $nest->id }}</code></td>
                                <td class="middle">
                                    <a href="{{ route('admin.nests.view', $nest->id) }}" style="font-weight: 600; color: #6366f1; text-decoration: none;" data-toggle="tooltip" data-placement="right" title="{{ $nest->author }}">
                                        {{ $nest->name }}
                                    </a>
                                </td>
                                <td class="col-xs-6 middle" style="color: var(--text-sub);">{{ $nest->description }}</td>
                                <td class="text-center middle">{{ $nest->eggs_count }}</td>
                                <td class="text-center middle">{{ $nest->servers_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL IMPORT EGG --}}
<div class="modal fade" tabindex="-1" role="dialog" id="importServiceOptionModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Import an Egg</h4>
            </div>
            <form action="{{ route('admin.nests.egg.import') }}" enctype="multipart/form-data" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="pImportFile">Egg File</label>
                        <div>
                            <input id="pImportFile" type="file" name="import_file" class="form-control" accept="application/json" style="padding: 10px;" />
                            <p class="small text-muted">Select the <code>.json</code> file for the new egg.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="pImportToNest">Associated Nest</label>
                        <div>
                            <select id="pImportToNest" name="import_to_nest" class="form-control">
                                @foreach($nests as $nest)
                                   <option value="{{ $nest->id }}">{{ $nest->name }} &lt;{{ $nest->author }}&gt;</option>
                                @endforeach
                            </select>
                            <p class="small text-muted">Select the nest to associate this egg with.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{ csrf_field() }}
                    <button type="button" class="btn-simple" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-theme">Import Egg</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('#pImportToNest').select2();
        });
    </script>
@endsection

