@extends('layouts.admin')

@section('title')
    Nodes &rarr; New
@endsection

{{-- HEADER BAWAAN DIKOSONGKAN --}}
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

    /* HEADER UNIFIED */
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
    textarea.form-control { height: auto !important; }
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    .help-block, .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }

    /* INPUT GROUPS (MB/%) */
    .input-group .form-control { border-radius: 10px 0 0 10px !important; }
    .input-group-addon {
        background: var(--bg-app) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-sub) !important; border-radius: 0 10px 10px 0 !important; border-left: 0 !important;
    }

    /* SELECT2 */
    .select2-container--default .select2-selection--single { background: var(--input-bg) !important; border: 1px solid var(--border-color) !important; height: 42px !important; border-radius: 10px !important; }
    .select2-selection__rendered { color: var(--text-main) !important; line-height: 40px !important; }
    .select2-selection__arrow { height: 40px !important; }
    .select2-dropdown { background: var(--bg-card) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; }

    /* RADIO BUTTONS CUSTOM */
    .radio-group { display: flex; gap: 15px; margin-bottom: 5px; }
    .radio-label {
        display: flex; align-items: center; gap: 8px; cursor: pointer; margin: 0; 
        font-weight: 500; font-size: 13px; color: var(--text-main);
        padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 8px; background: var(--input-bg); transition: 0.2s;
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

<form action="{{ route('admin.nodes.new') }}" method="POST">
    
    {{-- UNIFIED HEADER --}}
    <div class="row">
        <div class="col-xs-12">
            <div class="theme-card">
                <div class="card-header-unified">
                    <div class="header-title">
                        <h1>New Node</h1>
                        <small>Create a new local or remote node.</small>
                    </div>
                    <div>
                        <span class="material-symbols-rounded" style="color: #6366f1; font-size: 28px;">add_to_queue</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- LEFT: BASIC DETAILS --}}
        <div class="col-sm-6">
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">dns</span> Basic Details
                </div>
                <div class="card-body-theme">
                    <div class="form-group">
                        <label for="pName" class="form-label">Name</label>
                        <input type="text" name="name" id="pName" class="form-control" value="{{ old('name') }}" placeholder="e.g. Node-01"/>
                        <p class="text-muted small">Alphanumeric characters, hyphens, and underscores only.</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="pDescription" class="form-label">Description</label>
                        <textarea name="description" id="pDescription" rows="4" class="form-control" placeholder="Optional description...">{{ old('description') }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="pLocationId" class="form-label">Location</label>
                        <select name="location_id" id="pLocationId" class="form-control">
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ $location->id != old('location_id') ?: 'selected' }}>{{ $location->short }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Node Visibility</label>
                        <div class="radio-group">
                            <label class="radio-label" for="pPublicTrue">
                                <input type="radio" id="pPublicTrue" value="1" name="public" checked> Public
                            </label>
                            <label class="radio-label" for="pPublicFalse">
                                <input type="radio" id="pPublicFalse" value="0" name="public"> Private
                            </label>
                        </div>
                        <p class="text-muted small">Private nodes deny auto-deployment.</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="pFQDN" class="form-label">FQDN</label>
                        <input type="text" name="fqdn" id="pFQDN" class="form-control" value="{{ old('fqdn') }}" placeholder="node.example.com"/>
                        <p class="text-muted small">Domain name or IP address for daemon connection.</p>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">SSL Connection</label>
                        <div class="radio-group">
                            <label class="radio-label" for="pSSLTrue">
                                <input type="radio" id="pSSLTrue" value="https" name="scheme" checked> Use SSL
                            </label>
                            <label class="radio-label" for="pSSLFalse">
                                <input type="radio" id="pSSLFalse" value="http" name="scheme" @if(request()->isSecure()) disabled @endif> HTTP (Insecure)
                            </label>
                        </div>
                        @if(request()->isSecure())
                            <p class="text-danger small" style="margin-top:5px;">Panel is secure (HTTPS). Node <strong>must</strong> use SSL.</p>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Behind Proxy</label>
                        <div class="radio-group">
                            <label class="radio-label" for="pProxyFalse">
                                <input type="radio" id="pProxyFalse" value="0" name="behind_proxy" checked> No Proxy
                            </label>
                            <label class="radio-label" for="pProxyTrue">
                                <input type="radio" id="pProxyTrue" value="1" name="behind_proxy"> Behind Proxy
                            </label>
                        </div>
                        <p class="text-muted small">Useful for Cloudflare users (skips boot certificate check).</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: CONFIGURATION --}}
        <div class="col-sm-6">
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">settings</span> Configuration
                </div>
                <div class="card-body-theme">
                    
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="pDaemonBase" class="form-label">Daemon Server File Directory</label>
                            <input type="text" name="daemonBase" id="pDaemonBase" class="form-control" value="/var/lib/pterodactyl/volumes" />
                            <p class="text-muted small">Directory where server files will be stored.</p>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="pMemory" class="form-label">Total Memory</label>
                            <div class="input-group">
                                <input type="text" name="memory" data-multiplicator="true" class="form-control" id="pMemory" value="{{ old('memory') }}"/>
                                <span class="input-group-addon">MiB</span>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="pMemoryOverallocate" class="form-label">Memory Over-Allocation</label>
                            <div class="input-group">
                                <input type="text" name="memory_overallocate" class="form-control" id="pMemoryOverallocate" value="{{ old('memory_overallocate') }}"/>
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <p class="text-muted small">Enter <code>-1</code> to disable checking. Enter <code>0</code> to strictly enforce limits.</p>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-xs-12"><hr style="border-top: 1px solid var(--border-color); margin: 0 0 15px 0;"></div>

                        <div class="form-group col-md-6">
                            <label for="pDisk" class="form-label">Total Disk Space</label>
                            <div class="input-group">
                                <input type="text" name="disk" data-multiplicator="true" class="form-control" id="pDisk" value="{{ old('disk') }}"/>
                                <span class="input-group-addon">MiB</span>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="pDiskOverallocate" class="form-label">Disk Over-Allocation</label>
                            <div class="input-group">
                                <input type="text" name="disk_overallocate" class="form-control" id="pDiskOverallocate" value="{{ old('disk_overallocate') }}"/>
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-xs-12"><hr style="border-top: 1px solid var(--border-color); margin: 0 0 15px 0;"></div>

                        <div class="form-group col-md-6">
                            <label for="pDaemonListen" class="form-label">Daemon Port</label>
                            <input type="text" name="daemonListen" class="form-control" id="pDaemonListen" value="8080" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pDaemonSFTP" class="form-label">Daemon SFTP Port</label>
                            <input type="text" name="daemonSFTP" class="form-control" id="pDaemonSFTP" value="2022" />
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted small">Use <code>8443</code> for Cloudflare SSL proxying.</p>
                        </div>
                    </div>

                </div>
                
                {{-- FOOTER WITH SUBMIT --}}
                <div class="card-footer-theme">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn-primary-theme">Create Node</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $('#pLocationId').select2();
    </script>
@endsection

