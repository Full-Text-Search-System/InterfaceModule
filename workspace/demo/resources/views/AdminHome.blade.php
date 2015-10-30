@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">Admin Home</div>
          <div class="panel-body">
            <form action="{{ URL('admin/search') }}" method="GET">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="text" name="keyword" class="form-control" required="required">
              <br>
              <label class="label label-default">Match Mode</label>
              <select class="form-control" name="matchMode">
                <option value="SPH_MATCH_BOOLEAN" selected>SPH_MATCH_BOOLEAN</option>
                <option value="SPH_MATCH_ANY">SPH_MATCH_ANY</option>
                <option value="SPH_MATCH_ALL">SPH_MATCH_ALL</option>
                <!-- <option value="SPH_MATCH_FULLSCAN">SPH_MATCH_FULLSCAN</option> -->
              </select>
              <br>
              <label class="label label-default">Rank Mode</label>
              <select class="form-control" name="rankMode">
                <option value="SPH_RANK_PROXIMITY_BM25" selected>SPH_RANK_PROXIMITY_BM25</option>
                <option value="SPH_RANK_NONE">SPH_RANK_NONE</option>
                <option value="SPH_RANK_WORDCOUNT">SPH_RANK_WORDCOUNT</option>
                <option value="SPH_RANK_SPH04">SPH_RANK_SPH04</option>
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