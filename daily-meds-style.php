<?php
$base = (isset($_GET['base']) ? $_GET['base'] : "");
header('Content-type: text/css');
?>
.widget_daily_meds .inside {

}

.widget_daily_meds .overflow {
	background-image: url(<?php echo $base; ?>/images/middle.gif);
	width: 190px;
	padding: 0 15px;
}

.widget_daily_meds .top {
	display: block;
	background-image: url(<?php echo $base; ?>/images/top.gif);
	width: 220px;
	height: 25px;
	margin-left: -15px;
}

.widget_daily_meds h2 {
	margin: 5px 0 5px 0;
	padding: 0;
	font-size: 18px;
	font-family: CenturyGothic,Helvetica,Arial;
	color: #C9C8C8
	font-weight: normal;
	font-style: normal;
}
.widget_daily_meds h2 a,
.widget_daily_meds h2 a:visited {
	color: #C9C8C8;
}

.widget_daily_meds p.credit,
.widget_daily_meds p.credit a,
.widget_daily_meds p.credit a:visited {
	color: #ccc;
	font-style: italic;
	text-align: right;
	font-size: 8px;
	margin-bottom: 5px;
}

.widget_daily_meds .bottom {
	display: block;
	background-image: url(<?php echo $base; ?>/images/bottom.gif);
	width: 220px;
	height: 21px;
	margin-left: -15px;
}