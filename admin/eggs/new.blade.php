@extends('layouts.admin')

@section('title')
    Nests &rarr; New Egg
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
        display: flex; justify-content: flex-end;
    }

    /* FORM INPUTS */
    label { color: var(--text-main); font-weight: 600; font-size: 13px; margin-bottom: 6px; }
    .form-control {
        background: var(--input-bg) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important; border-radius: 10px !important; height: 42px; box-shadow: none !important;
    }
    textarea.form-control { height: auto !important; font-family: 'Menlo', monospace; font-size: 12px; }
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }

    /* CHECKBOX CUSTOM */
    .checkbox-custom { display: flex; align-items: center; gap: 10px; cursor: pointer; }
    .checkbox-custom input { width: 18px; height: 18px; accent-color: #6366f1; cursor: pointer; }
    .checkbox-custom label { margin: 0; cursor: pointer; }

    /* ALERT BOX */
    .alert-warning-theme {
        background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3);
        color: #d97706; padding: 15px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; line-height: 1.6;
    }

    /* BUTTONS */
    .btn-primary-theme {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-primary-theme:hover { background: #374151; border-color: #374151; }

    /* SELECT2 FIX */
    .select2-container--default .select2-selection--single { background: var(--input-bg) !important; border: 1px solid var(--border-color) !important; height: 42px !important; border-radius: 10px !important; }
    .select2-selection__rendered { color: var(--text-main) !important; line-height: 40px !important; }
    .select2-selection__arrow { height: 40px !important; }
    .select2-dropdown { background: var(--bg-card) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; }

    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<form action="{{ route('admin.nests.egg.new') }}" method="POST">
    {{-- HEADER --}}
    <div class="row">
        <div class="col-xs-12">
            <div class="theme-card">
                <div class="card-header-unified">
                    <div class="header-title">
                        <h1>New Egg</h1>
                        <small>Create a new Egg to assign to servers.</small>
                    </div>
                    <span class="material-symbols-rounded" style="color: #6366f1; font-size: 30px;">egg</span>
                </div>
            </div>
        </div>
    </div>

    {{-- CONFIGURATION CARD --}}
    <div class="row">
        <div class="col-xs-12">
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">settings</span> Configuration
                </div>
                <div class="card-body-theme">
                    <div class="row">
                        {{-- LEFT: BASIC INFO --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pNestId" class="control-label">Associated Nest</label>
                                <select name="nest_id" id="pNestId" class="form-control">
                                    @foreach($nests as $nest)
                                        <option value="{{ $nest->id }}" {{ old('nest_id') != $nest->id ?: 'selected' }}>{{ $nest->name }} &lt;{{ $nest->author }}&gt;</option>
                                    @endforeach
                                </select>
                                <p class="text-muted small">Think of a Nest as a category.</p>
                            </div>

                            <div class="form-group">
                                <label for="pName" class="control-label">Name</label>
                                <input type="text" id="pName" name="name" value="{{ old('name') }}" class="form-control" placeholder="e.g. Vanilla Minecraft" />
                                <p class="text-muted small">Human-readable name users will see.</p>
                            </div>

                            <div class="form-group">
                                <label for="pDescription" class="control-label">Description</label>
                                <textarea id="pDescription" name="description" class="form-control" rows="6" placeholder="Brief description of this egg...">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <div class="checkbox-custom">
                                    <input id="pForceOutgoingIp" name="force_outgoing_ip" type="checkbox" value="1" {{ \Pterodactyl\Helpers\Utilities::checked('force_outgoing_ip', 0) }} />
                                    <div>
                                        <label for="pForceOutgoingIp" style="font-weight: 600;">Force Outgoing IP</label>
                                        <p class="text-muted small" style="margin:0;">Forces NAT on outgoing traffic. Disables internal networking.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT: DOCKER & STARTUP --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pDockerImages" class="control-label">Docker Images</label>
                                <textarea id="pDockerImages" name="docker_images" rows="4" placeholder="quay.io/pterodactyl/core:java" class="form-control">{{ old('docker_images') }}</textarea>
                                <p class="text-muted small">One image per line. Users can select from this list.</p>
                            </div>

                            <div class="form-group">
                                <label for="pStartup" class="control-label">Startup Command</label>
                                <textarea id="pStartup" name="startup" class="form-control" rows="8" placeholder="java -Xms128M -Xmx128M -jar server.jar">{{ old('startup') }}</textarea>
                                <p class="text-muted small">Default startup command for new servers.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PROCESS MANAGEMENT CARD --}}
    <div class="row">
        <div class="col-xs-12">
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">terminal</span> Process Management
                </div>
                <div class="card-body-theme">
                    <div class="alert-warning-theme">
                        <span class="material-symbols-rounded" style="vertical-align:bottom; margin-right:5px;">info</span>
                        All fields are required unless you select an option from <strong>Copy Settings From</strong>, which will auto-fill blank fields.
                    </div>

                    <div class="row">
                        {{-- LEFT: CONFIG --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFrom" class="control-label">Copy Settings From</label>
                                <select name="config_from" id="pConfigFrom" class="form-control">
                                    <option value="">None</option>
                                </select>
                                <p class="text-muted small">Auto-fill settings from another egg.</p>
                            </div>

                            <div class="form-group">
                                <label for="pConfigStop" class="control-label">Stop Command</label>
                                <input type="text" id="pConfigStop" name="config_stop" class="form-control" value="{{ old('config_stop') }}" placeholder="stop" />
                                <p class="text-muted small">Command to stop server gracefully. Use <code>^C</code> for SIGINT.</p>
                            </div>

                            <div class="form-group">
                                <label for="pConfigLogs" class="control-label">Log Configuration (JSON)</label>
                                <textarea data-action="handle-tabs" id="pConfigLogs" name="config_logs" class="form-control" rows="6">{{ old('config_logs') }}</textarea>
                            </div>
                        </div>

                        {{-- RIGHT: JSON CONFIGS --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFiles" class="control-label">Configuration Files (JSON)</label>
                                <textarea data-action="handle-tabs" id="pConfigFiles" name="config_files" class="form-control" rows="6">{{ old('config_files') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="pConfigStartup" class="control-label">Start Configuration (JSON)</label>
                                <textarea data-action="handle-tabs" id="pConfigStartup" name="config_startup" class="form-control" rows="6">{{ old('config_startup') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer-theme">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn-primary-theme">Create Egg</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}
    <script>
    $(document).ready(function() {
        $('#pNestId').select2().change();
        $('#pConfigFrom').select2();
    });
    $('#pNestId').on('change', function (event) {
        $('#pConfigFrom').html('<option value="">None</option>').select2({
            data: $.map(_.get(Pterodactyl.nests, $(this).val() + '.eggs', []), function (item) {
                return {
                    id: item.id,
                    text: item.name + ' <' + item.author + '>',
                };
            }),
        });
    });
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

