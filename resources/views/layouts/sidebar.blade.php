<nav class="nav flex-column sidebar" id="sidebar-text">
    <a class="nav-link" href="{{ route('user.okr', auth()->user()->id) }}">
        <span>我的OKR</span>
    </a>
    <a class="nav-link" href="{{ route('company.index') }}">
        <span>組織OKR</span>
    </a>
    <a class="nav-link" href="{{ route('project') }}">
        <span>我的專案</span>
    </a>
    <a class="nav-link" href="{{ route('calendar.index') }}">
        <span>工作日曆</span>
    </a>
    <a class="nav-link" href="{{ route('follow.index') }}">
        <span>個人追蹤</span>
    </a>
</nav>
<nav class="nav flex-column sidebar" id="sidebar">
    <a class="nav-link" href="{{ route('user.okr', auth()->user()->id) }}"><img src="{{ asset('/img/icon/home/w.svg') }}" alt=""></a>
    <a class="nav-link" href="{{ route('company.index') }}"><i class="fas fa-sitemap" style="line-height: 24px"></i></a>
    <a class="nav-link" href="{{ route('project') }}"><img src="{{ asset('/img/icon/project/w.svg') }}" alt=""></a>
    <a class="nav-link" href="{{ route('calendar.index') }}"><img src="{{ asset('/img/icon/calendar/w.svg') }}" alt=""></a>
    <a class="nav-link" href="{{ route('follow.index') }}"><img src="{{ asset('/img/icon/like/w.svg') }}" alt=""></a>
</nav>
<div class="row u-pl-8 u-pr-8 bg-primary u-pt-8 sidebar-sm ml-0 mr-0">
    <a class="col text-center text-white ml-auto mr-auto" href="{{ route('user.okr', auth()->user()->id) }}"><img src="{{ asset('/img/icon/home/w.svg') }}" alt=""><p class="mb-0 small">OKR</p></a>
    <a class="col text-center text-white ml-auto mr-auto" href="{{ route('company.index') }}"><i class="fas fa-sitemap" style="line-height: 24px"></i><p class="mb-0 small">組織</p></a>
    <a class="col text-center text-white ml-auto mr-auto" href="{{ route('project') }}"><img src="{{ asset('/img/icon/project/w.svg') }}" alt=""><p class="mb-0 small">專案</p></a>
    <a class="col text-center text-white ml-auto mr-auto" href="{{ route('calendar.index') }}"><img src="{{ asset('/img/icon/calendar/w.svg') }}" alt=""><p class="mb-0 small">日曆</p></a>
    <a class="col text-center text-white ml-auto mr-auto" href="{{ route('follow.index') }}"><img src="{{ asset('/img/icon/like/w.svg') }}" alt=""><p class="mb-0 small">追蹤</p></a>
</div>
