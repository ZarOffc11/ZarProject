@extends('layouts.admin')

@section('title')
    {{ $node->name }}: Allocations
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

    .card-header-theme {
        padding: 15px 24px;
        border-bottom: 1px solid var(--border-color);
        font-weight: 700; font-size: 15px; display: flex; align-items: center; justify-content: space-between; gap: 8px; color: var(--text-main);
    }

    .card-body-theme { padding: 24px; }
    .card-footer-theme {
        padding: 15px 24px; background: var(--input-bg); border-top: 1px solid var(--border-color);
        display: flex; justify-content: center;
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

    /* INPUTS */
    .form-control {
        background: var(--input-bg) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important; border-radius: 10px !important; height: 42px; box-shadow: none !important;
    }
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    .input-sm { height: 32px !important; border-radius: 6px !important; padding: 4px 10px; font-size: 12px; }
    
    label { color: var(--text-main); font-weight: 600; font-size: 13px; margin-bottom: 6px; }
    .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }

    /* BUTTONS */
    .btn-simple {
        background: var(--btn-bg); color: var(--btn-text); border: 1px solid var(--btn-border);
        padding: 4px 10px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-size: 12px;
    }
    .btn-simple:hover { background: var(--btn-hover); border-color: var(--text-main); }
    
    .btn-primary-theme {
        background: #1f2937; color: #fff; border: 1px solid #1f2937;
        padding: 8px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-primary-theme:hover { background: #374151; border-color: #374151; }

    .btn-danger-icon { color: #ef4444; border: 1px solid transparent; padding: 4px; border-radius: 6px; transition: 0.2s; display: inline-flex; }
    .btn-danger-icon:hover { background: #fee2e2; border-color: #fecaca; }

    /* SELECT2 FIX */
    .select2-container--default .select2-selection--multiple { background-color: var(--input-bg) !important; border: 1px solid var(--border-color) !important; border-radius: 10px !important; min-height: 42px !important; }
    .select2-container--default .select2-selection--multiple .select2-selection__choice { background-color: #e0e7ff !important; border: 1px solid #c7d2fe !important; color: #3730a3 !important; border-radius: 4px; }
    .select2-dropdown { background-color: var(--bg-card) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; }

    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
    .input-loader { display: none; position: absolute; right: 25px; top: 18px; color: #6366f1; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>{{ $node->name }}</h1>
                    <small>Control allocations available for servers on this node.</small>
                </div>
                <span class="material-symbols-rounded" style="color: #6366f1; font-size: 30px;">hub</span>
            </div>
            
            <div style="margin-top: 20px;">
                <ul class="nav-pills-modern">
                    <li><a href="{{ route('admin.nodes.view', $node->id) }}"><span class="material-symbols-rounded">info</span> About</a></li>
                    <li><a href="{{ route('admin.nodes.view.settings', $node->id) }}"><span class="material-symbols-rounded">settings</span> Settings</a></li>
                    <li><a href="{{ route('admin.nodes.view.configuration', $node->id) }}"><span class="material-symbols-rounded">settings_applications</span> Configuration</a></li>
                    <li class="active"><a href="{{ route('admin.nodes.view.allocation', $node->id) }}"><span class="material-symbols-rounded">share_location</span> Allocation</a></li>
                    <li><a href="{{ route('admin.nodes.view.servers', $node->id) }}"><span class="material-symbols-rounded">dns</span> Servers</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- EXISTING ALLOCATIONS --}}
    <div class="col-sm-8">
        <div class="theme-card">
            <div class="card-header-theme">
                <span class="header-text"><span class="material-symbols-rounded" style="color: #6366f1;">list</span> Existing Allocations</span>
                
                {{-- Mass Action & IP Clean --}}
                <div style="display:flex; gap:10px; align-items:center;">
                    <div class="btn-group hidden-xs" style="display:inline-block;">
                        <button type="button" id="mass_actions" class="btn-simple dropdown-toggle disabled" data-toggle="dropdown" style="display:flex; align-items:center; gap:5px;">
                            Mass Actions <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-massactions" style="right:0; left:auto; background:var(--bg-card); border-color:var(--border-color);">
                            <li><a href="#" id="selective-deletion" data-action="selective-deletion" style="color:#ef4444;"><span class="material-symbols-rounded" style="font-size:16px;">delete</span> Delete Selected</a></li>
                        </ul>
                    </div>
                    
                    <button class="btn-simple" data-toggle="modal" data-target="#allocationModal" title="Delete Block">
                        <span class="material-symbols-rounded">delete_sweep</span>
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="theme-table" id="file_listing">
                    <thead>
                        <tr>
                            <th style="width: 40px;">
                                <input type="checkbox" class="select-all-files hidden-xs" data-action="selectAll">
                            </th>
                            <th>IP Address</th>
                            <th>Alias</th>
                            <th>Port</th>
                            <th>Assigned To</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($node->allocations as $allocation)
                            <tr>
                                <td class="middle" data-identifier="type">
                                    @if(is_null($allocation->server_id))
                                        <input type="checkbox" class="select-file hidden-xs" data-action="addSelection">
                                    @else
                                        <input disabled="disabled" type="checkbox" class="select-file hidden-xs" data-action="addSelection">
                                    @endif
                                </td>
                                <td class="middle" data-identifier="ip">{{ $allocation->ip }}</td>
                                <td class="middle" style="position:relative;">
                                    <input class="form-control input-sm" type="text" value="{{ $allocation->ip_alias }}" data-action="set-alias" data-id="{{ $allocation->id }}" placeholder="none" />
                                    <span class="input-loader"><span class="material-symbols-rounded" style="font-size:16px; animation:spin 2s linear infinite;">sync</span></span>
                                </td>
                                <td class="middle" data-identifier="port">{{ $allocation->port }}</td>
                                <td class="middle">
                                    @if(! is_null($allocation->server))
                                        <a href="{{ route('admin.servers.view', $allocation->server_id) }}" style="color:#6366f1; font-weight:600;">{{ $allocation->server->name }}</a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="middle text-right">
                                    @if(is_null($allocation->server_id))
                                        <button data-action="deallocate" data-id="{{ $allocation->id }}" class="btn-danger-icon">
                                            <span class="material-symbols-rounded">delete</span>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($node->allocations->hasPages())
                <div class="card-footer-theme">
                    {{ $node->allocations->render() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ASSIGN NEW ALLOCATIONS --}}
    <div class="col-sm-4">
        <form action="{{ route('admin.nodes.view.allocation', $node->id) }}" method="POST">
            <div class="theme-card">
                <div class="card-header-theme">
                    <span class="header-text"><span class="material-symbols-rounded" style="color: #10b981;">add_circle</span> Assign Allocations</span>
                </div>
                <div class="card-body-theme">
                    <div class="form-group">
                        <label for="pAllocationIP" class="control-label">IP Address</label>
                        <select class="form-control" name="allocation_ip" id="pAllocationIP" multiple>
                            @foreach($allocations as $allocation)
                                <option value="{{ $allocation->ip }}">{{ $allocation->ip }}</option>
                            @endforeach
                        </select>
                        <p class="text-muted small">Select IP addresses to assign ports to.</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="pAllocationAlias" class="control-label">IP Alias</label>
                        <input type="text" id="pAllocationAlias" class="form-control" name="allocation_alias" placeholder="e.g. node.example.com" />
                        <p class="text-muted small">Optional default alias for these allocations.</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="pAllocationPorts" class="control-label">Ports</label>
                        <select class="form-control" name="allocation_ports[]" id="pAllocationPorts" multiple></select>
                        <p class="text-muted small">Enter ports (e.g. <code>25565</code>, <code>8000-8100</code>).</p>
                    </div>
                </div>
                <div class="card-footer-theme">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn-primary-theme">Assign Allocations</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- MODAL DELETE ALLOCATION BLOCK --}}
<div class="modal fade" id="allocationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background: var(--bg-card); color: var(--text-main);">
            <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: var(--text-main);"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete Allocations Block</h4>
            </div>
            <form action="{{ route('admin.nodes.view.allocation.removeBlock', $node->id) }}" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Select IP Block</label>
                            <select class="form-control" name="ip">
                                @foreach($allocations as $allocation)
                                    <option value="{{ $allocation->ip }}">{{ $allocation->ip }}</option>
                                @endforeach
                            </select>
                            <p class="text-muted small" style="margin-top:10px;">This will remove all unused allocations assigned to this IP.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--border-color); background: var(--input-bg);">
                    {{{ csrf_field() }}}
                    <button type="button" class="btn-simple" data-dismiss="modal" style="float:left;">Close</button>
                    <button type="submit" class="btn-danger-icon" style="padding: 8px 16px; background: #ef4444; color: #fff;">Delete Allocations</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    // --- JS LOGIC (SAME FUNCTIONALITY, UPDATED UI) ---
    
    $('[data-action="addSelection"]').on('click', function () {
        updateMassActions();
    });

    $('[data-action="selectAll"]').on('click', function () {
        $('input.select-file').not(':disabled').prop('checked', function (i, val) {
            return !val;
        });
        updateMassActions();
    });

    $('[data-action="selective-deletion"]').on('mousedown', function () {
        deleteSelected();
    });

    $('#pAllocationIP').select2({
        tags: true,
        maximumSelectionLength: 1,
        selectOnClose: true,
        tokenSeparators: [',', ' '],
    });

    $('#pAllocationPorts').select2({
        tags: true,
        selectOnClose: true,
        tokenSeparators: [',', ' '],
    });

    $('button[data-action="deallocate"]').click(function (event) {
        event.preventDefault();
        var element = $(this);
        var allocation = $(this).data('id');
        swal({
            title: '',
            text: 'Are you sure you want to delete this allocation?',
            type: 'warning',
            showCancelButton: true,
            allowOutsideClick: true,
            closeOnConfirm: false,
            confirmButtonText: 'Delete',
            confirmButtonColor: '#d9534f',
            showLoaderOnConfirm: true
        }, function () {
            $.ajax({
                method: 'DELETE',
                url: '/admin/nodes/view/' + {{ $node->id }} + '/allocation/remove/' + allocation,
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            }).done(function (data) {
                element.closest('tr').fadeOut();
                swal({ type: 'success', title: 'Port Deleted!' });
            }).fail(function (jqXHR) {
                console.error(jqXHR);
                swal({
                    title: 'Whoops!',
                    text: jqXHR.responseJSON.error,
                    type: 'error'
                });
            });
        });
    });

    var typingTimer;
    $('input[data-action="set-alias"]').keyup(function () {
        clearTimeout(typingTimer);
        $(this).css('border-color', 'var(--border-color)');
        typingTimer = setTimeout(sendAlias, 500, $(this));
    });

    var fadeTimers = [];
    function sendAlias(element) {
        element.parent().find('.input-loader').show();
        clearTimeout(fadeTimers[element.data('id')]);
        $.ajax({
            method: 'POST',
            url: '/admin/nodes/view/' + {{ $node->id }} + '/allocation/alias',
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            data: {
                alias: element.val(),
                allocation_id: element.data('id'),
            }
        }).done(function () {
            element.css('border-color', '#10b981'); // Green border
        }).fail(function (jqXHR) {
            console.error(jqXHR);
            element.css('border-color', '#ef4444'); // Red border
        }).always(function () {
            element.parent().find('.input-loader').hide();
            fadeTimers[element.data('id')] = setTimeout(clearHighlight, 2500, element);
        });
    }

    function clearHighlight(element) {
        element.css('border-color', 'var(--border-color)');
    }

    function updateMassActions() {
        if ($('input.select-file:checked').length > 0) {
            $('#mass_actions').removeClass('disabled');
        } else {
            $('#mass_actions').addClass('disabled');
        }
    }

    function deleteSelected() {
        var selectedIds = [];
        var selectedItems = [];
        var selectedItemsElements = [];

        $('input.select-file:checked').each(function () {
            var $parent = $($(this).closest('tr'));
            var id = $parent.find('[data-action="deallocate"]').data('id');
            var $ip = $parent.find('td[data-identifier="ip"]');
            var $port = $parent.find('td[data-identifier="port"]');
            var block = `${$ip.text()}:${$port.text()}`;

            selectedIds.push({ id: id });
            selectedItems.push(block);
            selectedItemsElements.push($parent);
        });

        if (selectedItems.length !== 0) {
            var formattedItems = "";
            var i = 0;
            $.each(selectedItems, function (key, value) {
                formattedItems += ("<code>" + value + "</code>, ");
                i++;
                return i < 5;
            });

            formattedItems = formattedItems.slice(0, -2);
            if (selectedItems.length > 5) {
                formattedItems += ', and ' + (selectedItems.length - 5) + ' other(s)';
            }

            swal({
                type: 'warning',
                title: '',
                text: 'Are you sure you want to delete the following allocations: ' + formattedItems + '?',
                html: true,
                showCancelButton: true,
                showConfirmButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                $.ajax({
                    method: 'DELETE',
                    url: '/admin/nodes/view/' + {{ $node->id }} + '/allocations',
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    data: JSON.stringify({ allocations: selectedIds }),
                    contentType: 'application/json',
                    processData: false
                }).done(function () {
                    $('#file_listing input:checked').each(function () {
                        $(this).prop('checked', false);
                    });

                    $.each(selectedItemsElements, function () {
                        $(this).fadeOut();
                    });

                    swal({
                        type: 'success',
                        title: 'Allocations Deleted'
                    });
                }).fail(function (jqXHR) {
                    console.error(jqXHR);
                    swal({
                        type: 'error',
                        title: 'Whoops!',
                        html: true,
                        text: 'An error occurred while attempting to delete these allocations.',
                    });
                });
            });
        }
    }
    </script>
@endsection

