@extends('layouts.admin')

@section('title')
    New Server
@endsection

@section('content-header')
@endsection

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<style>
    /* LOCAL VARS (SPECIFIC) */
    :root {
        --btn-bg: #ffffff; --btn-text: #1f2937; --btn-border: #d1d5db; --btn-hover: #f3f4f6;
    }
    body.dark-mode {
        --btn-bg: #1b1e24; --btn-text: #e2e8f0; --btn-border: #4a5568; --btn-hover: #2d3748;
    }

    .content { padding-top: 10px !important; }

    /* CARD & FORM */
    .theme-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; margin-top: 10px; margin-bottom: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02); overflow: hidden; }
    
    .card-header-unified {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .header-title h1 { font-size: 20px; font-weight: 800; margin: 0; color: var(--text-main); letter-spacing: -0.5px; }
    .header-title small { display: block; font-size: 13px; color: var(--text-sub); margin-top: 4px; font-weight: 500; }

    .card-section-head { padding: 15px 24px; border-bottom: 1px solid var(--border-color); font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 8px; color: var(--text-main); background: rgba(0,0,0,0.02); }
    .card-body-theme { padding: 24px; }
    
    label { color: var(--text-main); font-weight: 600; font-size: 13px; margin-bottom: 6px; }
    .form-control {
        background: var(--input-bg) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important; border-radius: 10px !important; height: 40px; box-shadow: none !important;
    }
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    .help-block, .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }
    .input-group-addon { background: var(--bg-app) !important; border: 1px solid var(--border-color) !important; color: var(--text-sub) !important; border-radius: 0 10px 10px 0; }
    
    /* Select2 */
    .select2-selection--single { background: var(--input-bg) !important; border: 1px solid var(--border-color) !important; height: 40px !important; border-radius: 10px !important; }
    .select2-selection__rendered { color: var(--text-main) !important; line-height: 40px !important; }
    .select2-selection__arrow { height: 40px !important; }
    .select2-dropdown { background: var(--bg-card) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; }

    /* BUTTONS */
    .btn-simple {
        background: var(--btn-bg); color: var(--btn-text); border: 1px solid var(--btn-border);
        padding: 8px 16px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.2s;
        text-decoration: none !important; display: inline-flex; align-items: center; gap: 8px; font-size: 13px;
    }
    .btn-simple:hover { background: var(--btn-hover); border-color: var(--text-main); }
    
    .material-symbols-rounded { font-size: 18px; }
</style>

<form action="{{ route('admin.servers.new') }}" method="POST">
    
    <div class="row">
        <div class="col-xs-12">
            <div class="theme-card">
                <div class="card-header-unified">
                    <div class="header-title">
                        <h1>Create Server</h1>
                        <small>Add new server to panel</small>
                    </div>
                    {{-- TOMBOL THEME DIHAPUS --}}
                </div>

                <div class="card-section-head"><span class="material-symbols-rounded" style="color:#6366f1">settings</span> Core Details</div>
                <div class="card-body-theme row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Server Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="e.g. My Awesome Server">
                        </div>
                        <div class="form-group">
                            <label>Server Owner</label>
                            <select id="pUserId" name="owner_id" class="form-control"></select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" rows="3" class="form-control" placeholder="Optional...">{{ old('description') }}</textarea>
                        </div>
                        <div class="checkbox checkbox-primary" style="margin-top: 15px;">
                            <input id="pStart" name="start_on_completion" type="checkbox" checked />
                            <label for="pStart" style="color:var(--text-main); font-weight:500;">Start server after installation</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Allocation --}}
    <div class="row">
        <div class="col-xs-12">
            <div class="theme-card">
                <div class="card-section-head"><span class="material-symbols-rounded" style="color:#6366f1">hub</span> Network & Allocation</div>
                <div class="card-body-theme row">
                    <div class="form-group col-sm-4">
                        <label>Node</label>
                        <select name="node_id" id="pNodeId" class="form-control">
                            @foreach($locations as $location)
                                <optgroup label="{{ $location->long }}">
                                @foreach($location->nodes as $node)
                                <option value="{{ $node->id }}" @if($location->id === old('location_id')) selected @endif>{{ $node->name }}</option>
                                @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Default Connection</label>
                        <select id="pAllocation" name="allocation_id" class="form-control"></select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Additional Ports</label>
                        <select id="pAllocationAdditional" name="allocation_additional[]" class="form-control" multiple></select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Resources --}}
    <div class="row">
        <div class="col-xs-12">
            <div class="theme-card">
                <div class="card-section-head"><span class="material-symbols-rounded" style="color:#6366f1">memory</span> Resource Limits</div>
                <div class="card-body-theme row">
                    <div class="col-xs-6 form-group">
                        <label>Memory (MB)</label>
                        <input type="text" name="memory" class="form-control" value="{{ old('memory') }}">
                        <p class="text-muted small">Set to 0 for unlimited.</p>
                    </div>
                    <div class="col-xs-6 form-group">
                        <label>Disk Space (MB)</label>
                        <input type="text" name="disk" class="form-control" value="{{ old('disk') }}">
                        <p class="text-muted small">Set to 0 for unlimited.</p>
                    </div>
                    <div class="col-xs-6 form-group">
                        <label>CPU Limit (%)</label>
                        <input type="text" name="cpu" class="form-control" value="{{ old('cpu', 0) }}">
                    </div>
                    <div class="col-xs-6 form-group">
                        <label>Swap (MB)</label>
                        <input type="text" name="swap" class="form-control" value="{{ old('swap', 0) }}">
                    </div>
                    
                    <div class="col-xs-12"><hr style="border-top:1px solid var(--border-color);"></div>

                    <div class="col-xs-4 form-group"><label>Databases</label><input type="text" name="database_limit" class="form-control" value="0"></div>
                    <div class="col-xs-4 form-group"><label>Allocations</label><input type="text" name="allocation_limit" class="form-control" value="0"></div>
                    <div class="col-xs-4 form-group"><label>Backups</label><input type="text" name="backup_limit" class="form-control" value="0"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Nest & Docker --}}
    <div class="row">
        <div class="col-md-6">
            <div class="theme-card">
                <div class="card-section-head"><span class="material-symbols-rounded" style="color:#6366f1">category</span> Service Configuration</div>
                <div class="card-body-theme">
                    <div class="form-group">
                        <label>Nest</label>
                        <select id="pNestId" name="nest_id" class="form-control">
                            @foreach($nests as $nest)
                                <option value="{{ $nest->id }}" @if($nest->id === old('nest_id')) selected @endif>{{ $nest->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Egg</label>
                        <select id="pEggId" name="egg_id" class="form-control"></select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="theme-card">
                <div class="card-section-head"><span class="material-symbols-rounded" style="color:#6366f1">layers</span> Docker Configuration</div>
                <div class="card-body-theme">
                    <div class="form-group">
                        <label>Docker Image</label>
                        <select id="pDefaultContainer" name="image" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label>Startup Command</label>
                        <input type="text" id="pStartup" name="startup" value="{{ old('startup') }}" class="form-control" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="appendVariablesTo"></div>

    <div class="row">
        <div class="col-xs-12">
            <div class="theme-card" style="padding: 20px; background: var(--bg-card); display: flex; justify-content: flex-end; align-items: center;">
                {!! csrf_field() !!}
                <button type="submit" class="btn-simple" style="background: #1f2937; color: #fff; border:none; padding: 12px 24px;">
                    Create Server
                </button>
            </div>
        </div>
    </div>
</form>

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}
    <script>
        // JS THEME TOGGLE DIHAPUS (SUDAH GLOBAL)
        function serviceVariablesUpdated(eggId, ids) {
            @if (old('egg_id'))
                if (eggId != '{{ old('egg_id') }}') return;
                @if (old('environment'))
                    @foreach (old('environment') as $key => $value)
                        $('#' + ids['{{ $key }}']).val('{{ $value }}');
                    @endforeach
                @endif
            @endif
            @if(old('image')) $('#pDefaultContainer').val('{{ old('image') }}'); @endif
        }
    </script>
    {!! Theme::js('js/admin/new-server.js?v=20220530') !!}
    <script>
        $(document).ready(function() {
            @if (old('owner_id'))
                $.ajax({ url: '/admin/users/accounts.json?user_id={{ old('owner_id') }}', dataType: 'json' }).then(function (data) { initUserIdSelect([ data ]); });
            @else initUserIdSelect(); @endif
            @if (old('node_id'))
                $('#pNodeId').val('{{ old('node_id') }}').change();
                @if (old('allocation_id')) $('#pAllocation').val('{{ old('allocation_id') }}').change(); @endif
                @if (old('allocation_additional'))
                    const additional_allocations = [];
                    @for ($i = 0; $i < count(old('allocation_additional')); $i++) additional_allocations.push('{{ old('allocation_additional.'.$i)}}'); @endfor
                    $('#pAllocationAdditional').val(additional_allocations).change();
                @endif
            @endif
            @if (old('nest_id'))
                $('#pNestId').val('{{ old('nest_id') }}').change();
                @if (old('egg_id')) $('#pEggId').val('{{ old('egg_id') }}').change(); @endif
            @endif
        });
    </script>
@endsection
@endsection

