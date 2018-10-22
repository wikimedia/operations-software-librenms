<?php

// Draw generic bits graph
// args: ds_in, ds_out, rrd_filename, bg, legend, from, to, width, height, inverse, $percentile
require 'includes/graphs/common.inc.php';

$length = '10';

if (!isset($percentile)) {
    $length += '2';
}

if (!isset($out_text)) {
    $out_text = 'Out';
}

if (!isset($in_text)) {
    $in_text = 'In';
}

$unit_text = str_pad(truncate($unit_text, $length), $length);
$in_text   = str_pad(truncate($in_text, $length), $length);
$out_text  = str_pad(truncate($out_text, $length), $length);

$rrd_options .= ' DEF:'.$out.'='.$rrd_filename.':'.$ds_out.':AVERAGE';
$rrd_options .= ' DEF:'.$in.'='.$rrd_filename.':'.$ds_in.':AVERAGE';
$rrd_options .= ' DEF:'.$out.'_max='.$rrd_filename.':'.$ds_out.':MAX';
$rrd_options .= ' DEF:'.$in.'_max='.$rrd_filename.':'.$ds_in.':MAX';
$rrd_options .= ' CDEF:dout_max=out_max,-1,*';
$rrd_options .= ' CDEF:dout=out,-1,*';
$rrd_options .= ' CDEF:both=in,out,+';
if ($print_total) {
    $rrd_options .= ' VDEF:totin=in,TOTAL';
    $rrd_options .= ' VDEF:totout=out,TOTAL';
    $rrd_options .= ' VDEF:tot=both,TOTAL';
}

if ($percentile) {
    $rrd_options .= ' VDEF:percentile_in=in,'.$percentile.',PERCENT';
    $rrd_options .= ' VDEF:percentile_out=out,'.$percentile.',PERCENT';
    $rrd_options .= ' VDEF:dpercentile_out=dout,'.$percentile.',PERCENT';
}

if ($graph_max) {
    $rrd_options .= ' AREA:in_max#'.$colour_area_in_max.':';
    $rrd_options .= ' AREA:dout_max#'.$colour_area_out_max.':';
}

if ($_GET['previous'] == 'yes') {
    $rrd_options .= ' DEF:'.$out.'X='.$rrd_filename.':'.$ds_out.':AVERAGE:start='.$prev_from.':end='.$from;
    $rrd_options .= ' DEF:'.$in.'X='.$rrd_filename.':'.$ds_in.':AVERAGE:start='.$prev_from.':end='.$from;
    $rrd_options .= ' DEF:'.$out.'_maxX='.$rrd_filename.':'.$ds_out.':MAX:start='.$prev_from.':end='.$from;
    $rrd_options .= ' DEF:'.$in.'_maxX='.$rrd_filename.':'.$ds_in.':MAX:start='.$prev_from.':end='.$from;
    $rrd_options .= ' SHIFT:'.$out."X:$period";
    $rrd_options .= ' SHIFT:'.$in."X:$period";
    $rrd_options .= ' SHIFT:'.$out."_maxX:$period";
    $rrd_options .= ' SHIFT:'.$in."_maxX:$period";
    $rrd_options .= ' CDEF:dout_maxX=out_maxX,-1,*';
    $rrd_options .= ' CDEF:doutX=outX,-1,*';
    $rrd_options .= ' CDEF:bothX=inX,outX,+';
    if ($print_total) {
        $rrd_options .= ' VDEF:totinX=inX,TOTAL';
        $rrd_options .= ' VDEF:totoutX=outX,TOTAL';
        $rrd_options .= ' VDEF:totX=bothX,TOTAL';
    }

    if ($percentile) {
        $rrd_options .= ' VDEF:percentile_inX=inX,'.$percentile.',PERCENT';
        $rrd_options .= ' VDEF:percentile_outX=outX,'.$percentile.',PERCENT';
        $rrd_options .= ' VDEF:dpercentile_outX=doutX,'.$percentile.',PERCENT';
    }

    if ($graph_max) {
        $rrd_options .= ' AREA:in_max#'.$colour_area_in_max.':';
        $rrd_options .= ' AREA:dout_max#'.$colour_area_out_max.':';
    }
}//end if

$rrd_options .= ' AREA:in#'.$colour_area_in.':';
$rrd_options .= " COMMENT:'".$unit_text.'      Now       Ave      Max';

if ($percentile) {
    $rrd_options .= '      '.$percentile.'th %';
}

$rrd_options .= "\\n'";
$rrd_options .= ' LINE1.25:in#'.$colour_line_in.":'".$in_text."'";
$rrd_options .= ' GPRINT:in:LAST:%6.2lf%s';
$rrd_options .= ' GPRINT:in:AVERAGE:%6.2lf%s';
$rrd_options .= ' GPRINT:in_max:MAX:%6.2lf%s';

if ($percentile) {
    $rrd_options .= ' GPRINT:percentile_in:%6.2lf%s';
}

$rrd_options .= " COMMENT:\\n";
$rrd_options .= ' AREA:dout#'.$colour_area_out.':';
$rrd_options .= ' LINE1.25:dout#'.$colour_line_out.":'".$out_text."'";
$rrd_options .= ' GPRINT:out:LAST:%6.2lf%s';
$rrd_options .= ' GPRINT:out:AVERAGE:%6.2lf%s';
$rrd_options .= ' GPRINT:out_max:MAX:%6.2lf%s';

if ($percentile) {
    $rrd_options .= ' GPRINT:percentile_out:%6.2lf%s';
}

$rrd_options .= " COMMENT:\\n";

if ($print_total) {
    $rrd_options .= " GPRINT:tot:'Total %6.2lf%s'";
    $rrd_options .= " GPRINT:totin:'(In %6.2lf%s'";
    $rrd_options .= " GPRINT:totout:'Out %6.2lf%s)\l'";
}

if ($percentile) {
    $rrd_options .= ' LINE1:percentile_in#aa0000';
    $rrd_options .= ' LINE1:dpercentile_out#aa0000';
}

if ($_GET['previous'] == 'yes') {
    $rrd_options .= ' LINE1.25:in'.$format."X#666666:'Prev In \\\\n'";
    $rrd_options .= ' AREA:in'.$format.'X#99999966:';
    $rrd_options .= ' LINE1.25:dout'.$format."X#666666:'Prev Out'";
    $rrd_options .= ' AREA:dout'.$format.'X#99999966:';
}

$rrd_options .= ' HRULE:0#999999';
