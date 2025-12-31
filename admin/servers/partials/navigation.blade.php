@php
    /** @var \Pterodactyl\Models\Server $server */
    $router = app('router');
@endphp

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<style>
    /* Custom Navigation Style */
    .nav-tabs-custom { background: transparent !important; box-shadow: none !important; margin-bottom: 20px; }
    .nav-pills-modern {
        display: flex; gap: 8px; flex-wrap: wrap; padding: 0; list-style: none; border-bottom: 1px solid var(--border-color, #e5e7eb); padding-bottom: 15px;
    }
    
    .nav-pills-modern li a {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 8px 16px; border-radius: 10px;
        background: var(--bg-card, #fff); color: var(--text-sub, #6b7280);
        border: 1px solid var(--border-color, #e5e7eb);
        font-weight: 600; font-size: 13px; text-decoration: none;
        transition: all 0.2s;
    }

    .nav-pills-modern li a:hover {
        background: var(--btn-hover, #f9fafb); color: var(--text-main, #1f2937);
        transform: translateY(-1px);
    }

    /* Active State */
    .nav-pills-modern li.active a {
        background: #1f2937; color: #fff; border-color: #1f2937;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    /* Danger Tab (Delete) */
    .nav-pills-modern li.tab-danger a { color: #ef4444; border-color: #fecaca; background: #fef2f2; }
    .nav-pills-modern li.tab-danger.active a { background: #ef4444; color: #fff; border-color: #ef4444; }
    .nav-pills-modern li.tab-danger a:hover { background: #fee2e2; }

    /* External Link */
    .nav-pills-modern li.tab-external a { color: #6366f1; border-color: #e0e7ff; background: #eef2ff; }
    .nav-pills-modern li.tab-external a:hover { background: #e0e7ff; }

    .material-symbols-rounded { font-size: 18px; }
</style>

<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom">
            <ul class="nav-pills-modern">
                <li class="{{ $router->currentRouteNamed('admin.servers.view') ? 'active' : '' }}">
                    <a href="{{ route('admin.servers.view', $server->id) }}">
                        <span class="material-symbols-rounded">info</span> About
                    </a>
                </li>
                @if($server->isInstalled())
                    <li class="{{ $router->currentRouteNamed('admin.servers.view.details') ? 'active' : '' }}">
                        <a href="{{ route('admin.servers.view.details', $server->id) }}">
                            <span class="material-symbols-rounded">settings</span> Details
                        </a>
                    </li>
                    <li class="{{ $router->currentRouteNamed('admin.servers.view.build') ? 'active' : '' }}">
                        <a href="{{ route('admin.servers.view.build', $server->id) }}">
                            <span class="material-symbols-rounded">build</span> Build Config
                        </a>
                    </li>
                    <li class="{{ $router->currentRouteNamed('admin.servers.view.startup') ? 'active' : '' }}">
                        <a href="{{ route('admin.servers.view.startup', $server->id) }}">
                            <span class="material-symbols-rounded">rocket_launch</span> Startup
                        </a>
                    </li>
                    <li class="{{ $router->currentRouteNamed('admin.servers.view.database') ? 'active' : '' }}">
                        <a href="{{ route('admin.servers.view.database', $server->id) }}">
                            <span class="material-symbols-rounded">database</span> Database
                        </a>
                    </li>
                    <li class="{{ $router->currentRouteNamed('admin.servers.view.mounts') ? 'active' : '' }}">
                        <a href="{{ route('admin.servers.view.mounts', $server->id) }}">
                            <span class="material-symbols-rounded">hard_drive</span> Mounts
                        </a>
                    </li>
                @endif
                <li class="{{ $router->currentRouteNamed('admin.servers.view.manage') ? 'active' : '' }}">
                    <a href="{{ route('admin.servers.view.manage', $server->id) }}">
                        <span class="material-symbols-rounded">tune</span> Manage
                    </a>
                </li>
                <li class="tab-danger {{ $router->currentRouteNamed('admin.servers.view.delete') ? 'active' : '' }}">
                    <a href="{{ route('admin.servers.view.delete', $server->id) }}">
                        <span class="material-symbols-rounded">delete</span> Delete
                    </a>
                </li>
                <li class="tab-external">
                    <a href="/server/{{ $server->uuidShort }}" target="_blank">
                        <span class="material-symbols-rounded">open_in_new</span> Panel
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

