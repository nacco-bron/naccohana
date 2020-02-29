@extends('layouts.app')
@section('title', 'Hana App | 発見一覧')

@section('content')
<div class="container">
    <div class="">

        <!-- regist discovery -->
        <div class="text-right">
            <button class="btn btn-info btn-lg right" onclick="location.href='{{ url('/discovery') }}'"><i class="fa fa-plus" aria-hidden="true"></i></button>
        </div>

@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $message }}</strong>
</div>
@endif

        <!-- search discoveries -->

        <!-- current discoveries -->
        @if (!is_null($discoveries))
        <div class="card my-4">
            <div class="card-header">発見情報 一覧</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>発見日時</th>
                            <th>名前</th>
                            <th>科名</th>
                            <th>都道府県</th>
                            <th>画像</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($discoveries as $discovery)
                        <tr>
                            <td class="align-middle table-text word-break">
                                <div class="text-break">{{ $discovery->discovered_at }}</div>
                            </td>
                            <td class="align-middle table-text word-break">
                                <div class="text-break">{{ $discovery->flower->name }}</div>
                            </td>
                            <td class="align-middle table-text word-break">
                                <div class="text-break"><a class="text-info" href="">{{ $discovery->flower->family->name }}科</a></div>
                            </td>
                            <td class="align-middle table-text word-break">
                                <div class="text-break">{{ optional($discovery->prefecture)->name }}</div>
                            </td>
                            <td class="align-middle">
                                @if($discovery->file_name1 != null)
                                <img src="/storage/images/{{ $discovery->id . '_' . $discovery->file_name1 }}" width="120px" height="120px" alt="{{ $discovery->flower->name }}" class="img-thumbnail">
                                @else
                                <img src="/storage/images/dummy.jpg" width="120px" height="120px" alt="dummy" class="img-thumbnail">
                                @endif
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
