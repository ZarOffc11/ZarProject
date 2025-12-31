@extends('layouts.admin')

@section('title')
    Server — {{ $server->name }}: Build Details
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
        display: flex; justify-content: flex-end;
    }

    /* FORM INPUTS */
    .form-control {
        background: var(--input-bg) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important; border-radius: 10px !important; height: 42px; box-shadow: none !important;
    }
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    label { color: var(--text-main); font-weight: 600; font-size: 13px; margin-bottom: 6px; }
    .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }

    /* INPUT GROUPS (Suffix) */
    .input-group .form-control { border-radius: 10px 0 0 10px !important; }
    .input-group-addon {
        background: var(--bg-app) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-sub) !important; border-radius: 0 10px 10px 0 !important; border-left: 0 !important;
        font-weight: 600; font-size: 12px;
    }

    /* RADIO BUTTONS */
    .radio-group { display: flex; gap: 10px; margin-bottom: 5px; }
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

    /* SELECT2 FIX */
    .select2-container--default .select2-selection--single { background: var(--input-bg) !important; border: 1px solid var(--border-color) !important; height: 42px !important; border-radius: 10px !important; }
    .select2-selection__rendered { color: var(--text-main) !important; line-height: 40px !important; }
    .select2-selection__arrow { height: 40px !important; }
    .select2-container--default .select2-selection--multiple { background: var(--input-bg) !important; border: 1px solid var(--border-color) !important; min-height: 42px !important; border-radius: 10px !important; }
    .select2-selection__choice { background: #e0e7ff !important; border: 1px solid #c7d2fe !important; color: #3730a3 !important; border-radius: 4px; }
    .select2-dropdown { background: var(--bg-card) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; }

    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>{{ $server->name }}</h1>
                    <small>Control allocations and system resources.</small>
                </div>
                <span class="material-symbols-rounded" style="color: #6366f1; font-size: 30px;">dns</span>
            </div>
            
            <div class="nav-container-unified">
                @include('admin.servers.partials.navigation')
            </div>
        </div>
    </div>
</div>

<form action="{{ route('admin.servers.view.build', $server->id) }}" method="POST">
    <div class="row">
        {{-- LEFT COLUMN: RESOURCES --}}
        <div class="col-sm-5">
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">memory</span> Resource Management
                </div>
                <div class="card-body-theme">
                    <div class="form-group">
                        <label for="cpu" class="control-label">CPU Limit</label>
                        <div class="input-group">
                            <input type="text" name="cpu" class="form-control" value="{{ old('cpu', $server->cpu) }}"/>
                            <span class="input-group-addon">%</span>
                        </div>
                        <p class="text-muted small"><code>0</code> = unlimited.</p>
                    </div>

                    <div class="form-group">
                        <label for="threads" class="control-label">CPU Pinning</label>
                        <input type="text" name="threads" class="form-control" value="{{ old('threads', $server->threads) }}"/>
                        <p class="text-muted small">Specific cores (e.g. <code>0,1</code>) or empty for all.</p>
                    </div>

                    <div class="form-group">
                        <label for="memory" class="control-label">Allocated Memory</label>
                        <div class="input-group">
                            <input type="text" name="memory" data-multiplicator="true" class="form-control" value="{{ old('memory', $server->memory) }}"/>
                            <span class="input-group-addon">MiB</span>
                        </div>
                        <p class="text-muted small"><code>0</code> = unlimited.</p>
                    </div>

                    <div class="form-group">
                        <label for="swap" class="control-label">Allocated Swap</label>
                        <div class="input-group">
                            <input type="text" name="swap" data-multiplicator="true" class="form-control" value="{{ old('swap', $server->swap) }}"/>
                            <span class="input-group-addon">MiB</span>
                        </div>
                        <p class="text-muted small"><code>0</code> = disabled, <code>-1</code> = unlimited.</p>
                    </div>

                    <div class="form-group">
                        <label for="disk" class="control-label">Disk Space Limit</label>
                        <div class="input-group">
                            <input type="text" name="disk" class="form-control" value="{{ old('disk', $server->disk) }}"/>
                            <span class="input-group-addon">MiB</span>
                        </div>
                        <p class="text-muted small"><code>0</code> = unlimited.</p>
                    </div>

                    <div class="form-group">
                        <label for="io" class="control-label">Block IO Proportion</label>
                        <input type="text" name="io" class="form-control" value="{{ old('io', $server->io) }}"/>
                        <p class="text-muted small">IO performance relative to other containers (10-1000).</p>
                    </div>

                    <div class="form-group">
                        <label for="cpu" class="control-label">OOM Killer</label>
                        <div class="radio-group">
                            <label class="radio-label" for="pOomKillerEnabled" style="border-color: #fca5a5;">
                                <input type="radio" id="pOomKillerEnabled" value="0" name="oom_disabled" @if(!$server->oom_disabled)checked @endif> Enabled
                            </label>
                            <label class="radio-label" for="pOomKillerDisabled" style="border-color: #86efac;">
                                <input type="radio" id="pOomKillerDisabled" value="1" name="oom_disabled" @if($server->oom_disabled)checked @endif> Disabled
                            </label>
                        </div>
                        <p class="text-muted small">Enabling may cause processes to exit unexpectedly.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: LIMITS & ALLOCATION --}}
        <div class="col-sm-7">
            {{-- FEATURE LIMITS --}}
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">tune</span> Application Feature Limits
                </div>
                <div class="card-body-theme">
                    <div class="row">
                        <div class="form-group col-xs-4">
                            <label for="database_limit" class="control-label">Databases</label>
                            <input type="text" name="database_limit" class="form-control" value="{{ old('database_limit', $server->database_limit) }}"/>
                        </div>
                        <div class="form-group col-xs-4">
                            <label for="allocation_limit" class="control-label">Allocations</label>
                            <input type="text" name="allocation_limit" class="form-control" value="{{ old('allocation_limit', $server->allocation_limit) }}"/>
                        </div>
                        <div class="form-group col-xs-4">
                            <label for="backup_limit" class="control-label">Backups</label>
                            <input type="text" name="backup_limit" class="form-control" value="{{ old('backup_limit', $server->backup_limit) }}"/>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ALLOCATION MANAGEMENT --}}
            <div class="theme-card" style="margin-top: 20px;">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">network_check</span> Allocation Management
                </div>
                <div class="card-body-theme">
                    <div class="form-group">
                        <label for="pAllocation" class="control-label">Game Port (Default Connection)</label>
                        <select id="pAllocation" name="allocation_id" class="form-control">
                            @foreach ($assigned as $assignment)
                                <option value="{{ $assignment->id }}" @if($assignment->id === $server->allocation_id) selected="selected" @endif>{{ $assignment->alias }}:{{ $assignment->port }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pAddAllocations" class="control-label">Assign Additional Ports</label>
                        <select name="add_allocations[]" class="form-control" multiple id="pAddAllocations">
                            @foreach ($unassigned as $assignment)
                                <option value="{{ $assignment->id }}">{{ $assignment->alias }}:{{ $assignment->port }}</option>
                            @endforeach
                        </select>
                        <p class="text-muted small">Ports available on the node to assign to this server.</p>
                    </div>

                    <div class="form-group">
                        <label for="pRemoveAllocations" class="control-label">Remove Additional Ports</label>
                        <select name="remove_allocations[]" class="form-control" multiple id="pRemoveAllocations">
                            @foreach ($assigned as $assignment)
                                @if($assignment->id !== $server->allocation_id)
                                    <option value="{{ $assignment->id }}">{{ $assignment->alias }}:{{ $assignment->port }}</option>
                                @endif
                            @endforeach
                        </select>
                        <p class="text-muted small">Remove extra ports (Default Game Port cannot be removed).</p>
                    </div>
                </div>
                <div class="card-footer-theme">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn-primary-theme">Update Build Configuration</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#pAddAllocations').select2();
    $('#pRemoveAllocations').select2();
    $('#pAllocation').select2();
    </script>
@endsection

