@include('partials/admin.settings.notice')

@section('settings::nav')
    @yield('settings::notice')
    
    {{-- Style Khusus Tab Modern (Pills) --}}
    <style>
        .nav-pills-modern {
            display: flex;
            gap: 10px;
            padding: 0;
            list-style: none;
            border-bottom: 1px solid var(--border-color, #e5e7eb);
            padding-bottom: 15px;
            margin-bottom: 25px; /* Jarak ke konten bawah */
        }
        
        .nav-pills-modern li a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px; /* Rounded Pills */
            background: var(--bg-card, #fff);
            color: var(--text-sub, #6b7280);
            border: 1px solid var(--border-color, #e5e7eb);
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .nav-pills-modern li a:hover {
            background: var(--btn-hover, #f9fafb);
            color: var(--text-main, #1f2937);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        /* State Aktif (Hitam/Gelap) */
        .nav-pills-modern li.active a {
            background: #1f2937; 
            color: #fff; 
            border-color: #1f2937;
            box-shadow: 0 4px 10px -2px rgba(0, 0, 0, 0.2);
        }
        
        /* Penyesuaian Icon */
        .material-symbols-rounded { font-size: 18px; vertical-align: middle; }
    </style>

    <div class="row">
        <div class="col-xs-12">
            <ul class="nav-pills-modern">
                {{-- Tab General --}}
                <li class="@if($activeTab === 'basic') active @endif">
                    <a href="{{ route('admin.settings') }}">
                        <span class="material-symbols-rounded">tune</span> General
                    </a>
                </li>

                {{-- Tab Mail --}}
                <li class="@if($activeTab === 'mail') active @endif">
                    <a href="{{ route('admin.settings.mail') }}">
                        <span class="material-symbols-rounded">mail</span> Mail
                    </a>
                </li>

                {{-- Tab Advanced --}}
                <li class="@if($activeTab === 'advanced') active @endif">
                    <a href="{{ route('admin.settings.advanced') }}">
                        <span class="material-symbols-rounded">construction</span> Advanced
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection

