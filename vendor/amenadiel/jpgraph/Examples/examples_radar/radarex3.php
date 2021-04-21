<?php // content="text/plain; charset=utf-8"
require_once('jpgraph/jpgraph.php');
require_once('jpgraph/jpgraph_radar.php');
    
// Some data to plot
$data = array(55,80,46,71,95);
    
// Create the graph and the plot
$graph = new RadarGraph(250, 200);

// Create the titles for the axis
$titles = $gDateLocale->GetShortMonth();
$graph->SetTitles($titles);

$plot = new RadarPlot($data);
$plot->SetFillColor('lightblue');

// Add the plot and display the graph
$graph->Add($plot);
$graph->Stroke();
