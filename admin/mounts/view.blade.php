@extends('layouts.admin')

@section('title')
    Mounts &rarr; View &rarr; {{ $mount->name }}
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

    /* SUB-HEADER */
    .card-header-theme {
        padding: 15px 24px;
        border-bottom: 1px solid var(--border-color);
        font-weight: 700; font-size: 15px; display: flex; align-items: center; justify-content: space-between; gap: 8px; color: var(--text-main);
    }

    .card-body-theme { padding: 24px; }
    .card-footer-theme {
        padding: 15px 24px; background: var(--input-bg); border-top: 1px solid var(--border-color);
        display: flex; justify-content: space-between;
    }

    /* TABLE */
    .theme-table { width: 100%; border-collapse: collapse; }
    .theme-table th {
        text-align: left; padding: 12px 15px; color: var(--text-sub); font-size: 11px;
        text-transform: uppercase; border-bottom: 1px solid var(--border-color); font-weight: 700; letter-spacing: 0.05em;
    }
    .theme-table td {
        padding: 12px 15px; border-bottom: 1px solid var(--border-color);
        color: var(--text-main); vertical-align: middle; font-size: 14px;
    }
    .theme-table tr:hover { background-color: var(--input-bg); }
    .theme-table tr:last-child td { border-bottom: none; }

    /* FORM INPUTS */
    .form-control {
        background: var(--input-bg) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important; border-radius: 10px !important; height: 42px; box-shadow: none !important;
    }
    textarea.form-control { height: auto !important; }
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    .form-control:disabled { opacity: 0.7; cursor: not-allowed; }
    label { color: var(--text-main); font-weight: 600; font-size: 13px; margin-bottom: 6px; }

    /* BUTTONS */
    .btn-simple {
        background: var(--btn-bg); color: var(--btn-text); border: 1px solid var(--btn-border);
        padding: 4px 10px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-size: 12px; display: inline-flex; align-items: center; gap: 5px;
    }
    .btn-simple:hover { background: var(--btn-hover); border-color: var(--text-main); }
    
    .btn-primary-theme {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 8px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-primary-theme:hover { background: #374151; border-color: #374151; }

    .btn-danger-theme {
        background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;
        padding: 8px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-danger-theme:hover { background: #b91c1c; color: #fff; border-color: #b91c1c; }

    .btn-danger-icon {
        color: #ef4444; border: 1px solid transparent; padding: 4px; border-radius: 6px; transition: 0.2s; display: inline-flex;
    }
    .btn-danger-icon:hover { background: #fee2e2; border-color: #fecaca; }

    /* RADIO BUTTONS CUSTOM */
    .radio-group { display: flex; gap: 10px; margin-bottom: 5px; }
    .radio-label {
        display: flex; align-items: center; gap: 8px; cursor: pointer; margin: 0; 
        font-weight: 500; font-size: 13px; color: var(--text-main);
        padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 8px; background: var(--input-bg); transition: 0.2s; flex: 1;
    }
    .radio-label:hover { border-color: #6366f1; }
    input[type="radio"] { margin: 0; accent-color: #6366f1; transform: scale(1.1); }

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
    .select2-dropdown { background-color: var(--bg-card) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; }

    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; font-family: 'Menlo', monospace; }
    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    {{-- LEFT COLUMN: MOUNT DETAILS --}}
    <div class="col-sm-6">
        <form action="{{ route('admin.mounts.view', $mount->id) }}" method="POST">
            <div class="theme-card">
                <div class="card-header-unified">
                    <div class="header-title">
                        <h1>{{ $mount->name }}</h1>
                        <small>{{ str_limit($mount->description, 60) }}</small>
                    </div>
                    <span class="material-symbols-rounded" style="color: #6366f1; font-size: 30px;">folder_zip</span>
                </div>
                
                <div class="card-body-theme">
                    <div class="form-group">
                        <label for="PUniqueID" class="form-label">Unique ID</label>
                        <input type="text" id="PUniqueID" class="form-control" value="{{ $mount->uuid }}" disabled />
                    </div>

                    <div class="form-group">
                        <label for="pName" class="form-label">Name</label>
                        <input type="text" id="pName" name="name" class="form-control" value="{{ $mount->name }}" />
                    </div>

                    <div class="form-group">
                        <label for="pDescription" class="form-label">Description</label>
                        <textarea id="pDescription" name="description" class="form-control" rows="4">{{ $mount->description }}</textarea>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="pSource" class="form-label">Source</label>
                            <input type="text" id="pSource" name="source" class="form-control" value="{{ $mount->source }}" />
                        </div>

                        <div class="form-group col-md-6">
                            <label for="pTarget" class="form-label">Target</label>
                            <input type="text" id="pTarget" name="target" class="form-control" value="{{ $mount->target }}" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label">Read Only</label>
                            <div class="radio-group">
                                <label class="radio-label" for="pReadOnlyFalse">
                                    <input type="radio" id="pReadOnlyFalse" name="read_only" value="0" @if(!$mount->read_only) checked @endif> False
                                </label>
                                <label class="radio-label" for="pReadOnly">
                                    <input type="radio" id="pReadOnly" name="read_only" value="1" @if($mount->read_only) checked @endif> True
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="form-label">User Mountable</label>
                            <div class="radio-group">
                                <label class="radio-label" for="pUserMountableFalse">
                                    <input type="radio" id="pUserMountableFalse" name="user_mountable" value="0" @if(!$mount->user_mountable) checked @endif> False
                                </label>
                                <label class="radio-label" for="pUserMountable">
                                    <input type="radio" id="pUserMountable" name="user_mountable" value="1" @if($mount->user_mountable) checked @endif> True
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer-theme">
                    {!! csrf_field() !!}
                    {!! method_field('PATCH') !!}
                    <button name="action" value="delete" class="btn-danger-theme" onclick="return confirm('Are you sure you want to delete this mount?')">Delete</button>
                    <button name="action" value="edit" class="btn-primary-theme">Save Changes</button>
                </div>
            </div>
        </form>
    </div>

    {{-- RIGHT COLUMN: EGGS & NODES --}}
    <div class="col-sm-6">
        
        {{-- EGGS LIST --}}
        <div class="theme-card">
            <div class="card-header-theme">
                <span style="display:flex; align-items:center; gap:5px;"><span class="material-symbols-rounded" style="color:#6366f1;">egg</span> Eggs</span>
                <button class="btn-simple" data-toggle="modal" data-target="#addEggsModal">
                    <span class="material-symbols-rounded" style="font-size:16px;">add</span> Add
                </button>
            </div>
            <div class="table-responsive">
                <table class="theme-table">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th></th>
                    </tr>
                    @foreach ($mount->eggs as $egg)
                        <tr>
                            <td class="middle"><code>{{ $egg->id }}</code></td>
                            <td class="middle">
                                <a href="{{ route('admin.nests.egg.view', $egg->id) }}" style="color:#6366f1; font-weight:600;">{{ $egg->name }}</a>
                            </td>
                            <td class="middle text-right">
                                <button data-action="detach-egg" data-id="{{ $egg->id }}" class="btn-danger-icon">
                                    <span class="material-symbols-rounded">close</span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        {{-- NODES LIST --}}
        <div class="theme-card">
            <div class="card-header-theme">
                <span style="display:flex; align-items:center; gap:5px;"><span class="material-symbols-rounded" style="color:#6366f1;">hub</span> Nodes</span>
                <button class="btn-simple" data-toggle="modal" data-target="#addNodesModal">
                    <span class="material-symbols-rounded" style="font-size:16px;">add</span> Add
                </button>
            </div>
            <div class="table-responsive">
                <table class="theme-table">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>FQDN</th>
                        <th></th>
                    </tr>
                    @foreach ($mount->nodes as $node)
                        <tr>
                            <td class="middle"><code>{{ $node->id }}</code></td>
                            <td class="middle">
                                <a href="{{ route('admin.nodes.view', $node->id) }}" style="color:#6366f1; font-weight:600;">{{ $node->name }}</a>
                            </td>
                            <td class="middle"><code>{{ $node->fqdn }}</code></td>
                            <td class="middle text-right">
                                <button data-action="detach-node" data-id="{{ $node->id }}" class="btn-danger-icon">
                                    <span class="material-symbols-rounded">close</span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

    </div>
</div>

{{-- MODAL ADD EGGS --}}
<div class="modal fade" id="addEggsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.mounts.eggs', $mount->id) }}" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Eggs</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="pEggs">Select Eggs</label>
                        <select id="pEggs" name="eggs[]" class="form-control" multiple>
                            @foreach ($nests as $nest)
                                <optgroup label="{{ $nest->name }}">
                                    @foreach ($nest->eggs as $egg)
                                        @if (! in_array($egg->id, $mount->eggs->pluck('id')->toArray()))
                                            <option value="{{ $egg->id }}">{{ $egg->name }}</option>
                                        @endif
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! csrf_field() !!}
                    <button type="button" class="btn-simple" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-theme">Add Eggs</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL ADD NODES --}}
<div class="modal fade" id="addNodesModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.mounts.nodes', $mount->id) }}" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Nodes</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="pNodes">Select Nodes</label>
                        <select id="pNodes" name="nodes[]" class="form-control" multiple>
                            @foreach ($locations as $location)
                                <optgroup label="{{ $location->long }} ({{ $location->short }})">
                                    @foreach ($location->nodes as $node)
                                        @if (! in_array($node->id, $mount->nodes->pluck('id')->toArray()))
                                            <option value="{{ $node->id }}">{{ $node->name }}</option>
                                        @endif
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! csrf_field() !!}
                    <button type="button" class="btn-simple" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-theme">Add Nodes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('#pEggs').select2({ placeholder: 'Select eggs..' });
            $('#pNodes').select2({ placeholder: 'Select nodes..' });

            $('button[data-action="detach-egg"]').click(function (event) {
                event.preventDefault();
                const element = $(this);
                const eggId = $(this).data('id');
                $.ajax({
                    method: 'DELETE',
                    url: '/admin/mounts/' + {{ $mount->id }} + '/eggs/' + eggId,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                }).done(function () {
                    element.closest('tr').fadeOut();
                    swal({ type: 'success', title: 'Egg detached.' });
                }).fail(function (jqXHR) {
                    console.error(jqXHR);
                    swal({ title: 'Whoops!', text: jqXHR.responseJSON.error, type: 'error' });
                });
            });

            $('button[data-action="detach-node"]').click(function (event) {
                event.preventDefault();
                const element = $(this);
                const nodeId = $(this).data('id');
                $.ajax({
                    method: 'DELETE',
                    url: '/admin/mounts/' + {{ $mount->id }} + '/nodes/' + nodeId,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                }).done(function () {
                    element.closest('tr').fadeOut();
                    swal({ type: 'success', title: 'Node detached.' });
                }).fail(function (jqXHR) {
                    console.error(jqXHR);
                    swal({ title: 'Whoops!', text: jqXHR.responseJSON.error, type: 'error' });
                });
            });
        });
    </script>
@endsection

