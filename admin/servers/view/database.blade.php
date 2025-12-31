@extends('layouts.admin')

@section('title')
    Server — {{ $server->name }}: Databases
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
        display: flex; flex-direction: column; gap: 10px;
    }

    /* TABLE */
    .theme-table { width: 100%; border-collapse: collapse; }
    .theme-table th {
        text-align: left; padding: 12px 15px; color: var(--text-sub); font-size: 11px;
        text-transform: uppercase; border-bottom: 1px solid var(--border-color); font-weight: 700; letter-spacing: 0.05em;
    }
    .theme-table td {
        padding: 14px 15px; border-bottom: 1px solid var(--border-color);
        color: var(--text-main); vertical-align: middle; font-size: 14px;
    }
    .theme-table tr:hover { background-color: var(--input-bg); }
    .theme-table tr:last-child td { border-bottom: none; }

    /* ALERT STYLE */
    .alert-info-theme {
        background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3);
        color: #3b82f6; padding: 15px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;
    }
    .alert-info-theme a { color: inherit; text-decoration: underline; font-weight: bold; }

    /* FORM INPUTS */
    .form-control {
        background: var(--input-bg) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important; border-radius: 10px !important; height: 42px; box-shadow: none !important;
    }
    .form-control:focus { border-color: #6366f1 !important; background: var(--bg-card) !important; }
    label { color: var(--text-main); font-weight: 600; font-size: 13px; margin-bottom: 6px; }
    .text-muted { color: var(--text-sub) !important; font-size: 12px; margin-top: 5px; }

    /* INPUT GROUP (PREFIX) */
    .input-group .input-group-addon {
        background: var(--bg-app) !important; border: 1px solid var(--border-color) !important;
        color: var(--text-sub) !important; border-radius: 10px 0 0 10px !important; border-right: 0 !important;
        font-weight: 600; font-size: 13px;
    }
    .input-group .form-control { border-radius: 0 10px 10px 0 !important; }

    /* BUTTONS */
    .btn-icon {
        width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;
        border-radius: 8px; transition: 0.2s; border: 1px solid transparent; cursor: pointer; background: transparent;
    }
    .btn-primary-icon { color: #6366f1; background: rgba(99, 102, 241, 0.1); border-color: rgba(99, 102, 241, 0.2); }
    .btn-primary-icon:hover { background: #6366f1; color: #fff; }

    .btn-danger-icon { color: #ef4444; background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.2); }
    .btn-danger-icon:hover { background: #ef4444; color: #fff; }

    .btn-success-theme {
        background: #10b981; color: #fff; border: 1px solid #10b981;
        padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; width: 100%;
    }
    .btn-success-theme:hover { background: #059669; border-color: #059669; }

    /* SELECT2 FIX */
    .select2-container--default .select2-selection--single { background: var(--input-bg) !important; border: 1px solid var(--border-color) !important; height: 42px !important; border-radius: 10px !important; }
    .select2-selection__rendered { color: var(--text-main) !important; line-height: 40px !important; }
    .select2-selection__arrow { height: 40px !important; }
    .select2-dropdown { background: var(--bg-card) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; }

    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; font-family: 'Menlo', monospace; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>{{ $server->name }}</h1>
                    <small>Manage server databases.</small>
                </div>
                <span class="material-symbols-rounded" style="color: #6366f1; font-size: 30px;">dns</span>
            </div>
            
            {{-- NAVIGATION --}}
            <div class="nav-container-unified">
                @include('admin.servers.partials.navigation')
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- LIST DATABASES --}}
    <div class="col-sm-7">
        <div class="alert-info-theme">
            <span class="material-symbols-rounded">info</span>
            <span>Database passwords can be viewed when <a href="/server/{{ $server->uuidShort }}/databases">visiting this server</a> on the front-end.</span>
        </div>

        <div class="theme-card">
            <div class="card-header-theme">
                <span class="material-symbols-rounded" style="color: #6366f1;">database</span> Active Databases
            </div>
            <div class="table-responsive">
                <table class="theme-table">
                    <thead>
                        <tr>
                            <th>Database</th>
                            <th>Username</th>
                            <th>Connections</th>
                            <th>Host</th>
                            <th>Max</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($server->databases as $database)
                            <tr>
                                <td>{{ $database->database }}</td>
                                <td>{{ $database->username }}</td>
                                <td>{{ $database->remote }}</td>
                                <td><code>{{ $database->host->host }}:{{ $database->host->port }}</code></td>
                                <td>
                                    @if($database->max_connections != null)
                                        {{ $database->max_connections }}
                                    @else
                                        <span class="label" style="background:var(--badge-bg); color:var(--text-sub); border:1px solid var(--border-color); padding:2px 6px; border-radius:4px;">Unlimited</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <button data-action="reset-password" data-id="{{ $database->id }}" class="btn-icon btn-primary-icon" title="Reset Password">
                                        <span class="material-symbols-rounded" style="font-size: 18px;">lock_reset</span>
                                    </button>
                                    <button data-action="remove" data-id="{{ $database->id }}" class="btn-icon btn-danger-icon" title="Delete Database">
                                        <span class="material-symbols-rounded" style="font-size: 18px;">delete</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- CREATE DATABASE --}}
    <div class="col-sm-5">
        <div class="theme-card">
            <div class="card-header-theme">
                <span class="material-symbols-rounded" style="color: #10b981;">add_circle</span> Create New Database
            </div>
            <form action="{{ route('admin.servers.view.database', $server->id) }}" method="POST">
                <div class="card-body-theme">
                    <div class="form-group">
                        <label for="pDatabaseHostId" class="control-label">Database Host</label>
                        <select id="pDatabaseHostId" name="database_host_id" class="form-control">
                            @foreach($hosts as $host)
                                <option value="{{ $host->id }}">{{ $host->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-muted small">Server where the database will be created.</p>
                    </div>

                    <div class="form-group">
                        <label for="pDatabaseName" class="control-label">Database Name</label>
                        <div class="input-group">
                            <span class="input-group-addon">s{{ $server->id }}_</span>
                            <input id="pDatabaseName" type="text" name="database" class="form-control" placeholder="database" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pRemote" class="control-label">Connections From</label>
                        <input id="pRemote" type="text" name="remote" class="form-control" value="%" />
                        <p class="text-muted small">Allowed IP addresses (use <code>%</code> for wildcard).</p>
                    </div>

                    <div class="form-group">
                        <label for="pmax_connections" class="control-label">Max Connections</label>
                        <input id="pmax_connections" type="text" name="max_connections" class="form-control"/>
                        <p class="text-muted small">Leave empty for unlimited.</p>
                    </div>
                </div>
                <div class="card-footer-theme">
                    <p class="text-muted small no-margin" style="text-align: center;">Credentials will be auto-generated.</p>
                    {!! csrf_field() !!}
                    <input type="submit" class="btn-success-theme" value="Create Database" />
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#pDatabaseHostId').select2();

    $('[data-action="remove"]').click(function (event) {
        event.preventDefault();
        var self = $(this);
        swal({
            title: '',
            type: 'warning',
            text: 'Are you sure that you want to delete this database? There is no going back, all data will immediately be removed.',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            confirmButtonColor: '#ef4444',
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }, function () {
            $.ajax({
                method: 'DELETE',
                url: '/admin/servers/view/{{ $server->id }}/database/' + self.data('id') + '/delete',
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            }).done(function () {
                self.closest('tr').fadeOut();
                swal.close();
            }).fail(function (jqXHR) {
                console.error(jqXHR);
                swal({
                    type: 'error',
                    title: 'Whoops!',
                    text: (typeof jqXHR.responseJSON.error !== 'undefined') ? jqXHR.responseJSON.error : 'An error occurred while processing this request.'
                });
            });
        });
    });

    $('[data-action="reset-password"]').click(function (e) {
        e.preventDefault();
        var block = $(this);
        var icon = block.find('span'); // Material Icon element
        var originalIcon = icon.text(); // 'lock_reset'

        // Disable and Animate
        block.addClass('disabled');
        icon.text('sync').addClass('spin-anim'); // Change icon to 'sync' and spin

        $.ajax({
            type: 'PATCH',
            url: '/admin/servers/view/{{ $server->id }}/database',
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            data: { database: $(this).data('id') },
        }).done(function (data) {
            swal({
                type: 'success',
                title: '',
                text: 'The password for this database has been reset.',
            });
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error(jqXHR);
            var error = 'An error occurred while trying to process this request.';
            if (typeof jqXHR.responseJSON !== 'undefined' && typeof jqXHR.responseJSON.error !== 'undefined') {
                error = jqXHR.responseJSON.error;
            }
            swal({
                type: 'error',
                title: 'Whoops!',
                text: error
            });
        }).always(function () {
            // Restore button state
            block.removeClass('disabled');
            icon.removeClass('spin-anim').text(originalIcon);
        });
    });
    </script>

    <style>
        .spin-anim { animation: spin 1s linear infinite; }
        @keyframes spin { 100% { transform: rotate(360deg); } }
        .disabled { pointer-events: none; opacity: 0.7; }
    </style>
@endsection

