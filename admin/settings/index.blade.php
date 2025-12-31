@extends('layouts.admin')
@include('partials/admin.settings.nav', ['activeTab' => 'basic'])

@section('title')
    Settings
@endsection

{{-- HEADER LUAR DIKOSONGKAN --}}
@section('content-header')
@endsection

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<style>
    /* LOCAL VARS */
    :root {
        --btn-bg: #ffffff; --btn-text: #1f2937; --btn-border: #d1d5db; --btn-hover: #f3f4f6;
    }
    body.dark-mode {
        --btn-bg: #1b1e24; --btn-text: #e2e8f0; --btn-border: #4a5568; --btn-hover: #2d3748;
    }

    .content { padding-top: 10px !important; }

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

    /* HEADER MENYATU (UNIFIED) */
    .card-header-unified {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .header-title h1 { font-size: 20px; font-weight: 800; margin: 0; color: var(--text-main); letter-spacing: -0.5px; }
    .header-title small { display: block; font-size: 13px; color: var(--text-sub); margin-top: 4px; font-weight: 500; }

    .card-body-theme { padding: 24px; }
    .card-footer-theme {
        padding: 15px 24px; background: var(--input-bg); border-top: 1px solid var(--border-color);
        display: flex; justify-content: flex-end;
    }

    /* FORM INPUTS */
    label { color: var(--text-main); font-weight: 600; font-size: 13px; margin-bottom: 6px; }
    .form-control {
        background: var(--input-bg) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important; border-radius: 10px !important; height: 42px; box-shadow: none !important;
    }
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    .help-block, .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }

    /* 2FA BUTTON GROUP */
    .btn-group { display: flex; width: 100%; border-radius: 10px; overflow: hidden; border: 1px solid var(--border-color); }
    .btn-group .btn {
        flex: 1; background: var(--input-bg); color: var(--text-sub); border: none; border-right: 1px solid var(--border-color);
        padding: 10px; font-weight: 600; font-size: 13px; transition: all 0.2s; border-radius: 0; display:flex; align-items:center; justify-content:center;
    }
    .btn-group .btn:last-child { border-right: none; }
    .btn-group .btn.active {
        background: #1f2937; color: #fff; box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);
    }
    body.dark-mode .btn-group .btn.active { background: #6366f1; color: #fff; }

    /* SAVE BUTTON */
    .btn-simple {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 10px 24px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.2s;
        text-decoration: none !important; font-size: 13px;
    }
    .btn-simple:hover { background: #374151; border-color: #374151; }

    .material-symbols-rounded { font-size: 18px; }
</style>

    {{-- Render Tabs --}}
    @yield('settings::nav')

    <div class="row">
        <div class="col-xs-12">
            <form action="{{ route('admin.settings') }}" method="POST">
                <div class="theme-card">
                    
                    {{-- JUDUL HALAMAN SEKARANG ADA DI SINI (DALAM CARD) --}}
                    <div class="card-header-unified">
                        <div class="header-title">
                            <h1>Panel Settings</h1>
                            <small>Configure Pterodactyl to your liking.</small>
                        </div>
                        {{-- Ikon Dekorasi (Opsional) --}}
                        <div>
                            <span class="material-symbols-rounded" style="color: #6366f1; font-size: 28px;">tune</span>
                        </div>
                    </div>
                    
                    <div class="card-body-theme">
                        <div class="row">
                            {{-- Company Name --}}
                            <div class="form-group col-md-4">
                                <label class="control-label">Company Name</label>
                                <div>
                                    <input type="text" class="form-control" name="app:name" value="{{ old('app:name', config('app.name')) }}" />
                                    <p class="text-muted"><small>Used in emails and panel title.</small></p>
                                </div>
                            </div>

                            {{-- 2FA Requirement --}}
                            <div class="form-group col-md-4">
                                <label class="control-label">Require 2-Factor Auth</label>
                                <div>
                                    <div class="btn-group" data-toggle="buttons">
                                        @php
                                            $level = old('pterodactyl:auth:2fa_required', config('pterodactyl.auth.2fa_required'));
                                        @endphp
                                        <label class="btn @if ($level == 0) active @endif">
                                            <input type="radio" name="pterodactyl:auth:2fa_required" autocomplete="off" value="0" @if ($level == 0) checked @endif> None
                                        </label>
                                        <label class="btn @if ($level == 1) active @endif">
                                            <input type="radio" name="pterodactyl:auth:2fa_required" autocomplete="off" value="1" @if ($level == 1) checked @endif> Admin
                                        </label>
                                        <label class="btn @if ($level == 2) active @endif">
                                            <input type="radio" name="pterodactyl:auth:2fa_required" autocomplete="off" value="2" @if ($level == 2) checked @endif> All Users
                                        </label>
                                    </div>
                                    <p class="text-muted"><small>Force 2FA for selected group.</small></p>
                                </div>
                            </div>

                            {{-- Language --}}
                            <div class="form-group col-md-4">
                                <label class="control-label">Default Language</label>
                                <div>
                                    <select name="app:locale" class="form-control">
                                        @foreach($languages as $key => $value)
                                            <option value="{{ $key }}" @if(config('app.locale') === $key) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-muted"><small>Default UI language.</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer-theme">
                        {!! csrf_field() !!}
                        <button type="submit" name="_method" value="PATCH" class="btn-simple">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

