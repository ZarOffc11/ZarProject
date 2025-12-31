@extends('layouts.admin')

@section('title')
    Server — {{ $server->name }}: Startup
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

    /* NAVIGATION CONTAINER */
    .nav-container-unified { padding: 0 24px 20px 24px; margin-top: 20px; }
    .nav-container-unified ul { margin-bottom: 0 !important; border-bottom: 1px solid var(--border-color); }

    /* SUB HEADER */
    .card-header-theme {
        padding: 15px 24px; border-bottom: 1px solid var(--border-color);
        font-weight: 700; font-size: 15px; display: flex; align-items: center; gap: 8px; color: var(--text-main);
    }

    .card-body-theme { padding: 24px; color: var(--text-main); }
    .card-footer-theme {
        padding: 15px 24px; background: var(--input-bg); border-top: 1px solid var(--border-color);
        display: flex; justify-content: space-between; align-items: center;
    }

    /* FORM INPUTS */
    .form-control {
        background: var(--input-bg) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important; border-radius: 10px !important; height: 42px; box-shadow: none !important;
    }
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    .form-control[readonly] { opacity: 0.7; cursor: not-allowed; }
    
    label { color: var(--text-main); font-weight: 600; font-size: 13px; margin-bottom: 6px; }
    .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }

    /* ALERT STYLE */
    .alert-danger-theme {
        background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3);
        color: #ef4444; padding: 15px; border-radius: 10px; font-size: 13px; margin-bottom: 20px;
    }

    /* CHECKBOX CUSTOM */
    .checkbox-custom { display: flex; align-items: center; gap: 10px; cursor: pointer; margin-bottom: 5px; }
    .checkbox-custom input { width: 18px; height: 18px; accent-color: #6366f1; cursor: pointer; }
    .checkbox-custom label { margin: 0; cursor: pointer; font-weight: 600; }

    /* BUTTONS */
    .btn-primary-theme {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 8px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-primary-theme:hover { background: #374151; border-color: #374151; }

    /* SELECT2 FIX */
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
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>{{ $server->name }}</h1>
                    <small>Control startup command and variables.</small>
                </div>
                <span class="material-symbols-rounded" style="color: #6366f1; font-size: 30px;">dns</span>
            </div>
            
            <div class="nav-container-unified">
                @include('admin.servers.partials.navigation')
            </div>
        </div>
    </div>
</div>

<form action="{{ route('admin.servers.view.startup', $server->id) }}" method="POST">
    {{-- STARTUP COMMAND MODIFICATION --}}
    <div class="row">
        <div class="col-xs-12">
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">terminal</span> Startup Command Modification
                </div>
                <div class="card-body-theme">
                    <div class="form-group">
                        <label for="pStartup" class="form-label">Startup Command</label>
                        <input id="pStartup" name="startup" class="form-control" type="text" value="{{ old('startup', $server->startup) }}" />
                        <p class="text-muted small">
                            Variables available: <code>@{{SERVER_MEMORY}}</code>, <code>@{{SERVER_IP}}</code>, <code>@{{SERVER_PORT}}</code>.
                        </p>
                    </div>
                    
                    <div class="form-group" style="margin-bottom:0;">
                        <label for="pDefaultStartupCommand" class="form-label">Default Service Start Command</label>
                        <input id="pDefaultStartupCommand" class="form-control" type="text" readonly />
                    </div>
                </div>
                <div class="card-footer-theme" style="justify-content: flex-end;">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn-primary-theme">Save Modifications</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- LEFT: SERVICE CONFIG --}}
        <div class="col-md-6">
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">settings_applications</span> Service Configuration
                </div>
                <div class="card-body-theme">
                    <div class="alert-danger-theme">
                        <div style="display:flex; gap:10px; align-items:flex-start;">
                            <span class="material-symbols-rounded" style="font-size:20px;">warning</span>
                            <div>
                                <strong>Destructive Operation:</strong> Changing Nest/Egg will trigger a re-install. The server will be stopped immediately.
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pNestId">Nest</label>
                        <select name="nest_id" id="pNestId" class="form-control">
                            @foreach($nests as $nest)
                                <option value="{{ $nest->id }}" @if($nest->id === $server->nest_id) selected @endif>{{ $nest->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-muted small">Server grouping category.</p>
                    </div>

                    <div class="form-group">
                        <label for="pEggId">Egg</label>
                        <select name="egg_id" id="pEggId" class="form-control"></select>
                        <p class="text-muted small">Determines how the server is processed.</p>
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <div class="checkbox-custom">
                            <input id="pSkipScripting" name="skip_scripts" type="checkbox" value="1" @if($server->skip_scripts) checked @endif />
                            <label for="pSkipScripting">Skip Egg Install Script</label>
                        </div>
                        <p class="text-muted small">If checked, the install script will not run during re-install.</p>
                    </div>
                </div>
            </div>

            <div class="theme-card" style="margin-top: 20px;">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">docker</span> Docker Configuration
                </div>
                <div class="card-body-theme">
                    <div class="form-group">
                        <label for="pDockerImage">Image</label>
                        <select id="pDockerImage" name="docker_image" class="form-control"></select>
                        <input id="pDockerImageCustom" name="custom_docker_image" value="{{ old('custom_docker_image') }}" class="form-control" placeholder="Or enter a custom image..." style="margin-top:10px;"/>
                        <p class="text-muted small">Docker image used to run this server.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: VARIABLES (JS INJECTED) --}}
        <div class="col-md-6">
            <div class="row" id="appendVariablesTo"></div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}
    <script>
    function escapeHtml(str) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }

    $(document).ready(function () {
        $('#pEggId').select2({placeholder: 'Select a Nest Egg'}).on('change', function () {
            var selectedEgg = _.isNull($(this).val()) ? $(this).find('option').first().val() : $(this).val();
            var parentChain = _.get(Pterodactyl.nests, $("#pNestId").val());
            var objectChain = _.get(parentChain, 'eggs.' + selectedEgg);

            const images = _.get(objectChain, 'docker_images', [])
            $('#pDockerImage').html('');
            const keys = Object.keys(images);
            for (let i = 0; i < keys.length; i++) {
                let opt = document.createElement('option');
                opt.value = images[keys[i]];
                opt.innerText = keys[i] + " (" + images[keys[i]] + ")";
                if (objectChain.id === parseInt(Pterodactyl.server.egg_id) && Pterodactyl.server.image == opt.value) {
                    opt.selected = true
                }
                $('#pDockerImage').append(opt);
            }
            $('#pDockerImage').on('change', function () {
                $('#pDockerImageCustom').val('');
            })

            if (objectChain.id === parseInt(Pterodactyl.server.egg_id)) {
                if ($('#pDockerImage').val() != Pterodactyl.server.image) {
                    $('#pDockerImageCustom').val(Pterodactyl.server.image);
                }
            }

            if (!_.get(objectChain, 'startup', false)) {
                $('#pDefaultStartupCommand').val(_.get(parentChain, 'startup', 'ERROR: Startup Not Defined!'));
            } else {
                $('#pDefaultStartupCommand').val(_.get(objectChain, 'startup'));
            }

            // MODIFIED: Generate HTML using theme-card classes
            $('#appendVariablesTo').html('');
            $.each(_.get(objectChain, 'variables', []), function (i, item) {
                var setValue = _.get(Pterodactyl.server_variables, item.env_variable, item.default_value);
                var isRequired = (item.required === 1) ? '<span class="badge" style="background:#ef4444; color:#fff; margin-right:5px;">Required</span> ' : '';
                
                var dataAppend = ' \
                    <div class="col-xs-12"> \
                        <div class="theme-card"> \
                            <div class="card-header-theme"> \
                                ' + isRequired + escapeHtml(item.name) + ' \
                            </div> \
                            <div class="card-body-theme"> \
                                <input name="environment[' + escapeHtml(item.env_variable) + ']" class="form-control" type="text" id="egg_variable_' + escapeHtml(item.env_variable) + '" /> \
                                <p class="text-muted small" style="margin-top:5px;">' + escapeHtml(item.description) + '</p> \
                            </div> \
                            <div class="card-footer-theme" style="display:block;"> \
                                <div style="display:flex; justify-content:space-between;"> \
                                    <span class="text-muted small"><strong>Var:</strong> <code>' + escapeHtml(item.env_variable) + '</code></span> \
                                    <span class="text-muted small"><strong>Rules:</strong> <code>' + escapeHtml(item.rules) + '</code></span> \
                                </div> \
                            </div> \
                        </div> \
                    </div>';
                $('#appendVariablesTo').append(dataAppend).find('#egg_variable_' + item.env_variable).val(setValue);
            });
        });

        $('#pNestId').select2({placeholder: 'Select a Nest'}).on('change', function () {
            $('#pEggId').html('').select2({
                data: $.map(_.get(Pterodactyl.nests, $(this).val() + '.eggs', []), function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                }),
            });

            if (_.isObject(_.get(Pterodactyl.nests, $(this).val() + '.eggs.' + Pterodactyl.server.egg_id))) {
                $('#pEggId').val(Pterodactyl.server.egg_id);
            }

            $('#pEggId').change();
        }).change();
    });
    </script>
@endsection

