@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">Search Home</div>
          <div class="panel-body">
            <form action="{{ URL('admin/search') }}" method="GET">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="text" name="keyword" class="form-control" required="required" value="{{ $keyword }}">
              <br>
              <label class="label label-default">Match Mode</label>
              <select class="form-control" name="matchMode">
                <option value="SPH_MATCH_BOOLEAN" @if ($matchMode == "SPH_MATCH_BOOLEAN") selected @endif>SPH_MATCH_BOOLEAN</option>
                <option value="SPH_MATCH_ANY" @if ($matchMode == "SPH_MATCH_ANY") selected @endif>SPH_MATCH_ANY</option>
                <option value="SPH_MATCH_ALL" @if ($matchMode == "SPH_MATCH_ALL") selected @endif>SPH_MATCH_ALL</option>
                <!-- <option value="SPH_MATCH_FULLSCAN">SPH_MATCH_FULLSCAN</option> -->
              </select>
              <br>
              <label class="label label-default">Rank Mode</label>
              <select class="form-control" name="rankMode">
                <option value="SPH_RANK_PROXIMITY_BM25" @if ($rankMode == "SPH_RANK_PROXIMITY_BM25") selected @endif>SPH_RANK_PROXIMITY_BM25</option>
                <option value="SPH_RANK_NONE" @if ($rankMode == "SPH_RANK_NONE") selected @endif>SPH_RANK_NONE</option>
                <option value="SPH_RANK_WORDCOUNT" @if ($rankMode == "SPH_RANK_WORDCOUNT") selected @endif>SPH_RANK_WORDCOUNT</option>
                <option value="SPH_RANK_SPH04" @if ($rankMode == "SPH_RANK_SPH04") selected @endif>SPH_RANK_SPH04</option>
              </select>
              <br>
              <button class="btn btn-lg btn-info">Search</button>
            </form>
          </div>

        <div class="panel-body">

        <a href="{{ URL('admin/files/create') }}" class="btn btn-lg btn-primary">Add</a>
          @foreach ($files as $file)
            <hr>
            <div class="page">
              <h4>{{ $file->name }}</h4>
              <div class="content">
                <a href="#" onclick="window.open('{{ URL('admin/similarity/'.$file->id) }}', '');">Click to see related files</a>
                &nbsp&nbsp|&nbsp&nbsp
                <a href="{{ URL('admin/files/'.$file->id) }}">Click to download file</a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection