@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="">

            <!-- regist flower -->
            @if(!is_null($flower))
            <div class="card border-info">
                <div class="card-header">更新</div>
            @else
            <div class="card">
                <div class="card-header">登録</div>
            @endif
                <div class="card-body">
                    @include('common.errors')
                    
                    <form enctype="multipart/form-data" action="@if(!is_null($flower)){{ url('flower/update/'.$flower->id) }}@else{{ url('flower') }}@endif" method="POST" class="form-horizontal" >
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">名前</label>
                            <div class="col-sm-6">
                            <input type="text" name="name" id="name" class="form-control" value="@if(!is_null($flower)){{ optional($flower)->name }}@endif">
                            </div>
                            <label for="family_id" class="col-sm-3 control-label">科名</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="family_id" id="family_id">
                                @foreach ($families as $family)
                                  <option value="{{ $family->id }}">{{ $family->name }}</option>
                                @endforeach
                                </select>
                                <input type="hidden" name="tmp_family_id" id="tmp_family_id" value="@if(!is_null($flower)){{ optional($flower)->family_id }}@endif">
                            </div>
                            <label for="flower-image" class="col-sm-3 control-label">画像</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <label class="input-group-btn">
                                        <span class="btn btn-info">
                                            Choose File<input type="file" id="image" name="image" style="display:none">
                                        </span>
                                    </label>
                                        <input type="text" name="file_name" class="form-control" readonly="" value="@if(!is_null($flower)){{ optional($flower)->file_name }}@endif">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            @if(!is_null($flower))
                            <div class="col-sm-offset-3 col-sm-6 d-inline">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-arrow-down "></i> 変更
                                </button>
                                <button type="button" onclick="location.href='{{ url('/flowers') }}'" class="btn btn-secondary">
                                    クリア
                                </button>
                            </div>
                            @else
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-plus"></i> 登録
                                </button>
                            @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- search flowers -->
            <div class="card my-4">
                <div class="card-body">
                    <form enctype="multipart/form-data" action="@if(!is_null($flower)){{ url('flower/update/'.$flower->id) }}@else{{ url('flower') }}@endif" method="POST" class="form-horizontal" >
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="search_family_id" class="col-sm-2 control-label"><i class="fa fa-search "></i> 絞り込み</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="search_family_id" id="search_family_id">
                                @foreach ($search_families as $search_family)
                                  <option value="{{ $search_family->id }}">{{ $search_family->name }}</option>
                                @endforeach
                                </select>
                            </div>
                         </div>
                    </form>
                </div>
            </div>
            
            <!-- current flowers -->
            @if (!is_null($flowers))
            <div class="card my-4">
                <div class="card-header">花 一覧</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>名前</th>
                                <th>科名 @if($family_id)<span class="ml-3"><a class="text-info font-weight-normal" href="{{ url('/flowers') }}"><i class="fa fa-angle-down "></i> すべて表示</a></span>@endif</th>
                                <th>画像</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>

                        <tbody>
                        
                        @foreach ($flowers as $flower)
                            <tr>
                                <td class="align-middle table-text word-break td_name"><div class="text-break">{{ optional($flower)->name }}</div></td>
                                <td class="align-middle table-text word-break td_family_name">
                                    <div class="text-break"><a class="text-info" href="{{ url('/flowers/family/'. $flower->family_id) }}">{{ optional($flower)->family->name }}</a></div>
                                </td>
                                <td class="align-middle">
                                    @if(optional($flower)->file_name != null)
                                    <img data-toggle="modal" data-target="#ModalCenter" data-image="/storage/images/{{ optional($flower)->id . '_' . optional($flower)->file_name }}" src="/storage/images/{{ optional($flower)->id . '_' . optional($flower)->file_name }}" width="150px" height="150px" alt="{{ optional($flower)->name }}" class="img-thumbnail">
                                    @else
                                    <img src="/storage/images/dummy.jpg" width="150px" height="150px" alt="dummy" class="img-thumbnail">
                                    @endif
                                </td>
                                <td class="align-middle">
                                <div class="text-right">
                                    <form class="d-inline" action="{{ url('flower/edit/'.$flower->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        
                                        <button type="submit" class="btn btn-info">
                                            <i class="fa fa-pencil"></i> 編集
                                        </button>
                                    </form>
                                    <form class="d-inline" action="{{ url('flower/delete/'.$flower->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        
                                        <button type="submit" class="btn btn-secondary">
                                            <i class="fa fa-trash"></i> 削除
                                        </button>
                                    </form>
                                </div>
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
<div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
          <span aria-hidden="true">&times;</span>
        </button>
        <img id="detail-image" src="/storage/images/{{ optional($flower)->id . '_' . optional($flower)->file_name }}" width="600px" alt="{{ optional($flower)->name }}" class="mt-2 img-thumbnail">
        <div class="m-3">
            <p id="fname"></p>
            <p id="ffamily"></p>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
    // 任意のリンクをモーダル内に読み込む
    $("#ModalCenter").on("show.bs.modal", function(e) {
        const link = $(e.relatedTarget); 
        $(this).find(".modal-body img").attr('src', link.data("image"));
        $(this).find(".modal-body p#fname").text(link.closest("tr").children("td.td_name").first().text());
        $(this).find(".modal-body p#ffamily").text(link.closest("tr").children("td.td_family_name").first().text());
    });
    
    // 科名絞り込みクリア
    $("#search_family_id").val(-1);
    
    // 科名絞り込みセレクトボックス
    $("#search_family_id").change(function() {
       const family_id = $(this).val();
       window.location.href = '/hana-app/public/flowers/family/' + family_id;
    });
       
    // 科名選択
    const family_id = $("#tmp_family_id").val();
    if ( family_id != null ){
        $("#family_id").val(family_id);
    } else {
        $("#family_id").val(-1);
    }
    
    // サムネイル
    $("td .img-thumbnail").hover(
        function() {
           $(this).addClass("border-info");
           $(this).css('cursor','pointer');
        },
        function() {
           $(this).removeClass("border-info");
           $(this).css('cursor','');
        }
    );
    
});

$(document).on('change', ':file', function() {
    const input = $(this),
    numFiles = input.get(0).files ? input.get(0).files.length : 1,
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.parent().parent().next(':text').val(label);
});

</script>
@endsection