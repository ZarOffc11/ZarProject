@extends('layouts.admin')

@section('title')
    {{ $node->name }}: Settings
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
        display: flex; justify-content: flex-end; align-items: center;
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
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    .help-block, .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; line-height: 1.5; }

    /* INPUT GROUPS (MiB / %) */
    .input-group .form-control { border-radius: 10px 0 0 10px !important; }
    .input-group-addon {
        background: var(--bg-app) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-sub) !important; border-radius: 0 10px 10px 0 !important; border-left: 0 !important;
        font-weight: 600; font-size: 12px;
    }

    /* SELECT2 */
    .select2-container--default .select2-selection--single { background: var(--input-bg) !important; border: 1px solid var(--border-color) !important; height: 42px !important; border-radius: 10px !important; }
    .select2-selection__rendered { color: var(--text-main) !important; line-height: 40px !important; }
    .select2-selection__arrow { height: 40px !important; }
    .select2-dropdown { background: var(--bg-card) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; }

    /* CUSTOM RADIO BUTTONS */
    .radio-group { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 5px; }
    .radio-label {
        display: flex; align-items: center; gap: 8px; cursor: pointer; margin: 0; 
        font-weight: 500; font-size: 13px; color: var(--text-main);
        padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 8px; background: var(--input-bg); transition: 0.2s; flex: 1;
    }
    .radio-label:hover { border-color: #6366f1; }
    input[type="radio"] { margin: 0; accent-color: #6366f1; transform: scale(1.1); }

    /* BUTTONS */
    .btn-primary-theme {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-primary-theme:hover { background: #374151; border-color: #374151; }

    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; }
    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

{{-- TOP HEADER & NAV --}}
<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>{{ $node->name }}</h1>
                    <small>Configure node settings.</small>
                </div>
                <span class="material-symbols-rounded" style="color: #6366f1; font-size: 30px;">hub</span>
            </div>
            <div style="margin-top: 20px;">
                <ul class="nav-pills-modern">
                    <li><a href="{{ route('admin.nodes.view', $node->id) }}"><span class="material-symbols-rounded">info</span> About</a></li>
                    <li class="active"><a href="{{ route('admin.nodes.view.settings', $node->id) }}"><span class="material-symbols-rounded">settings</span> Settings</a></li>
                    <li><a href="{{ route('admin.nodes.view.configuration', $node->id) }}"><span class="material-symbols-rounded">settings_applications</span> Configuration</a></li>
                    <li><a href="{{ route('admin.nodes.view.allocation', $node->id) }}"><span class="material-symbols-rounded">share_location</span> Allocation</a></li>
                    <li><a href="{{ route('admin.nodes.view.servers', $node->id) }}"><span class="material-symbols-rounded">dns</span> Servers</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('admin.nodes.view.settings', $node->id) }}" method="POST">
    <div class="row">
        {{-- LEFT COLUMN: SETTINGS --}}
        <div class="col-sm-6">
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">tune</span> Basic Settings
                </div>
                <div class="card-body-theme">
                    <div class="form-group">
                        <label for="name" class="control-label">Node Name</label>
                        <input type="text" autocomplete="off" name="name" class="form-control" value="{{ old('name', $node->name) }}" />
                        <p class="text-muted"><small>Alphanumeric characters, hyphens, and underscores only.</small></p>
                    </div>
                    
                    <div class="form-group">
                        <label for="description" class="control-label">Description</label>
                        <textarea name="description" id="description" rows="4" class="form-control">{{ $node->description }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="location_id" class="control-label">Location</label>
                        <select name="location_id" class="form-control">
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ (old('location_id', $node->location_id) === $location->id) ? 'selected' : '' }}>{{ $location->long }} ({{ $location->short }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="public" class="control-label">Automatic Allocation</label>
                        <div class="radio-group">
                            <label class="radio-label" for="public_1">
                                <input type="radio" name="public" value="1" {{ (old('public', $node->public)) ? 'checked' : '' }} id="public_1"> Allow
                            </label>
                            <label class="radio-label" for="public_0">
                                <input type="radio" name="public" value="0" {{ (old('public', $node->public)) ? '' : 'checked' }} id="public_0"> Deny
                            </label>
                        </div>
                        <p class="text-muted small">Allow automatic allocation creation to this Node?</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="fqdn" class="control-label">FQDN</label>
                        <input type="text" autocomplete="off" name="fqdn" class="form-control" value="{{ old('fqdn', $node->fqdn) }}" />
                        <p class="text-muted small">Domain name used to connect to the daemon (e.g. <code>node.example.com</code>).</p>
                    </div>

                    <div class="form-group">
                        <label class="control-label">SSL Connection</label>
                        <div class="radio-group">
                            <label class="radio-label" for="pSSLTrue">
                                <input type="radio" id="pSSLTrue" value="https" name="scheme" {{ (old('scheme', $node->scheme) === 'https') ? 'checked' : '' }}> SSL (Secure)
                            </label>
                            <label class="radio-label" for="pSSLFalse">
                                <input type="radio" id="pSSLFalse" value="http" name="scheme" {{ (old('scheme', $node->scheme) !== 'https') ? 'checked' : '' }}> HTTP (Insecure)
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Behind Proxy</label>
                        <div class="radio-group">
                            <label class="radio-label" for="pProxyFalse">
                                <input type="radio" id="pProxyFalse" value="0" name="behind_proxy" {{ (old('behind_proxy', $node->behind_proxy) == false) ? 'checked' : '' }}> No Proxy
                            </label>
                            <label class="radio-label" for="pProxyTrue">
                                <input type="radio" id="pProxyTrue" value="1" name="behind_proxy" {{ (old('behind_proxy', $node->behind_proxy) == true) ? 'checked' : '' }}> Behind Proxy
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Maintenance Mode</label>
                        <div class="radio-group">
                            <label class="radio-label" for="pMaintenanceFalse">
                                <input type="radio" id="pMaintenanceFalse" value="0" name="maintenance_mode" {{ (old('maintenance_mode', $node->maintenance_mode) == false) ? 'checked' : '' }}> Disabled
                            </label>
                            <label class="radio-label" for="pMaintenanceTrue" style="border-color: #f59e0b; background: rgba(245, 158, 11, 0.05);">
                                <input type="radio" id="pMaintenanceTrue" value="1" name="maintenance_mode" {{ (old('maintenance_mode', $node->maintenance_mode) == true) ? 'checked' : '' }}> Enabled
                            </label>
                        </div>
                        <p class="text-muted small">If enabled, users won't be able to access servers on this node.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: LIMITS & CONFIG --}}
        <div class="col-sm-6">
            {{-- ALLOCATION LIMITS --}}
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">pie_chart</span> Allocation Limits
                </div>
                <div class="card-body-theme">
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label for="memory" class="control-label">Total Memory</label>
                            <div class="input-group">
                                <input type="text" name="memory" class="form-control" data-multiplicator="true" value="{{ old('memory', $node->memory) }}"/>
                                <span class="input-group-addon">MiB</span>
                            </div>
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="memory_overallocate" class="control-label">Overallocate</label>
                            <div class="input-group">
                                <input type="text" name="memory_overallocate" class="form-control" value="{{ old('memory_overallocate', $node->memory_overallocate) }}"/>
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <p class="text-muted small" style="margin-bottom: 15px;">Total memory available for new servers. Percentage allows allocation beyond limit.</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label for="disk" class="control-label">Disk Space</label>
                            <div class="input-group">
                                <input type="text" name="disk" class="form-control" data-multiplicator="true" value="{{ old('disk', $node->disk) }}"/>
                                <span class="input-group-addon">MiB</span>
                            </div>
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="disk_overallocate" class="control-label">Overallocate</label>
                            <div class="input-group">
                                <input type="text" name="disk_overallocate" class="form-control" value="{{ old('disk_overallocate', $node->disk_overallocate) }}"/>
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <p class="text-muted small">Total disk space available. Percentage allows allocation beyond limit.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- GENERAL CONFIGURATION --}}
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">settings_applications</span> Configuration
                </div>
                <div class="card-body-theme">
                    <div class="form-group">
                        <label for="upload_size" class="control-label">Max Upload Filesize</label>
                        <div class="input-group">
                            <input type="text" name="upload_size" class="form-control" value="{{ old('upload_size', $node->upload_size) }}"/>
                            <span class="input-group-addon">MiB</span>
                        </div>
                        <p class="text-muted small">Max size for web-based file uploads.</p>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="daemonListen" class="control-label">Daemon Port</label>
                            <input type="text" name="daemonListen" class="form-control" value="{{ old('daemonListen', $node->daemonListen) }}"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="daemonSFTP" class="control-label">Daemon SFTP Port</label>
                            <input type="text" name="daemonSFTP" class="form-control" value="{{ old('daemonSFTP', $node->daemonSFTP) }}"/>
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted small">Daemon runs its own SFTP container. <strong>Do not match your physical server's SSH port.</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SAVE SECTION --}}
    <div class="row">
        <div class="col-xs-12">
            <div class="theme-card">
                <div class="card-footer-theme">
                    <div style="flex-grow: 1;">
                        <div class="checkbox checkbox-primary" style="margin: 0;">
                            <input type="checkbox" name="reset_secret" id="reset_secret" />
                            <label for="reset_secret" style="font-weight: 500; color: var(--text-main);">
                                Reset Daemon Master Key
                            </label>
                        </div>
                        <p class="text-muted small" style="margin: 5px 0 0 25px;">Resetting the key will void requests from the old key.</p>
                    </div>
                    
                    <div>
                        {!! method_field('PATCH') !!}
                        {!! csrf_field() !!}
                        <button type="submit" class="btn-primary-theme">Save Changes</button>
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
    $('[data-toggle="popover"]').popover({
        placement: 'auto'
    });
    $('select[name="location_id"]').select2();
    </script>
@endsection

