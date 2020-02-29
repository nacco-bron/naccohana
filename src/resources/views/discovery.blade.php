@extends('layouts.app')
@section('title', 'Hana App | 発見情報登録')

@section('content')
<div class="container">
    <div class="">

        <!-- regist discovery -->
            <div class="card">
                <div class="card-header">発見情報 登録</div>

                <div class="card-body">
                    @include('common.errors')

                    <form enctype="multipart/form-data" action="{{ url('discovery') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="family_id" class="col-sm-3 control-label">科名</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="family_id" id="family_id">
                                    <option value="0"></option>
                                    @foreach ($families as $family)
                                    <option value="{{ $family->id }}">{{ $family->name }}科</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="tmp_family_id" id="tmp_family_id" value="">
                            </div>
                            <label for="flower_id" class="col-sm-3 control-label">名前</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="flower_id" id="flower_id">
                                    <option value="0"></option>
                                    @foreach ($flowers as $flower)
                                    <option value="{{ $flower->id }}">{{ $flower->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="tmp_flower_id" id="tmp_flower_id"
                                    value="">
                            </div>
                            <label for="image1" class="col-sm-3 control-label">画像1</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <label class="input-group-btn">
                                        <span class="btn btn-info">
                                            Choose File<input type="file" id="image1" name="image1" style="display:none">
                                        </span>
                                    </label>
                                    <input type="text" name="file_name1" class="form-control" readonly=""
                                        value="">
                                </div>
                            </div>
                            <label for="image2" class="col-sm-3 control-label">画像2</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <label class="input-group-btn">
                                        <span class="btn btn-info">
                                            Choose File<input type="file" id="image2" name="image2" style="display:none">
                                        </span>
                                    </label>
                                    <input type="text" name="file_name2" class="form-control" readonly=""
                                        value="">
                                </div>
                            </div>
                            <label for="image3" class="col-sm-3 control-label">画像3</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <label class="input-group-btn">
                                        <span class="btn btn-info">
                                            Choose File<input type="file" id="image3" name="image3" style="display:none">
                                        </span>
                                    </label>
                                    <input type="text" name="file_name3" class="form-control" readonly=""
                                        value="">
                                </div>
                            </div>
                            <label for="image4" class="col-sm-3 control-label">画像4</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <label class="input-group-btn">
                                        <span class="btn btn-info">
                                            Choose File<input type="file" id="image4" name="image4" style="display:none">
                                        </span>
                                    </label>
                                    <input type="text" name="file_name4" class="form-control" readonly="" value="">
                                </div>
                            </div>
                            <label for="discovered_at" class="col-sm-3 control-label">発見日時</label>
                            <div class="col-sm-6">
                                <input type="date" name="discovered_at" id="discovered_at" class="form-control" value="">
                            </div>
                            <label for="lat" class="col-sm-3 control-label">緯度</label>
                            <div class="col-sm-6">
                                <input type="number" name="lat" step="0.0000001" class="form-control"
                                            value="">
                            </div>
                            <label for="lng" class="col-sm-3 control-label">経度</label>
                            <div class="col-sm-6">
                                <input type="number" name="lng" step="0.0000001" class="form-control"
                                            value="">
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-info right">
                                    <i class="fa fa-plus"></i> 登録
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
<script src="{{ asset('js/date.js') }}"></script>
<script>
$(function(){
    $("#discovered_at").val(formatNow());
});
</script>

    @endsection