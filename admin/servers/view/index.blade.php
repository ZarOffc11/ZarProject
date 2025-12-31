@extends('layouts.admin')

@section('title')
    Server — {{ $server->name }}
@endsection

@section('content-header')
@endsection

@section('content')
<style>
    /* LOCAL VARS */
    :root {
        --btn-bg: #ffffff; --btn-text: #1f2937; --btn-border: #d1d5db; --btn-hover: #f3f4f6; --badge-bg: #f3f4f6;
    }
    body.dark-mode {
        --btn-bg: #1b1e24; --btn-text: #e2e8f0; --btn-border: #4a5568; --btn-hover: #2d3748; --badge-bg: #2a2e36;
    }

    .content { padding-top: 10px !important; }

    .content-header { padding: 0 !important; margin-bottom: 15px !important; background: transparent !important; border: none !important; height: auto !important; }
    .header-compact { display: flex; align-items: center; padding-top: 5px; justify-content: space-between; }
    
    .page-title { font-size: 24px; font-weight: 800; color: var(--text-main); margin: 0; line-height: 1.2; letter-spacing: -0.5px; }
    .page-title small { color: var(--text-sub); font-size: 14px; margin-left: 10px; font-weight: 400; }

    /* CARD STYLE */
    .theme-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .card-header-theme {
        padding: 15px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex; align-items: center; gap: 8px;
        font-weight: 700; font-size: 15px; color: var(--text-main);
    }

    /* TABLE CLEAN STYLE */
    .table-clean { width: 100%; border-collapse: collapse; }
    .table-clean td {
        padding: 14px 24px;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-main);
        font-size: 14px;
    }
    .table-clean tr:last-child td { border-bottom: none; }
    .table-clean td:first-child {
        color: var(--text-sub);
        font-weight: 600;
        width: 35%;
    }
    
    code { background: var(--input-bg) !important; color: #6366f1 !important; border: 1px solid var(--border-color) !important; padding: 2px 6px; border-radius: 4px; }
    .label-default { background: var(--border-color); color: var(--text-sub); padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }

    /* SIDEBAR WIDGETS */
    .user-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 15px 20px; border-bottom: 1px solid var(--border-color);
    }
    .user-row:last-child { border-bottom: none; }
    
    .user-details { display: flex; align-items: center; gap: 12px; }
    .avatar-circle {
        width: 40px; height: 40px; background: var(--badge-bg); border-radius: 50%;
        display: flex; align-items: center; justify-content: center; color: var(--text-sub);
    }
    .user-text h4 { margin: 0; font-size: 14px; font-weight: 700; color: var(--text-main); }
    .user-text p { margin: 0; font-size: 12px; color: var(--text-sub); }

    .btn-icon { color: var(--text-sub); transition: 0.2s; }
    .btn-icon:hover { color: #6366f1; }
    
    /* ALERTS */
    .alert-custom { padding: 12px 16px; border-radius: 10px; margin: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 13px; }
    .alert-yellow { background: #fefce8; color: #a16207; border: 1px solid #fde047; }
    .alert-blue { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .alert-red { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

</style>

{{-- TOMBOL TOGGLE DIHAPUS DARI SINI --}}

@include('admin.servers.partials.navigation')

<div class="row">
    <div class="col-sm-8">
        <div class="theme-card">
            <div class="card-header-theme">
                <span class="material-symbols-rounded" style="color: #6366f1;">dns</span> Server Information
            </div>
            <div class="table-responsive">
                <table class="table-clean">
                    <tr>
                        <td>Internal ID</td>
                        <td><code>{{ $server->id }}</code></td>
                    </tr>
                    <tr>
                        <td>External ID</td>
                        <td>
                            @if(is_null($server->external_id))
                                <span class="label-default">Not Set</span>
                            @else
                                <code>{{ $server->external_id }}</code>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>UUID</td>
                        <td><code>{{ $server->uuid }}</code></td>
                    </tr>
                    <tr>
                        <td>Egg / Nest</td>
                        <td>
                            <a href="{{ route('admin.nests.view', $server->nest_id) }}" style="color: #6366f1; font-weight:600;">{{ $server->nest->name }}</a> 
                            <span style="color:var(--text-sub)">/</span>
                            <a href="{{ route('admin.nests.egg.view', $server->egg_id) }}" style="color: #6366f1; font-weight:600;">{{ $server->egg->name }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Server Name</td>
                        <td>{{ $server->name }}</td>
                    </tr>
                    <tr>
                        <td>CPU Limit</td>
                        <td>
                            @if($server->cpu === 0) <code>Unlimited</code> @else <code>{{ $server->cpu }}%</code> @endif
                        </td>
                    </tr>
                    <tr>
                        <td>CPU Pinning</td>
                        <td>
                            @if($server->threads != null) <code>{{ $server->threads }}</code> @else <span class="label-default">Not Set</span> @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Memory</td>
                        <td>
                            @if($server->memory === 0) <code>Unlimited</code> @else <code>{{ $server->memory }}MiB</code> @endif
                            <span style="color:var(--text-sub); margin:0 5px;">|</span>
                            Swap: 
                            @if($server->swap === 0) <span class="label-default">None</span>
                            @elseif($server->swap === -1) <code>Unlimited</code>
                            @else <code>{{ $server->swap }}MiB</code>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Disk Space</td>
                        <td>
                            @if($server->disk === 0) <code>Unlimited</code> @else <code>{{ $server->disk }}MiB</code> @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Block IO Weight</td>
                        <td><code>{{ $server->io }}</code></td>
                    </tr>
                    <tr>
                        <td>Connection</td>
                        <td><code>{{ $server->allocation->ip }}:{{ $server->allocation->port }}</code></td>
                    </tr>
                    <tr>
                        <td>Alias</td>
                        <td>
                            @if($server->allocation->alias !== $server->allocation->ip)
                                <code>{{ $server->allocation->alias }}:{{ $server->allocation->port }}</code>
                            @else
                                <span class="label-default">No Alias</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="theme-card">
            <div class="card-header-theme">
                <span class="material-symbols-rounded" style="color: #6366f1;">verified</span> Status & Relations
            </div>
            
            @if($server->isSuspended())
                <div class="alert-custom alert-yellow">
                    <span class="material-symbols-rounded">warning</span> Server is Suspended
                </div>
            @endif
            
            @if(!$server->isInstalled())
                <div class="alert-custom {{ (! $server->isInstalled()) ? 'alert-blue' : 'alert-red' }}">
                    <span class="material-symbols-rounded">downloading</span> 
                    {{ (! $server->isInstalled()) ? 'Installing...' : 'Install Failed' }}
                </div>
            @endif

            <div class="user-row">
                <div class="user-details">
                    <div class="avatar-circle">
                        <span class="material-symbols-rounded">person</span>
                    </div>
                    <div class="user-text">
                        <h4>{{ $server->user->username }}</h4>
                        <p>Server Owner</p>
                    </div>
                </div>
                <a href="{{ route('admin.users.view', $server->user->id) }}" class="btn-icon">
                    <span class="material-symbols-rounded">arrow_forward</span>
                </a>
            </div>

            <div class="user-row">
                <div class="user-details">
                    <div class="avatar-circle">
                        <span class="material-symbols-rounded">hub</span>
                    </div>
                    <div class="user-text">
                        <h4>{{ $server->node->name }}</h4>
                        <p>Node Location</p>
                    </div>
                </div>
                <a href="{{ route('admin.nodes.view', $server->node->id) }}" class="btn-icon">
                    <span class="material-symbols-rounded">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

