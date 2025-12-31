@extends('layouts.admin')

@section('title')
    Locations
@endsection

{{-- HEADER BAWAAN DIKOSONGKAN --}}
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
    .content-header { display: none !important; } /* Hilangkan gap header */
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

    /* HEADER STYLE (UNIFIED) */
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

    /* BUTTONS */
    .btn-simple {
        background: var(--btn-bg); color: var(--btn-text); border: 1px solid var(--btn-border);
        padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
        text-decoration: none !important; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-simple:hover { background: var(--btn-hover); border-color: var(--text-main); }
    
    .btn-primary-theme {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 8px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-primary-theme:hover { background: #374151; border-color: #374151; }

    /* MODAL STYLING (DARK MODE SUPPORT) */
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
    textarea.form-control { height: auto !important; }
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    label { color: var(--text-main); font-weight: 600; font-size: 13px; margin-bottom: 6px; }
    .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }

    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; }
    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            {{-- HEADER UNIFIED --}}
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>Locations</h1>
                    <small>Manage location categorizations.</small>
                </div>
                <div>
                    <button class="btn-simple" data-toggle="modal" data-target="#newLocationModal">
                        <span class="material-symbols-rounded">add_circle</span> Create New
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="theme-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Short Code</th>
                            <th>Description</th>
                            <th class="text-center">Nodes</th>
                            <th class="text-center">Servers</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($locations as $location)
                            <tr>
                                <td><code>{{ $location->id }}</code></td>
                                <td>
                                    <a href="{{ route('admin.locations.view', $location->id) }}" style="font-weight: 600; color: #6366f1; text-decoration: none;">
                                        {{ $location->short }}
                                    </a>
                                </td>
                                <td>{{ $location->long }}</td>
                                <td class="text-center">{{ $location->nodes_count }}</td>
                                <td class="text-center">{{ $location->servers_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL CREATE LOCATION --}}
<div class="modal fade" id="newLocationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.locations') }}" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create Location</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pShortModal" class="form-label">Short Code</label>
                                <input type="text" name="short" id="pShortModal" class="form-control" placeholder="e.g. us.nyc.lvl3" />
                                <p class="text-muted small">A short identifier used to distinguish this location.</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pLongModal" class="form-label">Description</label>
                                <textarea name="long" id="pLongModal" class="form-control" rows="4" placeholder="e.g. Data center in New York City..."></textarea>
                                <p class="text-muted small">A longer description of this location.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! csrf_field() !!}
                    <button type="button" class="btn-simple" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-theme">Create Location</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

