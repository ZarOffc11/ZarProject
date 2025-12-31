@extends('layouts.admin')

@section('title')
    Application API
@endsection

@section('content-header')
    {{-- Header Kosong (Unified) --}}
@endsection

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<style>
    /* === LOCAL STYLE OVERRIDES === */
    :root {
        --btn-bg: #ffffff; --btn-text: #1f2937; --btn-border: #d1d5db; --btn-hover: #f3f4f6; --badge-bg: #f3f4f6;
    }
    body.dark-mode {
        --btn-bg: #1b1e24; --btn-text: #e2e8f0; --btn-border: #4a5568; --btn-hover: #2d3748; --badge-bg: #2a2e36;
    }

    .content { padding-top: 10px !important; }
    .content-header { padding: 0 !important; margin-bottom: 15px !important; background: transparent !important; border: none !important; height: auto !important; }

    /* CARD STYLE */
    .theme-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        margin-bottom: 20px;
        overflow: hidden;
        margin-top: 10px;
    }
    .card-header-unified {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex; justify-content: space-between; align-items: center;
    }
    .header-title h1 { font-size: 20px; font-weight: 800; margin: 0; color: var(--text-main); letter-spacing: -0.5px; }
    .header-title small { display: block; font-size: 13px; color: var(--text-sub); margin-top: 4px; font-weight: 500; }

    /* TABLE STYLE */
    .theme-table { width: 100%; border-collapse: collapse; }
    .theme-table th {
        text-align: left; padding: 12px 24px; color: var(--text-sub); font-size: 11px;
        text-transform: uppercase; border-bottom: 1px solid var(--border-color); font-weight: 700; letter-spacing: 0.05em;
    }
    .theme-table td {
        padding: 14px 24px; border-bottom: 1px solid var(--border-color);
        color: var(--text-main); vertical-align: middle; font-size: 14px;
    }
    .theme-table tr:hover { background-color: var(--input-bg); }
    .theme-table tr:last-child td { border-bottom: none; }

    /* COMPONENTS */
    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 4px 8px; border-radius: 6px; font-family: 'Menlo', monospace; font-size: 12px; }
    
    /* BUTTONS */
    .btn-simple {
        background: var(--btn-bg); color: var(--btn-text); border: 1px solid var(--btn-border);
        padding: 8px 16px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.2s;
        text-decoration: none !important; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-simple:hover { background: var(--btn-hover); border-color: var(--text-main); }

    .btn-icon-danger { color: #ef4444; padding: 5px; border-radius: 6px; transition: 0.2s; display: inline-flex; }
    .btn-icon-danger:hover { background: #fee2e2; }

    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

    <div class="row">
        <div class="col-xs-12">
            <div class="theme-card">
                {{-- HEADER UNIFIED --}}
                <div class="card-header-unified">
                    <div class="header-title">
                        <h1>Application API</h1>
                        <small>Manage access credentials for this panel.</small>
                    </div>
                    
                    {{-- Create Button --}}
                    <a href="{{ route('admin.api.new') }}" class="btn-simple">
                        <span class="material-symbols-rounded">add_circle</span> Create New
                    </a>
                </div>

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="theme-table">
                        <thead>
                            <tr>
                                <th>API Key</th>
                                <th>Memo</th>
                                <th>Last Used</th>
                                <th>Created</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($keys as $key)
                                <tr>
                                    <td><code>{{ $key->identifier }}{{ decrypt($key->token) }}</code></td>
                                    <td>
                                        <span style="font-weight: 600;">{{ $key->memo }}</span>
                                    </td>
                                    <td>
                                        @if(!is_null($key->last_used_at))
                                            <span style="color: var(--text-main);">@datetimeHuman($key->last_used_at)</span>
                                        @else
                                            <span style="color: var(--text-sub);">&mdash;</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span style="color: var(--text-sub);">@datetimeHuman($key->created_at)</span>
                                    </td>
                                    <td class="text-right">
                                        <a href="#" data-action="revoke-key" data-attr="{{ $key->identifier }}" class="btn-icon-danger" title="Revoke Key">
                                            <span class="material-symbols-rounded">delete</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('[data-action="revoke-key"]').click(function (event) {
                var self = $(this);
                event.preventDefault();
                swal({
                    type: 'warning',
                    title: 'Revoke API Key',
                    text: 'Once this API key is revoked any applications currently using it will stop working immediately.',
                    showCancelButton: true,
                    allowOutsideClick: true,
                    closeOnConfirm: false,
                    confirmButtonText: 'Revoke Key',
                    confirmButtonColor: '#d9534f',
                    showLoaderOnConfirm: true
                }, function () {
                    $.ajax({
                        method: 'DELETE',
                        url: '/admin/api/revoke/' + self.data('attr'),
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).done(function () {
                        swal({
                            type: 'success',
                            title: 'Success',
                            text: 'API Key has been revoked.'
                        });
                        self.closest('tr').fadeOut();
                    }).fail(function (jqXHR) {
                        console.error(jqXHR);
                        swal({
                            type: 'error',
                            title: 'Whoops!',
                            text: 'An error occurred while attempting to revoke this key.'
                        });
                    });
                });
            });
        });
    </script>
@endsection

