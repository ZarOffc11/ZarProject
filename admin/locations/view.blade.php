@extends('layouts.admin')

@section('title')
    Locations &rarr; View &rarr; {{ $location->short }}
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

    /* HEADER STYLE (UNIFIED) - Card Kiri */
    .card-header-unified {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex; justify-content: space-between; align-items: center;
        height: 85px; /* Samakan tinggi dengan kanan jika perlu, atau biarkan auto */
    }
    .header-title h1 { font-size: 20px; font-weight: 800; margin: 0; color: var(--text-main); letter-spacing: -0.5px; }
    .header-title small { display: block; font-size: 13px; color: var(--text-sub); margin-top: 4px; font-weight: 500; }

    /* HEADER STYLE (STANDARD) - Card Kanan */
    .card-header-theme {
        padding: 15px 24px;
        border-bottom: 1px solid var(--border-color);
        font-weight: 700; font-size: 15px; display: flex; align-items: center; gap: 8px; color: var(--text-main);
        height: 85px; /* Samakan tinggi */
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
    textarea.form-control { height: auto !important; }
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }

    /* BUTTONS */
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

    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; }
    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    {{-- LEFT COLUMN: LOCATION DETAILS --}}
    <div class="col-sm-6">
        <form action="{{ route('admin.locations.view', $location->id) }}" method="POST">
            <div class="theme-card">
                {{-- UNIFIED HEADER --}}
                <div class="card-header-unified">
                    <div class="header-title">
                        <h1>{{ $location->short }}</h1>
                        <small>{{ str_limit($location->long, 60) }}</small>
                    </div>
                    <div>
                        <span class="material-symbols-rounded" style="color: #6366f1; font-size: 28px;">near_me</span>
                    </div>
                </div>

                <div class="card-body-theme">
                    <div class="form-group">
                        <label for="pShort" class="form-label">Short Code</label>
                        <input type="text" id="pShort" name="short" class="form-control" value="{{ $location->short }}" />
                    </div>
                    <div class="form-group">
                        <label for="pLong" class="form-label">Description</label>
                        <textarea id="pLong" name="long" class="form-control" rows="4">{{ $location->long }}</textarea>
                    </div>
                </div>

                <div class="card-footer-theme">
                    {!! csrf_field() !!}
                    {!! method_field('PATCH') !!}
                    <button name="action" value="delete" class="btn-danger-theme" onclick="return confirm('Are you sure you want to delete this location? All nodes must be removed first.')">
                        <span class="material-symbols-rounded">delete</span>
                    </button>
                    <button name="action" value="edit" class="btn-primary-theme">Save Changes</button>
                </div>
            </div>
        </form>
    </div>

    {{-- RIGHT COLUMN: ASSOCIATED NODES --}}
    <div class="col-sm-6">
        <div class="theme-card">
            <div class="card-header-theme">
                <span class="material-symbols-rounded" style="color: #6366f1;">hub</span> Nodes at this Location
            </div>
            
            <div class="table-responsive">
                <table class="theme-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>FQDN</th>
                            <th>Servers</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($location->nodes as $node)
                            <tr>
                                <td><code>{{ $node->id }}</code></td>
                                <td>
                                    <a href="{{ route('admin.nodes.view', $node->id) }}" style="font-weight: 600; color: #6366f1; text-decoration: none;">
                                        {{ $node->name }}
                                    </a>
                                </td>
                                <td><code>{{ $node->fqdn }}</code></td>
                                <td>{{ $node->servers->count() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($location->nodes->isEmpty())
                <div style="padding: 20px; text-align: center; color: var(--text-sub); font-size: 13px;">
                    No nodes assigned to this location.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

