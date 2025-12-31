@extends('layouts.admin')
@include('partials/admin.settings.nav', ['activeTab' => 'advanced'])

@section('title')
    Advanced Settings
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
        display: flex; justify-content: flex-end; gap: 10px;
    }

    /* SECTION SEPARATOR */
    .section-head {
        display: flex; align-items: center; gap: 8px;
        font-size: 15px; font-weight: 700; color: var(--text-main);
        margin-bottom: 15px;
    }
    .section-divider { border-top: 1px solid var(--border-color); margin: 30px 0; }

    /* FORM INPUTS */
    label { color: var(--text-main); font-weight: 600; font-size: 13px; margin-bottom: 6px; }
    .form-control {
        background: var(--input-bg) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important; border-radius: 10px !important; height: 42px; box-shadow: none !important;
    }
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    .help-block, .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }

    /* ALERT BOX */
    .alert-warning-theme {
        background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3);
        color: #d97706; padding: 15px; border-radius: 10px; font-size: 14px; font-weight: 500;
        margin-top: 15px;
    }
    body.dark-mode .alert-warning-theme { color: #fbbf24; }

    /* BUTTONS */
    .btn-primary-theme {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 10px 24px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-primary-theme:hover { background: #374151; border-color: #374151; }

    .material-symbols-rounded { font-size: 20px; }
</style>

    @yield('settings::nav')

    <div class="row">
        <div class="col-xs-12">
            <form action="" method="POST">
                <div class="theme-card">
                    {{-- HEADER --}}
                    <div class="card-header-unified">
                        <div class="header-title">
                            <h1>Advanced Settings</h1>
                            <small>Configure advanced system behaviors.</small>
                        </div>
                        <div>
                            <span class="material-symbols-rounded" style="color: #6366f1; font-size: 28px;">construction</span>
                        </div>
                    </div>

                    <div class="card-body-theme">
                        
                        {{-- SECTION 1: reCAPTCHA --}}
                        <div class="section-head">
                            <span class="material-symbols-rounded" style="color: #6366f1;">security</span> reCAPTCHA
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Status</label>
                                <div>
                                    <select class="form-control" name="recaptcha:enabled">
                                        <option value="true">Enabled</option>
                                        <option value="false" @if(old('recaptcha:enabled', config('recaptcha.enabled')) == '0') selected @endif>Disabled</option>
                                    </select>
                                    <p class="text-muted small">Enable silent captcha for login/reset forms.</p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Site Key</label>
                                <div>
                                    <input type="text" required class="form-control" name="recaptcha:website_key" value="{{ old('recaptcha:website_key', config('recaptcha.website_key')) }}">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Secret Key</label>
                                <div>
                                    <input type="text" required class="form-control" name="recaptcha:secret_key" value="{{ old('recaptcha:secret_key', config('recaptcha.secret_key')) }}">
                                    <p class="text-muted small">Communication key between site and Google.</p>
                                </div>
                            </div>
                        </div>

                        @if($showRecaptchaWarning)
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="alert-warning-theme">
                                        <span class="material-symbols-rounded" style="vertical-align:bottom; margin-right:5px;">warning</span>
                                        You are using default reCAPTCHA keys. It is recommended to <a href="https://www.google.com/recaptcha/admin" target="_blank" style="color:inherit; text-decoration:underline;">generate new keys</a> for better security.
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="section-divider"></div>

                        {{-- SECTION 2: HTTP Connections --}}
                        <div class="section-head">
                            <span class="material-symbols-rounded" style="color: #6366f1;">dns</span> HTTP Connections
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Connection Timeout (Seconds)</label>
                                <div>
                                    <input type="number" required class="form-control" name="pterodactyl:guzzle:connect_timeout" value="{{ old('pterodactyl:guzzle:connect_timeout', config('pterodactyl.guzzle.connect_timeout')) }}">
                                    <p class="text-muted small">Time to wait for connection to open.</p>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Request Timeout (Seconds)</label>
                                <div>
                                    <input type="number" required class="form-control" name="pterodactyl:guzzle:timeout" value="{{ old('pterodactyl:guzzle:timeout', config('pterodactyl.guzzle.timeout')) }}">
                                    <p class="text-muted small">Time to wait for request to complete.</p>
                                </div>
                            </div>
                        </div>

                        <div class="section-divider"></div>

                        {{-- SECTION 3: Auto Allocation --}}
                        <div class="section-head">
                            <span class="material-symbols-rounded" style="color: #6366f1;">auto_fix</span> Automatic Allocation Creation
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Status</label>
                                <div>
                                    <select class="form-control" name="pterodactyl:client_features:allocations:enabled">
                                        <option value="false">Disabled</option>
                                        <option value="true" @if(old('pterodactyl:client_features:allocations:enabled', config('pterodactyl.client_features.allocations.enabled'))) selected @endif>Enabled</option>
                                    </select>
                                    <p class="text-muted small">Allow users to create allocations via frontend.</p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Starting Port</label>
                                <div>
                                    <input type="number" class="form-control" name="pterodactyl:client_features:allocations:range_start" value="{{ old('pterodactyl:client_features:allocations:range_start', config('pterodactyl.client_features.allocations.range_start')) }}">
                                    <p class="text-muted small">Range start for auto-allocation.</p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Ending Port</label>
                                <div>
                                    <input type="number" class="form-control" name="pterodactyl:client_features:allocations:range_end" value="{{ old('pterodactyl:client_features:allocations:range_end', config('pterodactyl.client_features.allocations.range_end')) }}">
                                    <p class="text-muted small">Range end for auto-allocation.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="card-footer-theme">
                        {{ csrf_field() }}
                        <button type="submit" name="_method" value="PATCH" class="btn-primary-theme">Save Settings</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

