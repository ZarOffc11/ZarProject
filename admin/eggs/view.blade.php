@extends('layouts.admin')

@section('title')
    Nests &rarr; Egg: {{ $egg->name }}
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
    
    /* HEADERS */
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
        display: flex; justify-content: flex-end; gap: 10px; align-items: center;
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
    textarea.form-control { height: auto !important; }
    /* Code Editor Style for JSON/Startup */
    textarea.code-editor { font-family: 'Menlo', 'Monaco', 'Courier New', monospace; font-size: 12px; }
    
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    .form-control[readonly] { opacity: 0.7; cursor: not-allowed; }
    .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }

    /* BUTTONS */
    .btn-primary-theme {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-primary-theme:hover { background: #374151; border-color: #374151; }

    .btn-danger-theme {
        background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;
        padding: 10px 24px; border-radius: 8px; font-weight: 600; transition: all 0.2s;
    }
    .btn-danger-theme:hover { background: #b91c1c; color: #fff; border-color: #b91c1c; }

    .btn-secondary-theme {
        background: var(--btn-bg); color: var(--text-main); border: 1px solid var(--btn-border);
        padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; text-decoration: none !important;
    }
    .btn-secondary-theme:hover { background: var(--btn-hover); border-color: var(--text-main); }

    /* CHECKBOX CUSTOM */
    .checkbox-custom { display: flex; align-items: center; gap: 10px; cursor: pointer; }
    .checkbox-custom input { width: 18px; height: 18px; accent-color: #6366f1; cursor: pointer; }
    .checkbox-custom label { margin: 0; cursor: pointer; }

    /* ALERT WARNING */
    .alert-warning-theme {
        background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3);
        color: #d97706; padding: 15px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; line-height: 1.6;
    }

    /* SELECT2 FIX */
    .select2-container--default .select2-selection--single { background: var(--input-bg) !important; border: 1px solid var(--border-color) !important; height: 42px !important; border-radius: 10px !important; }
    .select2-selection__rendered { color: var(--text-main) !important; line-height: 40px !important; }
    .select2-selection__arrow { height: 40px !important; }
    .select2-dropdown { background: var(--bg-card) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; }

    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            {{-- HEADER & NAV --}}
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>{{ $egg->name }}</h1>
                    <small>{{ str_limit($egg->description, 50) }}</small>
                </div>
                <span class="material-symbols-rounded" style="color: #6366f1; font-size: 30px;">egg</span>
            </div>
            
            <div style="margin-top: 20px;">
                <ul class="nav-pills-modern">
                    <li class="active"><a href="{{ route('admin.nests.egg.view', $egg->id) }}"><span class="material-symbols-rounded">settings</span> Configuration</a></li>
                    <li><a href="{{ route('admin.nests.egg.variables', $egg->id) }}"><span class="material-symbols-rounded">data_object</span> Variables</a></li>
                    <li><a href="{{ route('admin.nests.egg.scripts', $egg->id) }}"><span class="material-symbols-rounded">code</span> Install Script</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- DANGER ZONE: UPDATE EGG FILE --}}
<form action="{{ route('admin.nests.egg.view', $egg->id) }}" enctype="multipart/form-data" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="theme-card" style="border-left: 4px solid #ef4444;">
                <div class="card-body-theme" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                    <div style="flex: 1;">
                        <label class="control-label" style="color: #ef4444;">Update Egg File (JSON)</label>
                        <input type="file" name="import_file" class="form-control" style="padding: 10px; height: auto;" />
                        <p class="text-muted small" style="margin-bottom: 0;">Replaces settings by uploading a new JSON file. Does not change existing server startup strings.</p>
                    </div>
                    <div>
                        {!! csrf_field() !!}
                        <button type="submit" name="_method" value="PUT" class="btn-danger-theme">
                            <span class="material-symbols-rounded" style="margin-right: 5px;">upload</span> Update Egg
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form action="{{ route('admin.nests.egg.view', $egg->id) }}" method="POST">
    {{-- CONFIGURATION --}}
    <div class="row">
        <div class="col-xs-12">
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">tune</span> Configuration
                </div>
                <div class="card-body-theme">
                    <div class="row">
                        {{-- LEFT COLUMN --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pName" class="control-label">Name</label>
                                <input type="text" id="pName" name="name" value="{{ $egg->name }}" class="form-control" />
                                <p class="text-muted small">Human-readable identifier.</p>
                            </div>
                            <div class="form-group">
                                <label for="pUuid" class="control-label">UUID</label>
                                <input type="text" id="pUuid" readonly value="{{ $egg->uuid }}" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="pAuthor" class="control-label">Author</label>
                                <input type="text" id="pAuthor" readonly value="{{ $egg->author }}" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="pDockerImage" class="control-label">Docker Images</label>
                                <textarea id="pDockerImages" name="docker_images" class="form-control code-editor" rows="4">{{ implode(PHP_EOL, $images) }}</textarea>
                                <p class="text-muted small">One image per line. Format: <code>Display Name|image:tag</code></p>
                            </div>
                            <div class="form-group">
                                <div class="checkbox-custom">
                                    <input id="pForceOutgoingIp" name="force_outgoing_ip" type="checkbox" value="1" @if($egg->force_outgoing_ip) checked @endif />
                                    <div>
                                        <label for="pForceOutgoingIp">Force Outgoing IP</label>
                                        <p class="text-muted small" style="margin:0;">Forces NAT on outgoing traffic. Disables internal networking.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT COLUMN --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pDescription" class="control-label">Description</label>
                                <textarea id="pDescription" name="description" class="form-control" rows="8">{{ $egg->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="pStartup" class="control-label">Startup Command</label>
                                <textarea id="pStartup" name="startup" class="form-control code-editor" rows="8">{{ $egg->startup }}</textarea>
                                <p class="text-muted small">Default startup command for new servers.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PROCESS MANAGEMENT --}}
    <div class="row">
        <div class="col-xs-12">
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">terminal</span> Process Management
                </div>
                <div class="card-body-theme">
                    <div class="alert-warning-theme">
                        <span class="material-symbols-rounded" style="vertical-align: bottom; margin-right: 5px;">warning</span>
                        <strong>Advanced Config:</strong> Modify these fields only if you understand how the daemon works. Wrong configuration can break server boot processes.
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFrom" class="control-label">Copy Settings From</label>
                                <select name="config_from" id="pConfigFrom" class="form-control">
                                    <option value="">None</option>
                                    @foreach($egg->nest->eggs as $o)
                                        <option value="{{ $o->id }}" {{ ($egg->config_from !== $o->id) ?: 'selected' }}>{{ $o->name }} &lt;{{ $o->author }}&gt;</option>
                                    @endforeach
                                </select>
                                <p class="text-muted small">Inherit settings from another Egg.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStop" class="control-label">Stop Command</label>
                                <input type="text" id="pConfigStop" name="config_stop" class="form-control" value="{{ $egg->config_stop }}" />
                                <p class="text-muted small">Command to stop gracefully. Use <code>^C</code> for SIGINT.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigLogs" class="control-label">Log Configuration (JSON)</label>
                                <textarea data-action="handle-tabs" id="pConfigLogs" name="config_logs" class="form-control code-editor" rows="6">{{ ! is_null($egg->config_logs) ? json_encode(json_decode($egg->config_logs), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFiles" class="control-label">Configuration Files (JSON)</label>
                                <textarea data-action="handle-tabs" id="pConfigFiles" name="config_files" class="form-control code-editor" rows="6">{{ ! is_null($egg->config_files) ? json_encode(json_decode($egg->config_files), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStartup" class="control-label">Start Configuration (JSON)</label>
                                <textarea data-action="handle-tabs" id="pConfigStartup" name="config_startup" class="form-control code-editor" rows="6">{{ ! is_null($egg->config_startup) ? json_encode(json_decode($egg->config_startup), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FOOTER ACTIONS --}}
                <div class="card-footer-theme">
                    {!! csrf_field() !!}
                    <div>
                        <button id="deleteButton" type="submit" name="_method" value="DELETE" class="btn-danger-theme" onclick="return confirm('Are you sure you want to delete this Egg?')">
                            <span class="material-symbols-rounded">delete</span> Delete
                        </button>
                    </div>
                    <div style="display:flex; gap:10px;">
                        <a href="{{ route('admin.nests.egg.export', $egg->id) }}" class="btn-secondary-theme">
                            <span class="material-symbols-rounded" style="font-size: 18px; vertical-align: middle;">download</span> Export
                        </a>
                        <button type="submit" name="_method" value="PATCH" class="btn-primary-theme">Save Changes</button>
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
    $('#pConfigFrom').select2();
    
    // Tab indent handler for code editors
    $('textarea[data-action="handle-tabs"]').on('keydown', function(event) {
        if (event.keyCode === 9) {
            event.preventDefault();
            var curPos = $(this)[0].selectionStart;
            var prepend = $(this).val().substr(0, curPos);
            var append = $(this).val().substr(curPos);
            $(this).val(prepend + '    ' + append);
        }
    });
    </script>
@endsection

