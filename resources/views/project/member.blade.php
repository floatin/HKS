@extends('layouts.master')
@section('script')
<script src="{{ asset('js/tooltip.js') }}" defer></script>
<script src="{{ asset('js/circle-progress.min.js') }}" defer></script>
<script src="{{ asset('js/circleProgress.js') }}" defer></script>
@endsection
@section('title','專案成員')
@section('content')
<div class="container">
    {{-- 專案概述 --}}
    @include('project.show')
    {{-- 分頁 --}}
    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" id="okr-tab" href="{{ route('project.okr', $project) }}">OKRs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" id="member-tab" href="{{ route('project.member', $project) }}">成員</a>
        </li>
    </ul>
    <div class="row justify-content-md-center">
        <div class="col-sm-10 mt-4">
            @if (count($project->users))
                {{-- 篩選 --}}
                <div class="float-right mb-2">
                    <form action="{{route('project.member', $project)}}" class="form-inline search-form">
                        <select name="order" class="form-control input-sm mr-2 ml-2">
                            <option value="name_asc">姓名排序</option>
                            <option value="email_asc">信箱排序</option>
                            <option value="position_asc">職稱排序</option>
                        </select>
                        <button type="submit" value="Submit" class="btn btn-primary">搜索</button>
                    </form>
                </div>
                {{ $members->links() }}
                {{-- 成員表 --}}
                <table class="rwd-table table table-hover">
                    <thead>
                        <tr class="bg-primary text-light text-center">
                            <th>追蹤</th>
                            <th>頭像</th>
                            <th>姓名</th>
                            <th>信箱</th>
                            <th>部門</th>
                            <th>職稱</th>
                            <th>權限</th>
                            @can('memberSetting', $project)
                            <th>設定</th>                                
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr class="text-center">
                            <td data-th="追蹤">
                                @if ($member->following())
                                <a href="{{ route('follow.cancel', [get_class($member), $member]) }}" class="text-warning">
                                    <i class="fas fa-star" style="font-size: 24px;"></i>
                                </a>
                                @else
                                <a href="{{ route('follow', [get_class($member), $member]) }}" class="text-warning">
                                    <i class="far fa-star" style="font-size: 24px;"></i>
                                </a>
                                @endif
                            </td>
                            <td data-th="頭像">
                                <a href="{{ route('user.okr', $member->id) }}" class="u-ml-8 u-mr-8">
                                    <img src="{{ $member->getAvatar() }}" alt="" class="avatar-sm text-center bg-white">
                                </a>
                            </td>
                            <td data-th="姓名">{{ $member->name }}</td>
                            <td data-th="信箱">{{ $member->email }}</td>
                            <td data-th="部門">{{ $member->department? $member->department->name:'-' }}</td>
                            <td data-th="職稱">{{ $member->position }}</td>
                            @can('memberSetting', $project)
                            <td data-th="權限">{{ $member->role($project)->name }}</td>
                            <td data-th="設定">
                                <a href="#" data-toggle="dropdown" class="tooltipBtn text-danger"><i class="fas fa-trash-alt"></i></a>
                                <form name="memberDelete{{ $member->id }}" method="POST" id="memberDelete{{ $member->id }}"
                                        action="{{ route('project.member.destroy', [$project, $member]) }}">
                                    @csrf
                                    {{ method_field('PATCH') }}
                                    <div class="dropdown-menu u-padding-16">
                                        <div class="row justify-content-center mb-2">
                                            <div class="col-auto text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-center">
                                                確認要刪除成員{{ $member->name }}嗎？<br>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center mt-3">
                                            <div class="col-auto text-center pr-2"><button class="btn btn-danger pl-4 pr-4" type="submit">刪除</button></div>
                                            <div class="col-auto text-center pl-2"><a class="btn btn-secondary text-white pl-4 pr-4">取消</a></div>
                                        </div>
                                    </div>
                                </form>
                            </td>
                            @endcan
                            @cannot('memberSetting', $project)
                            <td data-th="權限">{{ $member->role($project)->name }}</td>                                
                            @endcannot
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div id="dragCard" class="row justify-content-md-center u-mt-16">
                    <div class="alert alert-warning alert-dismissible fade show u-mt-32" role="alert">
                        <strong><i class="fas fa-exclamation-circle pl-2 pr-2"></i></strong>
                        此專案未具有成員 !!
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if (count($project->invitation))
        {{-- 邀請表 --}}
        <div class="row justify-content-md-center">
            <div class="col-sm-10">邀請中成員
                <table class="rwd-table table table-hover">
                    <thead>
                        <tr class="bg-primary text-light text-center">
                            <th>頭像</th>
                            <th>姓名</th>
                            <th>信箱</th>
                            <th>部門</th>
                            <th>職稱</th>
                            @can('memberSetting', $project)
                            <th>設定</th>                                
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($project->getInvitationUsers() as $member)
                        <tr class="text-center">
                            <td data-th="頭像">
                                <a href="{{ route('user.okr', $member->id) }}" class="u-ml-8 u-mr-8">
                                    <img src="{{ $member->getAvatar() }}" alt="" class="avatar-sm text-center bg-white">
                                </a>
                            </td>
                            <td data-th="姓名">{{ $member->name }}</td>
                            <td data-th="信箱">{{ $member->email }}</td>
                            <td data-th="部門">{{ $member->department? $member->department->name: '-' }}</td>
                            <td data-th="職稱">{{ $member->position? $member->position:'-' }}</td>
                            @can('memberSetting', $project)                            
                            <td data-th="設定">
                                <a href="#" onclick="document.getElementById('memberDelete{{ $member->id }}').submit()"><i
                                        class="fas fa-trash-alt text-danger"></i></a href="#">
                                <form name="memberDelete{{ $member->id }}" method="POST" id="memberDelete{{ $member->id }}"
                                    action="{{ route('project.member.invite.destroy', [$project, $member]) }}">
                                    @csrf
                                    {{ method_field('PATCH') }}
                                </form>
                            </td>
                            @endcan
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
