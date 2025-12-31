@extends('layouts.admin')

@section('title')
    Application API
@endsection

{{-- HEADER LUAR DIKOSONGKAN AGAR JUDUL TIDAK MENGAMBANG --}}
@section('content-header')
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
    .content-header { padding: 0 !important; margin-bottom: 0 !important; background: transparent !important; border: none !important; height: 0 !important; }

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
    
    /* HEADER MENYATU */
    .card-header-unified {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex; justify-content: space-between; align-items: center;
    }
    .header-title h1 { font-size: 20px; font-weight: 800; margin: 0; color: var(--text-main); letter-spacing: -0.5px; }
    .header-title small { display: block; font-size: 13px; color: var(--text-sub); margin-top: 4px; font-weight: 500; }

    .card-body-theme { padding: 24px; }
    .card-footer-theme {
        padding: 15px 24px; background: var(--input-bg); border-top: 1px solid var(--border-color);
        display: flex; justify-content: flex-end;
    }

    /* SECTION HEADER (Sub-judul di dalam card) */
    .section-label {
        font-weight: 700; font-size: 14px; color: var(--text-main); margin-bottom: 15px; 
        display: flex; align-items: center; gap: 8px; border-bottom: 1px dashed var(--border-color); padding-bottom: 10px;
    }

    /* FORM INPUTS */
    label { color: var(--text-main); font-weight: 600; font-size: 13px; margin-bottom: 6px; }
    .form-control {
        background: var(--input-bg) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important; border-radius: 10px !important; height: 42px; box-shadow: none !important;
    }
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    .text-muted { color: var(--text-sub) !important; font-size: 13px; line-height: 1.6; }

    /* PERMISSION TABLE */
    .table-permissions { width: 100%; border-collapse: collapse; }
    .table-permissions td {
        padding: 12px 10px;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-main);
        vertical-align: middle;
    }
    .table-permissions tr:last-child td { border-bottom: none; }
    .table-permissions tr:hover { background-color: var(--input-bg); }
    
    .permission-name { font-weight: 600; color: var(--text-main); width: 30%; font-size: 13px; }
    
    /* RADIO BUTTON */
    .radio-label {
        display: flex; align-items: center; gap: 6px; cursor: pointer; margin: 0; font-weight: 500; font-size: 13px; justify-content: center;
    }
    input[type="radio"] { margin: 0; cursor: pointer; accent-color: #6366f1; transform: scale(1.1); }

    /* BUTTONS */
    .btn-primary-theme {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 10px 24px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-primary-theme:hover { background: #374151; border-color: #374151; }

    .material-symbols-rounded { font-size: 20px; }
    
    /* Responsive Split */
    @media(min-width: 992px) {
        .col-divider { border-right: 1px solid var(--border-color); }
    }
    @media(max-width: 991px) {
        .mobile-spacer { margin-top: 30px; }
    }
</style>

    <div class="row">
        <div class="col-xs-12">
            <form method="POST" action="{{ route('admin.api.new') }}">
                
                {{-- SATU CARD BESAR PEMBUNGKUS UTAMA --}}
                <div class="theme-card">
                    
                    {{-- HEADER MENYATU --}}
                    <div class="card-header-unified">
                        <div class="header-title">
                            <h1>New Credentials</h1>
                            <small>Create a new application API key.</small>
                        </div>
                        <div>
                            <span class="material-symbols-rounded" style="color: #6366f1; font-size: 28px;">vpn_key</span>
                        </div>
                    </div>

                    <div class="card-body-theme">
                        <div class="row">
                            
                            {{-- LEFT SIDE: PERMISSIONS --}}
                            <div class="col-md-8 col-divider">
                                <div class="section-label">
                                    <span class="material-symbols-rounded">lock_open</span> Resources & Permissions
                                </div>
                                <div class="table-responsive">
                                    <table class="table-permissions">
                                        @foreach($resources as $resource)
                                            <tr>
                                                <td class="permission-name">{{ str_replace('_', ' ', title_case($resource)) }}</td>
                                                
                                                <td class="text-center">
                                                    <label class="radio-label" for="r_{{ $resource }}">
                                                        <input type="radio" id="r_{{ $resource }}" name="r_{{ $resource }}" value="{{ $permissions['r'] }}">
                                                        Read
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="radio-label" for="rw_{{ $resource }}">
                                                        <input type="radio" id="rw_{{ $resource }}" name="r_{{ $resource }}" value="{{ $permissions['rw'] }}">
                                                        Read &amp; Write
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="radio-label" for="n_{{ $resource }}">
                                                        <input type="radio" id="n_{{ $resource }}" name="r_{{ $resource }}" value="{{ $permissions['n'] }}" checked>
                                                        None
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>

                            {{-- RIGHT SIDE: DETAILS --}}
                            <div class="col-md-4 mobile-spacer">
                                <div class="section-label">
                                    <span class="material-symbols-rounded">description</span> Key Details
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label" for="memoField">Description</label>
                                    <input id="memoField" type="text" name="memo" class="form-control" placeholder="e.g. Billing System">
                                </div>
                                
                                <div style="background: var(--input-bg); padding: 15px; border-radius: 10px; border: 1px solid var(--border-color); margin-top: 20px;">
                                    <div style="display:flex; gap:10px; color: var(--text-sub);">
                                        <span class="material-symbols-rounded">info</span>
                                        <p class="text-muted" style="margin:0; font-size:12px;">
                                            Once created, you cannot edit these permissions. If you need changes later, you must create a new set of credentials.
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- FOOTER UNIFIED --}}
                    <div class="card-footer-theme">
                        {{ csrf_field() }}
                        <button type="submit" class="btn-primary-theme">Create Credentials</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    </script>
@endsection

