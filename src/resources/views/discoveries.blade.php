@extends('layouts.app')
@section('discoveries_index')
    <div class="container">
        <div class="">

            <!-- regist discovery -->

            
            <!-- search discoveries -->

            
            <!-- current discoveries -->
            @if (!is_null($discoveries))
            <div class="card my-4">
                <div class="card-header">発見情報 一覧</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>名前</th>
                                <th>科名</th>
                            </tr>
                        </thead>

                        <tbody>
                        
                        @foreach ($discoveries as $discovery)
                            <tr>
                                <td class="align-middle table-text word-break td_name"><div class="text-break">{{ optional($discovery)->flower->name }}</div></td>
                                <td class="align-middle table-text word-break td_family_name">
                                    <div class="text-break"><a class="text-info" href="">{{ optional($discovery)->flower->family->name }}科</a></div>
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
    

<!-- モーダルの設定 -->

@endsection