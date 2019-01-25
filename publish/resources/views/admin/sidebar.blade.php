<div class="col-md-3">
    @foreach(array_keys($laravelAdminMenus) as $section)
        @if(count($laravelAdminMenus[$section]))
            <div class="card">
                <div class="card-header">
                    {{ $section }}
                </div>
                <div class="card-body">
                    <ul class="nav flex-column" role="tablist">
                        @foreach($laravelAdminMenus[$section] as $menu)
                            @if (auth()->user()->hasRole('admin') || ($menu['permission'] !== '' && auth()->user()->can($menu['permission'])))
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" href="{{ route($menu['url']) }}">
                                        {{ $menu['title'] }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <br/>
        @endif
    @endforeach
</div>
