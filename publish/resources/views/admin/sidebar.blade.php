<div class="col-md-3">
    @foreach($laravelAdminMenus->menus as $section)
        @if($section->items)
            <div class="card">
                <div class="card-header">
                    {{ $section->section }}
                </div>
                <div class="card-body">
                    <ul class="nav flex-column" role="tablist">
                        @foreach($section->items as $menu)
                            @if (auth()->user()->hasRole('admin') || ($menu->permission !== '' && auth()->user()->can($menu->permission)))
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" href="{{ route($menu->url) }}">
                                        {{ $menu->title }}
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
