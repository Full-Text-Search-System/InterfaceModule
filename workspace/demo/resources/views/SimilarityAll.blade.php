@extends('app')

@section('content')
<div class="container">

<div id="main" role="main">
  <article class="entry">
    <div class="entry-wrapper">
      <div class="entry-content">
        <div id="chart" style="width: 50%; margin: 0px auto; position: relative;"></div>
          <p style="color:black; font-size: 100%; text-align: center;">This chord diagram shows pairwise similarity between all documents in our full-text search system.</p>
<style>
#circle circle {
  fill: none;
  pointer-events: all;
}
.group path {
  fill-opacity: .5;
}
path.chord {
  stroke: #000;
  stroke-width: .25px;
}
#circle:hover path.fade {
  display: none;
}
</style>

<script src="http://d3js.org/d3.v2.min.js?2.8.1"></script>

<script>
  var width = 720,
      height = 720,
      outerRadius = Math.min(width, height) / 2 - 10,
      innerRadius = outerRadius - 24;
  var formatPercent = d3.format(".1%");
  var arc = d3.svg.arc()
      .innerRadius(innerRadius)
      .outerRadius(outerRadius);
  var layout = d3.layout.chord()
      .padding(.04)
      .sortSubgroups(d3.descending)
      .sortChords(d3.ascending);
  var path = d3.svg.chord()
      .radius(innerRadius);
  var svg = d3.select("#chart").append("svg")
      .attr("width", '100%')
      .attr("height", '100%')
      .attr('viewBox','0 0 '+(Math.min(width,height))+' '+Math.min(width,height))
      .attr('preserveAspectRatio','xMinYMin')
    .append("g")
      .attr("id", "circle")
      .attr("transform", "translate(" + (Math.min(width,height)/2) + "," + Math.min(width,height)/2 + ")");
  svg.append("circle")
      .attr("r", outerRadius);

  //transfer name
  var fileNames = new Array();
  @foreach($filenames as $value)
      fileNames.push({"name":"{{$value}}"});
  @endforeach

  var ids = new Array();
  @foreach($ids as $value)
      ids.push({"name":"{{$value}}", "color":"#F781BF"});
  @endforeach
  var id = ids;

  //transfer score to matrix
  var matrixs = new Array();
  @foreach($res as $line)
      var score = new Array();
      @foreach($line as $s)
          score.push({{ $s }});
      @endforeach
      matrixs.push(score);
  @endforeach

  var matrix = matrixs;
  console.log(matrix);

  // Compute the chord layout.
  layout.matrix(matrix);

  // Add a group per neighborhood.
  var group = svg.selectAll(".group")
      .data(layout.groups)
    .enter().append("g")
      .attr("class", "group")
      .on("mouseover", mouseover);

  // Add a mouseover title.
  group.append("title").text(function(d, i) {
    return fileNames[i].name;
  });

  // Add the group arc.
  var groupPath = group.append("path")
      .attr("id", function(d, i) { return "group" + i; })
      .attr("d", arc)
      .style("fill", function(d, i) { return id[i].color; });

  // Add a text label.
  var groupText = group.append("text")
      .attr("x", 6)
      .attr("dy", 15);
  groupText.append("textPath")
      .attr("xlink:href", function(d, i) { return "#group" + i; })
      .text(function(d, i) { return id[i].name; });

  // Add the chords.
  var chord = svg.selectAll(".chord")
      .data(layout.chords)
    .enter().append("path")
      .attr("class", "chord")
      .style("fill", function(d) { return id[d.source.index].color; })
      .attr("d", path);

  // Add an elaborate mouseover title for each chord.
  chord.append("title").text(function(d) {
    return fileNames[d.source.index].name
        + " → " + fileNames[d.target.index].name
        + ": " + matrix[d.source.index][d.target.index];
  });

  function mouseover(d, i) {
    chord.classed("fade", function(p) {
      return p.source.index != i
          && p.target.index != i;
    });
}
</script>

      </div><!-- /.entry-content -->
    </div><!-- /.entry-wrapper -->
  </article>
</div><!-- /#main -->

  <div class="row">
  </div>
</div>
@endsection
