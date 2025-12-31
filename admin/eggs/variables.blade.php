@extends('layouts.admin')

@section('title')
    Egg &rarr; {{ $egg->name }} &rarr; Variables
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

    /* SUB-HEADER (VARIABLE CARD) */
    .card-header-theme {
        padding: 15px 24px;
        border-bottom: 1px solid var(--border-color);
        font-weight: 700; font-size: 15px; display: flex; align-items: center; gap: 8px; color: var(--text-main);
    }

    .card-body-theme { padding: 24px; }
    .card-footer-theme {
        padding: 15px 24px; background: var(--input-bg); border-top: 1px solid var(--border-color);
        display: flex; justify-content: space-between; align-items: center;
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
    .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }

    /* BUTTONS */
    .btn-simple {
        background: var(--btn-bg); color: var(--btn-text); border: 1px solid var(--btn-border);
        padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
        text-decoration: none !important; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-simple:hover { background: var(--btn-hover); border-color: var(--text-main); }
    
    .btn-primary-theme {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 8px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-primary-theme:hover { background: #374151; border-color: #374151; }

    .btn-danger-theme {
        background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;
        padding: 8px 16px; border-radius: 8px; font-weight: 600; transition: all 0.2s; display: inline-flex; align-items: center; gap: 5px;
    }
    .btn-danger-theme:hover { background: #b91c1c; color: #fff; border-color: #b91c1c; }

    /* MODAL STYLING */
    .modal-content {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .modal-header {
        border-bottom: 1px solid var(--border-color);
        padding: 20px 24px;
        background: var(--bg-card);
        border-radius: 16px 16px 0 0;
        color: var(--text-main);
    }
    .modal-title { font-weight: 700; font-size: 18px; margin: 0; }
    .modal-body { padding: 24px; background: var(--bg-card); color: var(--text-main); }
    .modal-footer {
        border-top: 1px solid var(--border-color);
        padding: 15px 24px;
        background: var(--input-bg);
        border-radius: 0 0 16px 16px;
        display: flex; justify-content: space-between;
    }
    .close { color: var(--text-sub); opacity: 0.7; text-shadow: none; }
    .close:hover { color: var(--text-main); opacity: 1; }

    /* SELECT2 MODAL FIX */
    .select2-container--default .select2-selection--multiple { background-color: var(--input-bg) !important; border: 1px solid var(--border-color) !important; border-radius: 10px !important; min-height: 42px !important; }
    .select2-container--default .select2-selection--multiple .select2-selection__choice { background-color: #e0e7ff !important; border: 1px solid #c7d2fe !important; color: #3730a3 !important; border-radius: 4px; }
    .select2-dropdown { background: var(--bg-card) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; }

    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; font-family: 'Menlo', monospace; }
    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>{{ $egg->name }}</h1>
                    <small>Manage Egg variables.</small>
                </div>
                <span class="material-symbols-rounded" style="color: #6366f1; font-size: 30px;">data_object</span>
            </div>
            
            {{-- NAVIGATION --}}
            <div style="margin-top: 20px;">
                <ul class="nav-pills-modern">
                    <li><a href="{{ route('admin.nests.egg.view', $egg->id) }}"><span class="material-symbols-rounded">settings</span> Configuration</a></li>
                    <li class="active"><a href="{{ route('admin.nests.egg.variables', $egg->id) }}"><span class="material-symbols-rounded">data_object</span> Variables</a></li>
                    <li><a href="{{ route('admin.nests.egg.scripts', $egg->id) }}"><span class="material-symbols-rounded">code</span> Install Script</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- ACTION BAR --}}
<div class="row">
    <div class="col-xs-12">
        <div class="theme-card" style="padding: 15px 24px; display:flex; justify-content: flex-end;">
            <button class="btn-simple" data-toggle="modal" data-target="#newVariableModal">
                <span class="material-symbols-rounded">add_circle</span> Create New Variable
            </button>
        </div>
    </div>
</div>

{{-- VARIABLES GRID --}}
<div class="row">
    @foreach($egg->variables as $variable)
        <div class="col-sm-6">
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="material-symbols-rounded" style="color: #6366f1;">variable_add</span> {{ $variable->name }}
                </div>
                <form action="{{ route('admin.nests.egg.variables.edit', ['egg' => $egg->id, 'variable' => $variable->id]) }}" method="POST">
                    <div class="card-body-theme">
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ $variable->name }}" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ $variable->description }}</textarea>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">Env Variable</label>
                                <input type="text" name="env_variable" value="{{ $variable->env_variable }}" class="form-control" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Default Value</label>
                                <input type="text" name="default_value" value="{{ $variable->default_value }}" class="form-control" />
                            </div>
                            <div class="col-xs-12">
                                <p class="text-muted small">Access via <code>{{ $variable->env_variable }}</code> in startup.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Permissions</label>
                            <select name="options[]" class="pOptions form-control" multiple>
                                <option value="user_viewable" {{ (! $variable->user_viewable) ?: 'selected' }}>Users Can View</option>
                                <option value="user_editable" {{ (! $variable->user_editable) ?: 'selected' }}>Users Can Edit</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Input Rules</label>
                            <input type="text" name="rules" class="form-control" value="{{ $variable->rules }}" />
                            <p class="text-muted small">Standard Laravel validation rules.</p>
                        </div>
                    </div>
                    <div class="card-footer-theme">
                        <button class="btn-danger-theme" name="_method" value="DELETE" type="submit" onclick="return confirm('Delete this variable?')">
                            <span class="material-symbols-rounded">delete</span> Delete
                        </button>
                        {!! csrf_field() !!}
                        <button class="btn-primary-theme" name="_method" value="PATCH" type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</div>

{{-- MODAL CREATE VARIABLE --}}
<div class="modal fade" id="newVariableModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create New Egg Variable</h4>
            </div>
            <form action="{{ route('admin.nests.egg.variables', $egg->id) }}" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Variable Name"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Description...">{{ old('description') }}</textarea>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Env Variable</label>
                            <input type="text" name="env_variable" class="form-control" value="{{ old('env_variable') }}" placeholder="SERVER_VAR"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Default Value</label>
                            <input type="text" name="default_value" class="form-control" value="{{ old('default_value') }}" placeholder="Default"/>
                        </div>
                        <div class="col-xs-12">
                            <p class="text-muted small">Access via <code>@{{Variable}}</code> in startup.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Permissions</label>
                        <select name="options[]" class="pOptions form-control" multiple>
                            <option value="user_viewable">Users Can View</option>
                            <option value="user_editable">Users Can Edit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Input Rules</label>
                        <input type="text" name="rules" class="form-control" value="{{ old('rules', 'required|string|max:20') }}" placeholder="required|string|max:20" />
                        <p class="text-muted small">Standard Laravel validation rules.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! csrf_field() !!}
                    <button type="button" class="btn-simple" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn-primary-theme">Create Variable</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $('.pOptions').select2();
    </script>
@endsection

