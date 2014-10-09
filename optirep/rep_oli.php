<!doctype html>
<!--<div class="alert alert-danger"><?php require('config.php'); ?></div>-->
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Opti-Rep</title>
	<link rel="stylesheet" href="content/css/style-rep.css" />
</head>
<body>

<div id="map_wrap"></div><!-- /#map-wrap -->

<header>

	<nav class="navbar navbar-inverse" role="navigation">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#">Opti-Rep</a>
	    </div>
	
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li class="active"><a href="#">Link</a></li>
	        <li><a href="#">Link</a></li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Action</a></li>
	            <li><a href="#">Another action</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	            <li class="divider"></li>
	            <li><a href="#">One more separated link</a></li>
	          </ul>
	        </li>
	      </ul>
	      <form class="navbar-form navbar-left" role="search">
	        <div class="form-group">
	          <input type="text" class="form-control" placeholder="Search">
	        </div>
	        <button type="submit" class="btn btn-inverse">Submit</button>
	      </form>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="#">Link</a></li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Action</a></li>
	            <li><a href="#">Another action</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	          </ul>
	        </li>
	        <li><?php include("system/user_controls/language_selector.php"); ?></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

</header>


<!--
<div id="main_container" class="container">
	
	<div class="col-md-6 col-md-offset-3">
		
		<h2><?php lang('Welcome'); ?></h2>
		<p class="lead"><?php lang('Thank you'); ?></p>
		<p><?php echo($home_path); ?></p>
		
		
		<?php include("system/admin/views/login.php"); ?>
		
		<hr />
		<a href="system/admin/admin.php">admin</a>
		
		
	</div>
	
	<div class="col-md-12">
		
		
		<ul class="nav nav-tabs">
		  <li class="active"><a href="#home" data-toggle="tab">Home</a></li>
		  <li><a href="#profile" data-toggle="tab">Profile</a></li>
		  <li><a href="#messages" data-toggle="tab">Messages</a></li>
		  <li><a href="#settings" data-toggle="tab">Settings</a></li>
		</ul>
		
		
		<div class="tab-content">
		  <div class="tab-pane active" id="home">...</div>
		  <div class="tab-pane" id="profile">...</div>
		  <div class="tab-pane" id="messages">...</div>
		  <div class="tab-pane" id="settings">...</div>
		</div>
				
		
	</div>	
	
  
	
		
</div>
-->

<footer></footer>



<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="content/js/bootstrap.min.js" type="text/javascript">></script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-44R_oUpOUEEX8eksEIawM6tTJ91U_3w&amp;sensor=false"></script>
<script type="text/javascript" src="content/js/downloadxml.js" ></script>
<script src="content/js/map-xml2.js"></script>

</body>
</html>

