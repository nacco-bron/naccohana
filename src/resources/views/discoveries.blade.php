@extends('layouts.app')
@section('discoveries_index')
<div class="container">
    <div class="">

        <!-- regist discovery -->
        <div class="text-right">
            <button class="btn btn-info btn-lg right"><i class="fa fa-plus" aria-hidden="true"></i></button>
        </div>

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
                                <div class="text-break">{{ optional($discovery)->discovered_at }}</div>
                            </td>
                            <td class="align-middle table-text word-break">
                                <div class="text-break">{{ optional($discovery)->flower->name }}</div>
                            </td>
                            <td class="align-middle table-text word-break">
                                <div class="text-break"><a class="text-info" href="">{{
                                        optional($discovery)->flower->family->name }}科</a></div>
                            </td>
                            <td class="align-middle table-text word-break">
                                <div class="text-break">{{ optional($discovery)->prefecture->name }}</div>
                            </td>
                            <td class="align-middle">
                                @if(optional($discovery)->file_name1 != null)
                                <img src="/storage/images/{{ optional($discovery)->id . '_' . optional($discovery)->file_name1 }}" width="120px" height="120px" alt="{{ optional($discovery)->flower->name }}" class="img-thumbnail">
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