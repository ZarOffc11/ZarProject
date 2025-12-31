@extends('layouts.admin')

@section('title')
    Nests &rarr; {{ $nest->name }}
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
    
    /* UNIFIED HEADER (LEFT CARD) */
    .card-header-unified {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex; justify-content: space-between; align-items: center;
    }
    .header-title h1 { font-size: 20px; font-weight: 800; margin: 0; color: var(--text-main); letter-spacing: -0.5px; }
    .header-title small { display: block; font-size: 13px; color: var(--text-sub); margin-top: 4px; font-weight: 500; }

    /* STANDARD HEADER (RIGHT & BOTTOM CARDS) */
    .card-header-theme {
        padding: 15px 24px;
        border-bottom: 1px solid var(--border-color);
        font-weight: 700; font-size: 15px; display: flex; align-items: center; justify-content: space-between; gap: 8px; color: var(--text-main);
    }

    .card-body-theme { padding: 24px; }
    .card-footer-theme {
        padding: 15px 24px; background: var(--input-bg); border-top: 1px solid var(--border-color);
        display: flex; justify-content: space-between; align-items: center;
    }

    /* FORM INPUTS */
    .form-control {
        background: var(--input-bg) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important; border-radius: 10px !important; height: 42px; box-shadow: none !important;
    }
    textarea.form-control { height: auto !important; }
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    .form-control[readonly] { opacity: 0.7; cursor: not-allowed; }
    
    label { color: var(--text-main); font-weight: 600; font-size: 13px; margin-bottom: 6px; }
    .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }

    /* BUTTONS */
    .btn-primary-theme {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 8px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-primary-theme:hover { background: #374151; border-color: #374151; }

    .btn-danger-theme {
        background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;
        padding: 8px 16px; border-radius: 8px; font-weight: 600; transition: all 0.2s; display: inline-flex; align-items: center; gap: 5px;
    }
    .btn-danger-theme:hover { background: #b91c1c; color: #fff; border-color: #b91c1c; }

    .btn-simple {
        background: var(--btn-bg); color: var(--btn-text); border: 1px solid var(--btn-border);
        padding: 6px 12px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 5px; font-size: 13px;
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

    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; font-family: 'Menlo', monospace; }
    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    {{-- LEFT COLUMN: EDIT FORM --}}
    <div class="col-md-6">
        <form action="{{ route('admin.nests.view', $nest->id) }}" method="POST">
            <div class="theme-card">
                {{-- UNIFIED HEADER --}}
                <div class="card-header-unified">
                    <div class="header-title">
                        <h1>{{ $nest->name }}</h1>
                        <small>{{ str_limit($nest->description, 50) }}</small>
                    </div>
                    <span class="material-symbols-rounded" style="color: #6366f1; font-size: 28px;">edit_square</span>
                </div>

                <div class="card-body-theme">
                    <div class="form-group">
                        <label class="control-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $nest->name }}" />
                        <p class="text-muted small">Descriptive category name.</p>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Description</label>
                        <textarea name="description" class="form-control" rows="7">{{ $nest->description }}</textarea>
                    </div>
                </div>

                <div class="card-footer-theme">
                    {{-- DELETE BUTTON --}}
                    <div>
                        <button id="deleteButton" type="submit" name="_method" value="DELETE" class="btn-danger-theme" onclick="return confirm('Are you sure you want to delete this nest?')">
                            <span class="material-symbols-rounded">delete</span> Delete
                        </button>
                    </div>
                    
                    {{-- SAVE BUTTON --}}
                    <div>
                        {!! csrf_field() !!}
                        <button type="submit" name="_method" value="PATCH" class="btn-primary-theme">Save Changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- RIGHT COLUMN: INFO --}}
    <div class="col-md-6">
        <div class="theme-card">
            <div class="card-header-theme">
                <span style="display:flex; align-items:center; gap:5px;"><span class="material-symbols-rounded" style="color: #6366f1;">info</span> Information</span>
            </div>
            <div class="card-body-theme">
                <div class="form-group">
                    <label class="control-label">Nest ID</label>
                    <input type="text" readonly class="form-control" value="{{ $nest->id }}" />
                    <p class="text-muted small">Internal ID used for API.</p>
                </div>

                <div class="form-group">
                    <label class="control-label">Author</label>
                    <input type="text" readonly class="form-control" value="{{ $nest->author }}" />
                    <p class="text-muted small">Author email of this service option.</p>
                </div>

                <div class="form-group">
                    <label class="control-label">UUID</label>
                    <input type="text" readonly class="form-control" value="{{ $nest->uuid }}" />
                    <p class="text-muted small">Unique Identifier for this Nest.</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- BOTTOM ROW: EGGS LIST --}}
<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            <div class="card-header-theme">
                <span style="display:flex; align-items:center; gap:5px;"><span class="material-symbols-rounded" style="color: #6366f1;">egg</span> Nest Eggs</span>
                <a href="{{ route('admin.nests.egg.new') }}" class="btn-simple">
                    <span class="material-symbols-rounded">add</span> New Egg
                </a>
            </div>

            <div class="table-responsive">
                <table class="theme-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="text-center">Servers</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nest->eggs as $egg)
                            <tr>
                                <td><code>{{ $egg->id }}</code></td>
                                <td>
                                    <a href="{{ route('admin.nests.egg.view', $egg->id) }}" style="font-weight: 600; color: #6366f1; text-decoration: none;" data-toggle="tooltip" data-placement="right" title="{{ $egg->author }}">
                                        {{ $egg->name }}
                                    </a>
                                </td>
                                <td class="col-xs-8" style="color: var(--text-sub);">{{ $egg->description }}</td>
                                <td class="text-center"><code>{{ $egg->servers->count() }}</code></td>
                                <td class="text-center">
                                    <a href="{{ route('admin.nests.egg.export', ['egg' => $egg->id]) }}" class="btn-simple" title="Export Egg">
                                        <span class="material-symbols-rounded">download</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    {{-- Script hover effect dihapus karena sudah diganti style button modern --}}
@endsection

