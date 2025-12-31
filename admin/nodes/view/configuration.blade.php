@extends('layouts.admin')

@section('title')
    {{ $node->name }}: Configuration
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
        --code-bg: #1e293b; --code-text: #e2e8f0;
    }
    body.dark-mode {
        --bg-app: #121417; --bg-card: #1b1e24; --text-main: #e2e8f0; --text-sub: #94a3b8;
        --border-color: #2a2e36; --input-bg: #121417; --btn-bg: #1b1e24; --btn-text: #e2e8f0;
        --btn-border: #4a5568; --btn-hover: #2d3748; --badge-bg: #2a2e36;
        --code-bg: #0f172a; --code-text: #f1f5f9;
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
        color: var(--text-sub); font-size: 13px;
    }

    /* NAVIGATION PILLS */
    .nav-pills-modern {
        display: flex; gap: 10px; padding: 0 24px 20px 24px; list-style: none; margin: 0;
        border-bottom: 1px solid var(--border-color); overflow-x: auto;
    }
    .nav-pills-modern li a {
        display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px;
        border-radius: 8px; background: var(--input-bg); color: var(--text-sub);
        border: 1px solid var(--border-color); font-weight: 600; font-size: 13px; text-decoration: none; transition: all 0.2s; white-space: nowrap;
    }
    .nav-pills-modern li a:hover { background: var(--btn-hover); color: var(--text-main); }
    .nav-pills-modern li.active a { background: #1f2937; color: #fff; border-color: #1f2937; }
    body.dark-mode .nav-pills-modern li.active a { background: #6366f1; border-color: #6366f1; }

    /* CODE BLOCK (YAML) */
    pre.code-block {
        background: var(--code-bg); color: var(--code-text);
        border: 1px solid var(--border-color); border-radius: 8px;
        padding: 15px; font-family: 'Menlo', 'Monaco', 'Consolas', monospace;
        font-size: 13px; line-height: 1.5; white-space: pre-wrap; word-wrap: break-word;
        margin: 0;
    }
    
    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; font-family: 'Menlo', monospace; }

    /* BUTTONS */
    .btn-primary-theme {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; width: 100%; display: block; text-align: center;
    }
    .btn-primary-theme:hover { background: #374151; border-color: #374151; color: #fff; }

    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>{{ $node->name }}</h1>
                    <small>Daemon configuration & deployment.</small>
                </div>
                <span class="material-symbols-rounded" style="color: #6366f1; font-size: 30px;">hub</span>
            </div>
            
            <div style="margin-top: 20px;">
                <ul class="nav-pills-modern">
                    <li><a href="{{ route('admin.nodes.view', $node->id) }}"><span class="material-symbols-rounded">info</span> About</a></li>
                    <li><a href="{{ route('admin.nodes.view.settings', $node->id) }}"><span class="material-symbols-rounded">settings</span> Settings</a></li>
                    <li class="active"><a href="{{ route('admin.nodes.view.configuration', $node->id) }}"><span class="material-symbols-rounded">settings_applications</span> Configuration</a></li>
                    <li><a href="{{ route('admin.nodes.view.allocation', $node->id) }}"><span class="material-symbols-rounded">share_location</span> Allocation</a></li>
                    <li><a href="{{ route('admin.nodes.view.servers', $node->id) }}"><span class="material-symbols-rounded">dns</span> Servers</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- LEFT: CONFIGURATION FILE --}}
    <div class="col-sm-8">
        <div class="theme-card">
            <div class="card-header-theme">
                <span class="material-symbols-rounded" style="color: #6366f1;">description</span> Configuration File
            </div>
            <div class="card-body-theme">
                <pre class="code-block">{{ $node->getYamlConfiguration() }}</pre>
            </div>
            <div class="card-footer-theme">
                <span class="material-symbols-rounded" style="font-size: 16px; margin-right: 5px;">folder</span>
                Save this as <code>config.yml</code> in your daemon's root directory (usually <code>/etc/pterodactyl</code>).
            </div>
        </div>
    </div>

    {{-- RIGHT: AUTO DEPLOY --}}
    <div class="col-sm-4">
        <div class="theme-card">
            <div class="card-header-theme">
                <span class="material-symbols-rounded" style="color: #10b981;">rocket_launch</span> Auto-Deploy
            </div>
            <div class="card-body-theme">
                <p style="color: var(--text-main); margin-bottom: 20px; font-size: 14px; line-height: 1.6;">
                    Generate a custom deployment command to configure <strong>Wings</strong> on the target server automatically with a single command.
                </p>
                
                <button type="button" id="configTokenBtn" class="btn-primary-theme">
                    <span class="material-symbols-rounded" style="margin-right: 5px;">key</span> Generate Token
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#configTokenBtn').on('click', function (event) {
        // Efek Loading Button
        let btn = $(this);
        let originalText = btn.html();
        btn.html('<span class="material-symbols-rounded spin-anim" style="font-size:16px;">sync</span> Generating...').prop('disabled', true);

        $.ajax({
            method: 'POST',
            url: '{{ route('admin.nodes.view.configuration.token', $node->id) }}',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        }).done(function (data) {
            swal({
                type: 'success',
                title: 'Token Created',
                text: '<div style="text-align:left;"><p>Run the following command on your node:</p><pre style="background:#1f2937; color:#fff; padding:10px; border-radius:5px; margin-top:10px; font-size:12px; white-space:pre-wrap; word-break:break-all;">cd /etc/pterodactyl && sudo wings configure --panel-url {{ config('app.url') }} --token ' + data.token + ' --node ' + data.node + '{{ config('app.debug') ? ' --allow-insecure' : '' }}</pre></div>',
                html: true
            });
        }).fail(function () {
            swal({
                title: 'Error',
                text: 'Something went wrong creating your token.',
                type: 'error'
            });
        }).always(function() {
            // Reset Button
            btn.html(originalText).prop('disabled', false);
        });
    });
    </script>
    
    <style>
        .spin-anim { animation: spin 2s linear infinite; display: inline-block; vertical-align: middle; }
        @keyframes spin { 100% { transform: rotate(360deg); } }
    </style>
@endsection

