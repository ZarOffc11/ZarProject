@extends('layouts.admin')

@section('title')
    Create User
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

    .card-header-theme {
        padding: 15px 24px;
        border-bottom: 1px solid var(--border-color);
        font-weight: 700; font-size: 15px; display: flex; align-items: center; gap: 8px; color: var(--text-main);
    }

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
    .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }

    /* ALERTS */
    .alert-info-theme {
        background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3);
        color: #3b82f6; padding: 15px; border-radius: 10px; font-size: 13px; margin-bottom: 15px; line-height: 1.5;
    }
    .alert-success-theme {
        background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3);
        color: #10b981; padding: 10px; border-radius: 8px; font-size: 13px; margin-bottom: 15px;
    }

    /* BUTTONS */
    .btn-primary-theme {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-primary-theme:hover { background: #374151; border-color: #374151; }

    .btn-simple {
        background: var(--btn-bg); color: var(--btn-text); border: 1px solid var(--border-color);
        padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-size: 12px;
    }
    .btn-simple:hover { background: var(--btn-hover); border-color: var(--text-main); }

    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            {{-- UNIFIED HEADER --}}
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>Create User</h1>
                    <small>Add a new user to the system.</small>
                </div>
                <span class="material-symbols-rounded" style="color: #6366f1; font-size: 30px;">person_add</span>
            </div>
        </div>
    </div>
</div>

<form method="post">
    <div class="row">
        {{-- LEFT COLUMN: IDENTITY --}}
        <div class="col-md-6">
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">badge</span> Identity
                </div>
                <div class="card-body-theme">
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="text" autocomplete="off" name="email" value="{{ old('email') }}" class="form-control" placeholder="client@example.com"/>
                    </div>
                    <div class="form-group">
                        <label for="username" class="control-label">Username</label>
                        <input type="text" autocomplete="off" name="username" value="{{ old('username') }}" class="form-control" placeholder="client123"/>
                    </div>
                    <div class="form-group">
                        <label for="name_first" class="control-label">First Name</label>
                        <input type="text" autocomplete="off" name="name_first" value="{{ old('name_first') }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="name_last" class="control-label">Last Name</label>
                        <input type="text" autocomplete="off" name="name_last" value="{{ old('name_last') }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Default Language</label>
                        <select name="language" class="form-control">
                            @foreach($languages as $key => $value)
                                <option value="{{ $key }}" @if(config('app.locale') === $key) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        <p class="text-muted small">Default language for this user's panel.</p>
                    </div>
                </div>
                <div class="card-footer-theme">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn-primary-theme">Create User</button>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: PERMISSIONS & PASSWORD --}}
        <div class="col-md-6">
            {{-- PERMISSIONS --}}
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">shield</span> Permissions
                </div>
                <div class="card-body-theme">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="root_admin" class="control-label">Administrator</label>
                        <select name="root_admin" class="form-control">
                            <option value="0">@lang('strings.no')</option>
                            <option value="1">@lang('strings.yes')</option>
                        </select>
                        <p class="text-muted small">Setting this to 'Yes' gives full administrative access.</p>
                    </div>
                </div>
            </div>

            {{-- PASSWORD --}}
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">lock</span> Password
                </div>
                <div class="card-body-theme">
                    <div class="alert-info-theme">
                        <div style="display:flex; gap:10px;">
                            <span class="material-symbols-rounded">info</span>
                            <div>
                                Optional. Users will be emailed to create a password if left blank.
                            </div>
                        </div>
                    </div>

                    {{-- Generated Password Display --}}
                    <div id="gen_pass" class="alert-success-theme" style="display:none;"></div>

                    <div class="form-group">
                        <label for="pass" class="control-label">Password</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="password" name="password" class="form-control" style="flex-grow: 1;" />
                            <button type="button" id="gen_pass_bttn" class="btn-simple" style="white-space: nowrap;">
                                <span class="material-symbols-rounded" style="font-size: 16px;">autorenew</span> Gen
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $("#gen_pass_bttn").click(function (event) {
            event.preventDefault();
            // Efek Loading
            $(this).find('span').addClass('spin-anim');
            
            $.ajax({
                type: "GET",
                url: "/password-gen/12",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
               },
                success: function(data) {
                    $("#gen_pass").html('<strong>Generated Password:</strong> ' + data).slideDown();
                    $('input[name="password"], input[name="password_confirmation"]').val(data);
                    $("#gen_pass_bttn").find('span').removeClass('spin-anim'); // Stop loading
                    return false;
                }
            });
            return false;
        });
    </script>
    <style>
        .spin-anim { animation: spin 1s linear infinite; }
        @keyframes spin { 100% { transform: rotate(360deg); } }
    </style>
@endsection

