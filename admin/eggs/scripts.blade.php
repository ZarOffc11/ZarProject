@extends('layouts.admin')

@section('title')
    Nests &rarr; Egg: {{ $egg->name }} &rarr; Install Script
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

    /* CARD SUB-HEADER */
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

    /* FORM INPUTS */
    label { color: var(--text-main); font-weight: 600; font-size: 13px; margin-bottom: 6px; }
    .form-control {
        background: var(--input-bg) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important; border-radius: 10px !important; height: 42px; box-shadow: none !important;
    }
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }

    /* ALERT WARNING */
    .alert-warning-theme {
        background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3);
        color: #d97706; padding: 15px; border-radius: 0; font-size: 13px; border-left: none; border-right: none; border-top: none;
    }
    .alert-warning-theme a { color: inherit; text-decoration: underline; font-weight: bold; }

    /* EDITOR CONTAINER */
    #editor_install { border-bottom: 1px solid var(--border-color); }

    /* BUTTONS */
    .btn-primary-theme {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 8px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-primary-theme:hover { background: #374151; border-color: #374151; }

    /* SELECT2 */
    .select2-container--default .select2-selection--single { background: var(--input-bg) !important; border: 1px solid var(--border-color) !important; height: 42px !important; border-radius: 10px !important; }
    .select2-selection__rendered { color: var(--text-main) !important; line-height: 40px !important; }
    .select2-selection__arrow { height: 40px !important; }
    .select2-dropdown { background: var(--bg-card) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; }

    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; font-family: 'Menlo', monospace; }
    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            {{-- UNIFIED HEADER --}}
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>{{ $egg->name }}</h1>
                    <small>Manage install script.</small>
                </div>
                <span class="material-symbols-rounded" style="color: #6366f1; font-size: 30px;">terminal</span>
            </div>
            
            {{-- NAVIGATION --}}
            <div style="margin-top: 20px;">
                <ul class="nav-pills-modern">
                    <li><a href="{{ route('admin.nests.egg.view', $egg->id) }}"><span class="material-symbols-rounded">settings</span> Configuration</a></li>
                    <li><a href="{{ route('admin.nests.egg.variables', $egg->id) }}"><span class="material-symbols-rounded">data_object</span> Variables</a></li>
                    <li class="active"><a href="{{ route('admin.nests.egg.scripts', $egg->id) }}"><span class="material-symbols-rounded">code</span> Install Script</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('admin.nests.egg.scripts', $egg->id) }}" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">description</span> Install Script Logic
                </div>

                {{-- ALERT IF COPIED --}}
                @if(! is_null($egg->copyFrom))
                    <div class="alert-warning-theme">
                        <span class="material-symbols-rounded" style="vertical-align:bottom; margin-right:5px;">warning</span>
                        This option copies scripts from <a href="{{ route('admin.nests.egg.view', $egg->copyFrom->id) }}">{{ $egg->copyFrom->name }}</a>. Changes here won't apply unless you select "None" below.
                    </div>
                @endif

                {{-- ACE EDITOR --}}
                <div class="box-body no-padding">
                    <div id="editor_install" style="height:300px; width:100%;">{{ $egg->script_install }}</div>
                </div>

                <div class="card-body-theme">
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="control-label">Copy Script From</label>
                            <select id="pCopyScriptFrom" name="copy_script_from" class="form-control">
                                <option value="">None</option>
                                @foreach($copyFromOptions as $opt)
                                    <option value="{{ $opt->id }}" {{ $egg->copy_script_from !== $opt->id ?: 'selected' }}>{{ $opt->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-muted small">Inherit script from another egg.</p>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="control-label">Script Container</label>
                            <input type="text" name="script_container" class="form-control" value="{{ $egg->script_container }}" />
                            <p class="text-muted small">Docker image for the install process (e.g. <code>alpine:3.8</code>).</p>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="control-label">Script Entrypoint</label>
                            <input type="text" name="script_entry" class="form-control" value="{{ $egg->script_entry }}" />
                            <p class="text-muted small">Command to execute (e.g. <code>/bin/ash</code>).</p>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 10px;">
                        <div class="col-xs-12">
                            <div style="background: var(--input-bg); border: 1px solid var(--border-color); padding: 10px; border-radius: 8px;">
                                <span style="font-weight: 600; color: var(--text-main);">Dependent Eggs:</span>
                                @if(count($relyOnScript) > 0)
                                    @foreach($relyOnScript as $rely)
                                        <a href="{{ route('admin.nests.egg.view', $rely->id) }}" style="color: #6366f1; text-decoration: none;">
                                            {{ $rely->name }}
                                        </a>@if(!$loop->last),&nbsp;@endif
                                    @endforeach
                                @else
                                    <span class="text-muted">None</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer-theme">
                    {!! csrf_field() !!}
                    <textarea name="script_install" class="hidden"></textarea>
                    <button type="submit" name="_method" value="PATCH" class="btn-primary-theme">Save Script</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/ace/ace.js') !!}
    {!! Theme::js('vendor/ace/ext-modelist.js') !!}
    <script>
    $(document).ready(function () {
        $('#pCopyScriptFrom').select2();

        const InstallEditor = ace.edit('editor_install');
        const Modelist = ace.require('ace/ext/modelist')

        // Menggunakan tema Monokai agar lebih cocok dengan Dark Mode
        InstallEditor.setTheme('ace/theme/monokai');
        InstallEditor.getSession().setMode('ace/mode/sh');
        InstallEditor.getSession().setUseWrapMode(true);
        InstallEditor.setShowPrintMargin(false);
        InstallEditor.setOptions({
            fontFamily: 'Menlo, Monaco, Consolas, "Courier New", monospace',
            fontSize: '13px'
        });

        $('form').on('submit', function (e) {
            $('textarea[name="script_install"]').val(InstallEditor.getValue());
        });
    });
    </script>
@endsection

