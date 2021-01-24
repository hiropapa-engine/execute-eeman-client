@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">スクール、クラス、時間帯を選択してください。</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="form-group row">
                        <label for="category_id" class="col-md-4 col-form-label text-md-right">スクール名</label>
                        <div class="col-md-6">
                            <select class="form-control" id="category_id" name="category_id" onchange="onCategoryChange()">
                                <option value="-1" selected>選択してください</option>
                                @foreach(Auth::user()->categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="school_id" class="col-md-4 col-form-label text-md-right">クラス名</label>
                        <div class="col-md-6">
                            <select class="form-control" id="school_id" name="school_id" onchange="onSchoolChange()">
                                <option value="-1" selected>選択してください</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="class_id" class="col-md-4 col-form-label text-md-right">時間帯</label>
                        <div class="col-md-6">
                            <select class="form-control" id="class_id" name="class_id">
                                <option value="-1" selected>選択してください</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary" onclick="onClickShowAttendance()">
                                {{ __('選択') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
function onCategoryChange()
{
    // スクール・時間帯の選択肢をすべて削除
    var class_id = document.getElementById('class_id');
    while(class_id.lastChild)
    {
        if (class_id.lastChild.innerHTML === '選択してください')
        {
            class_id.selectedIndex = 0;
            break;
        }

        class_id.removeChild(class_id.lastChild);
    }

    var school_id = document.getElementById('school_id');
    while(school_id.lastChild)
    {
        if (school_id.lastChild.innerHTML === '選択してください')
        {
            school_id.selectedIndex = 0;
            break;
        }

        school_id.removeChild(school_id.lastChild);
    }

    // カテゴリIDを取得
    var category_id = document.getElementById('category_id');

    // Ajax(同期)でカテゴリ配下のスクール情報一覧を取得
    $.ajax({
        type: 'GET',
        url: '/categories/' + category_id.value,
        dataType: 'json',
    })
    .done(function (data) {
        $.each(data, function (index, value) {
            let id = value.id;
            let name = value.name;
            var option = document.createElement('option');
            option.setAttribute('value', id);
            option.innerHTML = name;
            school_id.appendChild(option);
        });
    });
}

function onSchoolChange()
{
    // 時間帯の選択肢をすべて削除
    var class_id = document.getElementById('class_id');
    while(class_id.lastChild)
    {
        if (class_id.lastChild.innerHTML === '選択してください')
        {
            class_id.selectedIndex = 0;
            break;
        }

        class_id.removeChild(class_id.lastChild);
    }

    // カテゴリIDを取得
    var category_id = document.getElementById('category_id');
    // スクールIDを取得
    var school_id = document.getElementById('school_id');

    // Ajax(同期)でスクール配下の時間帯一覧を取得
    $.ajax({
        type: 'GET',
        url: '/categories/' + category_id.value + '/schools/' + school_id.value,
        dataType: 'json',
    })
    .done(function (data) {
        $.each(data, function (index, value) {
            let id = value.id;
            let time_from = value.time_from;
            let time_to = value.time_to;
            var option = document.createElement('option');
            option.setAttribute('value', id);
            option.innerHTML = time_from.substr(0, time_from.length -3) + ' ～ ' + time_to.substr(0, time_to.length - 3);
            class_id.appendChild(option);
        });
    });
}

function onClickShowAttendance()
{
    // カテゴリIDを取得
    var category_id = document.getElementById('category_id');
    // スクールIDを取得
    var school_id = document.getElementById('school_id');
    // 時間帯IDを取得
    var class_id = document.getElementById('class_id');

    if (category_id.value == -1 || school_id == -1 || class_id == -1)
    {
        alert('スクール、クラス、時間帯を指定してください。');
        return false;
    }

    window.location.href = '/categories/' + category_id.value + '/schools/' + school_id.value + '/classes/' + class_id.value + '/eandl';
}
</script>
@endsection
