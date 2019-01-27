<div class="row justify-content-center">
    <div class="col">
        <a href="{{ route('project') }}" class="text-black-50">
            <i class="fas fa-chevron-left"></i> 返回
        </a>
    </div>
    <div class="col align-self-end text-right">
        @if ($project->following())
        <a href="{{ route('follow.cancel', [get_class($project), $project]) }}" class="text-warning" data-toggle="tooltip" data-placement="right" title="取消追蹤">
            <i class="fas fa-star" style="font-size: 24px;"></i>
        </a>
        @else
        <a href="{{ route('follow', [get_class($project), $project]) }}" class="text-warning" data-toggle="tooltip" data-placement="right" title="追蹤">
            <i class="far fa-star" style="font-size: 24px;"></i>
        </a>
        @endif
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-10 u-padding-16">
        <div class="row">
            <div class="col-auto">
                <a class="u-ml-8 u-mr-8" href="{{ route('project.okr', $project) }}">
                    <img src="{{ $project->getAvatar() }}" alt="" class="avatar text-center bg-white">
                </a>
            </div>
            <div class="col align-self-center text-truncate">
                <a href="{{ route('project.okr', $project) }}">
                    <p class="mb-0 font-weight-bold text-black-50 text-truncate">{{ $project->name }}</p>
                    <p class="mb-0 text-black-50 text-truncate">{{ $project->description }}</p>
                </a>
                @foreach ($project->users as $user)
                    <a href="{{ route('user.okr', $user) }}" class="d-inline-block pt-2" data-toggle="tooltip" data-placement="bottom" title="{{ $user->name }}">
                        <img src="{{ $user->getAvatar() }}" alt="" class="avatar-xs">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

@if ($project->user_id == auth()->user()->id)
<div class="row justify-content-center">
    <div class="col-md-10 col-12 text-right align-self-end">
        <a href="{{ route('project.done', $project) }}" data-toggle="tooltip" data-placement="bottom" title="{{ $project->isdone?'取消關閉':'關閉專案'}}"><i class="far fa-check-square u-margin-4"></i></a>                    
        <a href="{{ route('project.member.setting', $project) }}" data-toggle="tooltip" data-placement="bottom" title="新增成員"><i class="fas fa-user-plus u-margin-4"></i></a>
        <a href="#" data-toggle="modal" data-target="#editProject" class="tooltipBtn" data-placement="bottom" title="編輯專案"><i class="fas fa-edit u-margin-4"></i></a>
        <a href="#" data-toggle="dropdown" class="tooltipBtn" data-placement="bottom" title="刪除專案"><i class="fas fa-trash-alt"></i></a>
        <form method="POST" id="projectDelete" action="{{ route('project.destroy', $project) }}">
            @csrf
            {{ method_field('DELETE') }}
            <div class="dropdown-menu u-padding-16">
                <div class="row justify-content-center mb-2">
                    <div class="col-auto text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <div class="">刪除專案後，</div>
                        <div>將失去專案中所有資料！！</div>
                        <div>確認要刪除專案嗎？</div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-auto text-center pr-2"><button class="btn btn-danger pl-4 pr-4" type="submit">刪除</button></div>
                    <div class="col-auto text-center pl-2"><a class="btn btn-secondary text-white pl-4 pr-4">取消</a></div>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

{{-- 編輯專案Modal --}}
<div class="modal fade " id="editProject" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('project.edit')
            </div>
        </div>
    </div>
</div>
