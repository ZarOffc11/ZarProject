@extends('layouts.admin')

@section('title')
    {{ $server->name }}: Details
@endsection

@section('content-header')
@endsection

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<style>
    /* === THEME VARIABLES (SAMA DENGAN VIEW & INDEX) === */
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

    /* GLOBAL */
    .content-wrapper, body, .wrapper { background-color: var(--bg-app) !important; color: var(--text-main) !important; transition: all 0.3s; }
    .content-header { padding: 0 !important; margin-bottom: 15px !important; background: transparent !important; border: none !important; height: auto !important; }
    .header-compact { display: flex; align-items: center; padding-top: 5px; }
    .page-title { font-size: 24px; font-weight: 800; color: var(--text-main); margin: 0; line-height: 1.2; letter-spacing: -0.5px; }
    .page-title small { color: var(--text-sub); font-size: 14px; margin-left: 10px; font-weight: 400; }

    /* CARD STYLE */
    .theme-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        margin-bottom: 20px;
        overflow: hidden;
    }
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
    textarea.form-control { height: auto !important; }
    .help-block, .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }
    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; }

    /* SELECT2 CUSTOMIZATION */
    .select2-selection--single { background: var(--input-bg) !important; border: 1px solid var(--border-color) !important; height: 42px !important; border-radius: 10px !important; }
    .select2-selection__rendered { color: var(--text-main) !important; line-height: 40px !important; }
    .select2-selection__arrow { height: 40px !important; }
    .select2-dropdown { background: var(--bg-card) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; }
    /* User Dropdown Item Style */
    .user-block { color: var(--text-main) !important; }
    .user-block .username a { color: var(--text-main) !important; font-weight: 600; }
    .user-block .description { color: var(--text-sub) !important; }

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

    .material-symbols-rounded { font-size: 18px; }
</style>

{{-- Theme Toggle Button (Pojok Kanan Atas) --}}
<div style="position: absolute; top: 15px; right: 15px; z-index: 99;">
    <button onclick="toggleTheme()" class="btn-simple">
        <span class="material-symbols-rounded" id="theme-icon">dark_mode</span> Theme
    </button>
</div>

@include('admin.servers.partials.navigation')

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            <div class="card-header-theme">
                <span class="material-symbols-rounded" style="color: #6366f1;">edit_note</span> Base Information
            </div>
            
            <form action="{{ route('admin.servers.view.details', $server->id) }}" method="POST">
                <div class="card-body-theme">
                    <div class="form-group">
                        <label for="name" class="control-label">Server Name</label>
                        <input type="text" name="name" value="{{ old('name', $server->name) }}" class="form-control" />
                        <p class="text-muted small">Character limits: <code>a-zA-Z0-9_-</code> and <code>[Space]</code>.</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="external_id" class="control-label">External Identifier</label>
                        <input type="text" name="external_id" value="{{ old('external_id', $server->external_id) }}" class="form-control" />
                        <p class="text-muted small">Leave empty to not assign an external identifier.</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="pUserId" class="control-label">Server Owner</label>
                        <select name="owner_id" class="form-control" id="pUserId">
                            <option value="{{ $server->owner_id }}" selected>{{ $server->user->email }}</option>
                        </select>
                        <p class="text-muted small">Changing owner will generate a new daemon security token.</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="description" class="control-label">Description</label>
                        <textarea name="description" rows="3" class="form-control">{{ old('description', $server->description) }}</textarea>
                        <p class="text-muted small">A brief description of this server.</p>
                    </div>
                </div>
                
                <div class="card-footer-theme">
                    {!! csrf_field() !!}
                    {!! method_field('PATCH') !!}
                    <button type="submit" class="btn-primary-theme">Update Details</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    // THEME LOGIC
    function applyTheme() {
        const theme = localStorage.getItem('admin_theme') || 'light';
        const icon = document.getElementById('theme-icon');
        if (theme === 'dark') {
            document.body.classList.add('dark-mode');
            if(icon) icon.innerText = 'light_mode';
        } else {
            document.body.classList.remove('dark-mode');
            if(icon) icon.innerText = 'dark_mode';
        }
    }
    function toggleTheme() {
        const isDark = document.body.classList.contains('dark-mode');
        localStorage.setItem('admin_theme', isDark ? 'light' : 'dark');
        applyTheme();
    }
    document.addEventListener('DOMContentLoaded', applyTheme);
    applyTheme();

    // SELECT2 LOGIC (ORIGINAL)
    function escapeHtml(str) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }

    $('#pUserId').select2({
        ajax: {
            url: '/admin/users/accounts.json',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    filter: { email: params.term },
                    page: params.page,
                };
            },
            processResults: function (data, params) {
                return { results: data };
            },
            cache: true,
        },
        escapeMarkup: function (markup) { return markup; },
        minimumInputLength: 2,
        templateResult: function (data) {
            if (data.loading) return escapeHtml(data.text);

            return '<div class="user-block"> \
                <img class="img-circle img-bordered-xs" src="https://www.gravatar.com/avatar/' + escapeHtml(data.md5) + '?s=120" alt="User Image"> \
                <span class="username"> \
                    <a href="#">' + escapeHtml(data.name_first) + ' ' + escapeHtml(data.name_last) +'</a> \
                </span> \
                <span class="description"><strong>' + escapeHtml(data.email) + '</strong> - ' + escapeHtml(data.username) + '</span> \
            </div>';
        },
        templateSelection: function (data) {
            if (typeof data.name_first === 'undefined') {
                data = {
                    md5: '{{ md5(strtolower($server->user->email)) }}',
                    name_first: '{{ $server->user->name_first }}',
                    name_last: '{{ $server->user->name_last }}',
                    email: '{{ $server->user->email }}',
                    id: {{ $server->owner_id }}
                };
            }

            return '<div> \
                <span> \
                    <img class="img-rounded img-bordered-xs" src="https://www.gravatar.com/avatar/' + escapeHtml(data.md5) + '?s=120" style="height:28px;margin-top:-4px;" alt="User Image"> \
                </span> \
                <span style="padding-left:5px;"> \
                    ' + escapeHtml(data.name_first) + ' ' + escapeHtml(data.name_last) + ' (<strong>' + escapeHtml(data.email) + '</strong>) \
                </span> \
            </div>';
        }
    });
    </script>
@endsection

