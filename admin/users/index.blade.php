@extends('layouts.admin')

@section('title')
    List Users
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
        display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;
    }
    .header-title h1 { font-size: 20px; font-weight: 800; margin: 0; color: var(--text-main); letter-spacing: -0.5px; }
    .header-title small { display: block; font-size: 13px; color: var(--text-sub); margin-top: 4px; font-weight: 500; }

    /* ACTIONS & SEARCH */
    .header-actions { display: flex; align-items: center; gap: 10px; }
    
    .search-box { position: relative; }
    .search-input {
        background: var(--input-bg); border: 1px solid var(--border-color);
        color: var(--text-main); padding: 8px 12px 8px 35px; border-radius: 8px;
        outline: none; height: 38px; font-size: 13px; transition: all 0.2s; width: 250px;
    }
    .search-input:focus { border-color: #6366f1; background: var(--bg-card); }
    .search-icon { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-sub); font-size: 18px; }

    /* TABLE */
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

    /* BUTTONS */
    .btn-simple {
        background: var(--btn-bg); color: var(--btn-text); border: 1px solid var(--btn-border);
        padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;
        text-decoration: none !important; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-simple:hover { background: var(--btn-hover); border-color: var(--text-main); }

    /* AVATAR */
    .user-avatar { border-radius: 50%; width: 28px; height: 28px; object-fit: cover; border: 1px solid var(--border-color); }
    
    /* BADGES & ICONS */
    .admin-badge { color: #f59e0b; margin-left: 5px; font-size: 16px; vertical-align: middle; }
    .secure-icon { color: #10b981; font-size: 18px; }
    .insecure-icon { color: #ef4444; font-size: 18px; }

    .card-footer-theme {
        padding: 15px 24px; background: var(--input-bg); border-top: 1px solid var(--border-color);
        display: flex; justify-content: center;
    }
    
    code { background: var(--input-bg); color: #6366f1; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; font-family: 'Menlo', monospace; }
    .material-symbols-rounded { font-size: 20px; vertical-align: middle; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="theme-card">
            {{-- HEADER UNIFIED --}}
            <div class="card-header-unified">
                <div class="header-title">
                    <h1>Users</h1>
                    <small>All registered users on the system.</small>
                </div>
                
                <div class="header-actions">
                    <form action="{{ route('admin.users') }}" method="GET">
                        <div class="search-box">
                            <span class="material-symbols-rounded search-icon">search</span>
                            <input type="text" name="filter[email]" class="search-input" value="{{ request()->input('filter.email') }}" placeholder="Search by email...">
                        </div>
                    </form>
                    
                    <a href="{{ route('admin.users.new') }}" class="btn-simple">
                        <span class="material-symbols-rounded">add_circle</span> Create New
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="theme-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Client Name</th>
                            <th>Username</th>
                            <th class="text-center">2FA</th>
                            <th class="text-center">Servers Owned</th>
                            <th class="text-center">Can Access</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td><code>{{ $user->id }}</code></td>
                                <td>
                                    <a href="{{ route('admin.users.view', $user->id) }}" style="font-weight: 600; color: #6366f1; text-decoration: none;">
                                        {{ $user->email }}
                                    </a>
                                    @if($user->root_admin)
                                        <span class="material-symbols-rounded admin-badge" title="Root Admin">stars</span>
                                    @endif
                                </td>
                                <td>{{ $user->name_last }}, {{ $user->name_first }}</td>
                                <td>{{ $user->username }}</td>
                                <td class="text-center">
                                    @if($user->use_totp)
                                        <span class="material-symbols-rounded secure-icon" title="2FA Enabled">lock</span>
                                    @else
                                        <span class="material-symbols-rounded insecure-icon" title="2FA Disabled">lock_open_right</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.servers', ['filter[owner_id]' => $user->id]) }}" style="text-decoration: underline; color: var(--text-main);">
                                        {{ $user->servers_count }}
                                    </a>
                                </td>
                                <td class="text-center">{{ $user->subuser_of_count }}</td>
                                <td class="text-center">
                                    <img src="https://www.gravatar.com/avatar/{{ md5(strtolower($user->email)) }}?s=100" class="user-avatar" alt="Avatar"/>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="card-footer-theme">
                    {!! $users->appends(['query' => Request::input('query')])->render() !!}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

