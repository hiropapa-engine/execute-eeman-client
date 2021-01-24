@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @php
                    $category_name = $attendance->category->name;
                    $school_name = $attendance->school->name;
                    $time_from = $attendance->class->time_from;
                    $time_to = $attendance->class->time_to;
                    $class_time = substr($time_from, 0, strlen($time_from) - 3) . ' ～ ' . substr($time_to, 0, strlen($time_to) - 3);
                @endphp
                <div class="card-header">{{$category_name  . ' ' . $school_name . ' ' . $class_time}}</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">生徒名</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendance->enter_and_leave as $enter_and_leave)
                            <tr>
                                <td>{{ $enter_and_leave->student->name }}</td>
                                @if ($enter_and_leave->enter == null)
                                <td><button id="{{ 'Enter' . $enter_and_leave->id}}" type="button" class="btn btn-primary" onclick="onClickEnter({{ $attendance->id }} , {{ $enter_and_leave->id }})">入室</button></td>
                                @else
                                <td><button id="{{ 'Enter' . $enter_and_leave->id}}" type="button" class="btn btn-secondary" onclick="onClickEnter({{ $attendance->id }} , {{ $enter_and_leave->id }})" disabled>入室</button></td>
                                @endif
                                @if ($enter_and_leave->enter != null && $enter_and_leave->leave == null)
                                <td><button id="{{ 'Leave' . $enter_and_leave->id}}" type="button" class="btn btn-primary" onclick="onClickLeave({{ $attendance->id }} , {{ $enter_and_leave->id }})">退室</button></td>
                                @else
                                <td><button id="{{ 'Leave' . $enter_and_leave->id}}" type="button" class="btn btn-secondary" onclick="onClickLeave({{ $attendance->id }} , {{ $enter_and_leave->id }})" disabled>退室</button></td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
function onClickEnter(attendance_id, enter_and_leave_id)
{
    $.ajax({
        type: 'GET',
        url: '/attendances/' + attendance_id + '/students/' + enter_and_leave_id + '/enter/',
    })
    .done(function (data) {
        var enterButton = document.getElementById('Enter' + enter_and_leave_id);
        enterButton.setAttribute('disabled', 'disabled');
        enterButton.classList.remove('btn-primary');
        enterButton.classList.add('btn-secondary');

        var leaveButton = document.getElementById('Leave' + enter_and_leave_id);
        leaveButton.removeAttribute('disabled');
        leaveButton.classList.remove('btn-secondary');
        leaveButton.classList.add('btn-primary');
    });
}

function onClickLeave(attendance_id, enter_and_leave_id)
{
    $.ajax({
        type: 'GET',
        url: '/attendances/' + attendance_id + '/students/' + enter_and_leave_id + '/leave/',
    })
    .done(function (data) {
        var leaveButton = document.getElementById('Leave' + enter_and_leave_id);
        leaveButton.setAttribute('disabled', 'disabled');
        leaveButton.classList.remove('btn-primary');
        leaveButton.classList.add('btn-secondary');
    });
}
</script>
@endsection
