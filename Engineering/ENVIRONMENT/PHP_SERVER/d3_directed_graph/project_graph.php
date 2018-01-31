<!DOCTYPE html>
<meta charset="utf-8">
<style>

.link {
  fill: none;
  stroke: #666;
  stroke-width: 1.5px;
}

#licensing {
  fill: green;
}

.link.licensing {
  stroke: green;
}

.link.resolved {
  stroke-dasharray: 0,2 1;
}

circle {
  fill: #ccc;
  stroke: #333;
  stroke-width: 1.5px;
}

text {
  font: 10px sans-serif;
  pointer-events: none;
  text-shadow: 0 1px 0 #fff, 1px 0 0 #fff, 0 -1px 0 #fff, -1px 0 0 #fff;
}

</style>
<body>
<!--script src="//d3js.org/d3.v3.min.js"></script-->
<script src="d3.v3.min.js"></script>
<script>

// http://blog.thomsonreuters.com/index.php/mobile-patent-suits-graphic-of-the-day/
var links = [
<?php
//echo "Running ".__FILE__."<br/>\n";
$target=rtrim($_GET['target'], "/");				// ex /doc/files/temp/toto or /doc/files/temp/toto/

function project_name($path)
{
$pieces = explode('/', $path);
$last_word = array_pop($pieces);
//return $last_word;
return $path;
}
/*

Algorithm pour traverser un graph
directed graph traversal algorithm

1  procedure DFS-iterative(G,v):
2      let S be a stack
3      S.push(v)
4      while S is not empty
5          v = S.pop()
6          if v is not labeled as discovered:
7              label v as discovered
8              for all edges from v to w in G.adjacentEdges(v) do
9                  S.push(w)

*/
//echo "algo<br/>\n";
$stack=array();
$list_finished=array();
array_push($stack, array($target,""));
while(!empty($stack)) {
  $v=array_pop($stack);
  //echo $v[0]."-".$v[1]."- <br/>\n";
  if($v[1]!="discovered") {
    $v[1]="discovered";
    //echo "node : ".$v[0]."-".$v[1]."- <br/>\n";
    //echo 'g.addNode("'.project_name($v[0]).'");'."\n";
	
	
	
	/**/
	
	$file_path="C:/UniServer/www".$v[0]."/.next";
	if ( 0 == filesize( $file_path ) )
	{
		// file is empty
		//echo "not found next<br/>\n";
	} else {
		//echo "found next<br/>\n";
		$strfile = file_get_contents($file_path);
		
	preg_match_all ("/<a href=\"(.*)\/open-command-prompt-here.html\"/", $strfile, $next_array);
   //print $next_array[0][0]." <br> res 1: ".$next_array[0][1]."\n";	
	$target_next=substr($next_array[0][0],9,-31);
	//echo $target_next."<br/>\n";
	if($list_finished[$target_next]!="finished") {
		array_push($stack, array($target_next,""));
		//echo "g.addEdge('".project_name($v[0])."', '".project_name($target_next)."' , { directed: true });\n";
                  echo '{source: "'.project_name($v[0]).'", target: "'.project_name($target_next).'", type: "licensing"},'."\n";
	}
	}
/**/
	$file_path="C:/UniServer/www".$v[0]."/.previous";
	//echo "file_path is ".$file_path."<br/>\n";
	if ( 0 == filesize( $file_path ) )
	{
		// file is empty
		//echo "not found previous<br/>\n";
	} else {
		//echo "found previous<br/>\n";
		$strfile = file_get_contents($file_path);

		preg_match_all ("/<a href=\"(.*)\/open-command-prompt-here.html\"/", $strfile, $previous_array);	
	
		foreach ($previous_array[0] as &$value) {
			$target_prev = substr($value,9,-31);
			//echo $target_prev."<br/>\n";
			if($list_finished[$target_prev]!="finished") {
				array_push($stack, array($target_prev,""));
				//echo "g.addEdge('".project_name($target_prev)."', '".project_name($v[0])."' , { directed: true });\n";
                                //echo '{source: "'.project_name($target_prev).'", target: "'.project_name($v[0]).'", type: "licensing"},'."\n";
								echo '{source: "'.project_name($target_prev).'", target: "'.project_name($v[0]).'", type: "licensing"},'."\n";

			}
		}
	} // all previous done
	
	//echo "finished ".$v[0]."\n";
	$list_finished[$v[0]]="finished";

	
	
	
	
  
  } else { // discovered 
    //echo "node : ".$v[0]."-".$v[1]."- <br/>\n";
    //echo 'g.addNode("'.project_name($v[0]).'");'."\n";

  }
  //break;
} // while

?>
];

var nodes = {};
//var nodes = [
//    { name : "A", x:   width/3, y: height/2,  "url":  "https://www.google.com" },
//    { name : "B", x: 2*width/3, y: height/2 }
//];

// Compute the distinct nodes from the links.
links.forEach(function(link) {
  link.source = nodes[link.source] || (nodes[link.source] = {name: link.source});
  link.target = nodes[link.target] || (nodes[link.target] = {name: link.target});
});

var width = 960,
    height = 500;
var word = "gongoozler";


var force = d3.layout.force()
    .nodes(d3.values(nodes))
    .links(links)
    .size([width, height])
    .linkDistance(60)
    .charge(-300)
    .on("tick", tick)
    .start();

var svg = d3.select("body").append("svg")
    .attr("width", width)
    .attr("height", height);
	
// Per-type markers, as they don't inherit styles.
svg.append("defs").selectAll("marker")
    .data(["suit", "licensing", "resolved"])
  .enter().append("marker")
    .attr("id", function(d) { return d; })
    .attr("viewBox", "0 -5 10 10")
    .attr("refX", 15)
    .attr("refY", -1.5)
    .attr("markerWidth", 6)
    .attr("markerHeight", 6)
    .attr("orient", "auto")
  .append("path")
    .attr("d", "M0,-5L10,0L0,5");

var path = svg.append("g").selectAll("path")
    .data(force.links())
  .enter().append("path")
    .attr("class", function(d) { return "link " + d.type; })
    .attr("marker-end", function(d) { return "url(#" + d.type + ")"; });

var circle = svg.append("g").selectAll("circle")
    .data(force.nodes())
  .enter()
  .append("a")
.attr("xlink:href", function(d) { return d.name+"/open-command-prompt-here.html"; })
//    .append("circle")
//    .attr("r", 8)
//    .style("fill", function(d) { return d.name=="<?php echo $target;?>"?"purple":"#ccc"; })  // differencie par la couleur du disque
    .call(force.drag);

  circle.append("image")
      .attr("xlink:href", function(d) { return d.name+"/favicon.ico"; })
      .attr("x", -8)
      .attr("y", -8)
      .attr("width", 16)
      .attr("height", 16);

var text = svg.append("g").selectAll("text")
    .data(force.nodes())
  .enter().append("text")
    .attr("x", -20)
    .attr("y", -10)
	.style('fill', function(d) { return d.name=="<?php echo $target;?>"?"Red":"Black"; })
	// TODO: differencier le projet courant en mettant le text en gras
    .text(function(d) { n = d.name.lastIndexOf("/"); return d.name.substring(n+1); });

// Use elliptical arc path segments to doubly-encode directionality.
function tick() {
  path.attr("d", linkArc);
  circle.attr("transform", transform);
  text.attr("transform", transform);
}

function linkArc(d) {
  var dx = d.target.x - d.source.x,
      dy = d.target.y - d.source.y,
      dr = Math.sqrt(dx * dx + dy * dy);
  return "M" + d.source.x + "," + d.source.y + "A" + dr + "," + dr + " 0 0,1 " + d.target.x + "," + d.target.y;
}

function transform(d) {
  return "translate(" + d.x + "," + d.y + ")";
}








</script>



</body>
</html>
