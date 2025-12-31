@extends('layouts.admin')

@section('title')
    Manager User: {{ $user->username }}
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
    
    /* UNIFIED HEADER */
    .card-header-unified {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex; justify-content: space-between; align-items: center;
    }
    .header-title h1 { font-size: 20px; font-weight: 800; margin: 0; color: var(--text-main); letter-spacing: -0.5px; }
    .header-title small { display: block; font-size: 13px; color: var(--text-sub); margin-top: 4px; font-weight: 500; }

    /* SUB-HEADER */
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

    .btn-danger-theme {
        background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;
        padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-danger-theme:hover { background: #b91c1c; color: #fff; border-color: #b91c1c; }
    .btn-danger-theme:disabled { opacity: 0.5; cursor: not-allowed; }

    /* ALERTS */
    .alert-success-theme {
        background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3);
        color: #10b981; padding: 10px; border-radius: 8px; font-size: 13px; margin-bottom: 15px;
    }

    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            {{-- UNIFIED HEADER --}}
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>{{ $user->name_first }} {{ $user->name_last}}</h1>
                    <small>{{ $user->username }}</small>
                </div>
                <span class="material-symbols-rounded" style="color: #6366f1; font-size: 30px;">badge</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <form action="{{ route('admin.users.view', $user->id) }}" method="post">
        {{-- LEFT COLUMN: IDENTITY --}}
        <div class="col-md-6">
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">person</span> Identity
                </div>
                <div class="card-body-theme">
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control form-autocomplete-stop">
                    </div>
                    <div class="form-group">
                        <label for="username" class="control-label">Username</label>
                        <input type="text" name="username" value="{{ $user->username }}" class="form-control form-autocomplete-stop">
                    </div>
                    <div class="form-group">
                        <label for="name_first" class="control-label">First Name</label>
                        <input type="text" name="name_first" value="{{ $user->name_first }}" class="form-control form-autocomplete-stop">
                    </div>
                    <div class="form-group">
                        <label for="name_last" class="control-label">Last Name</label>
                        <input type="text" name="name_last" value="{{ $user->name_last }}" class="form-control form-autocomplete-stop">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Default Language</label>
                        <select name="language" class="form-control">
                            @foreach($languages as $key => $value)
                                <option value="{{ $key }}" @if($user->language === $key) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        <p class="text-muted small">Default language for this user's panel.</p>
                    </div>
                </div>
                <div class="card-footer-theme">
                    {!! csrf_field() !!}
                    {!! method_field('PATCH') !!}
                    <button type="submit" class="btn-primary-theme">Update User</button>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: PASSWORD & PERMISSIONS --}}
        <div class="col-md-6">
            {{-- PASSWORD --}}
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">lock</span> Password
                </div>
                <div class="card-body-theme">
                    <div class="alert-success-theme" style="display:none;" id="gen_pass"></div>
                    
                    <div class="form-group no-margin-bottom">
                        <label for="password" class="control-label">Password</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="password" id="password" name="password" class="form-control form-autocomplete-stop">
                            <button type="button" id="gen_pass_bttn" class="btn-simple" style="white-space: nowrap;">
                                <span class="material-symbols-rounded" style="font-size: 16px;">autorenew</span> Gen
                            </button>
                        </div>
                        <p class="text-muted small">Leave blank to keep existing password.</p>
                    </div>
                </div>
            </div>

            {{-- PERMISSIONS --}}
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">shield</span> Permissions
                </div>
                <div class="card-body-theme">
                    <div class="form-group" style="margin-bottom:0;">
                        <label for="root_admin" class="control-label">Administrator</label>
                        <select name="root_admin" class="form-control">
                            <option value="0">@lang('strings.no')</option>
                            <option value="1" {{ $user->root_admin ? 'selected="selected"' : '' }}>@lang('strings.yes')</option>
                        </select>
                        <p class="text-muted small">Grant full administrative access?</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- DELETE USER SECTION --}}
<div class="row">
    <div class="col-xs-12">
        <div class="theme-card" style="border-color: #fca5a5;">
            <div class="card-header-theme" style="color: #b91c1c; border-bottom-color: #fca5a5; background: #fef2f2;">
                <span class="material-symbols-rounded">warning</span> Delete User
            </div>
            <div class="card-body-theme">
                <p style="color: var(--text-main); margin: 0; line-height: 1.6;">
                    There must be <strong>no servers</strong> associated with this account in order for it to be deleted.
                </p>
            </div>
            <div class="card-footer-theme" style="background: #fff1f2; border-top-color: #fca5a5;">
                <form action="{{ route('admin.users.view', $user->id) }}" method="POST">
                    {!! csrf_field() !!}
                    {!! method_field('DELETE') !!}
                    <button id="delete" type="submit" class="btn-danger-theme" {{ $user->servers->count() < 1 ?: 'disabled' }}>
                        Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $("#gen_pass_bttn").click(function (event) {
            event.preventDefault();
            $(this).find('span').addClass('spin-anim');
            
            $.ajax({
                type: "GET",
                url: "/password-gen/12",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function(data) {
                    $("#gen_pass").html('<strong>Generated Password:</strong> ' + data).slideDown();
                    $('input[name="password"]').val(data);
                    $("#gen_pass_bttn").find('span').removeClass('spin-anim');
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

