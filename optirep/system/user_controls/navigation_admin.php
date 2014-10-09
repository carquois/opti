<nav class="navbar navbar-default" role="navigation">
	<div class="container"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
        <span class="sr-only">Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/system/admin/admin.php">Opti-Rep</a> 
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="collapse">
	   
	    
	      <ul class="nav navbar-nav">
	        
	        
			
			<li><a href="/system/admin/views/site_predefined_lists.php"><?php lang('Predefined Lists'); ?></a></li>
			
			<li><a href="/system/admin/views/groupings.php"><?php lang('Groupings'); ?></a></li>
			
			<li><a href="/system/admin/views/companies.php"><?php lang('Companies'); ?></a></li>
					
			<li><a href="/system/admin/views/suppliers.php"><?php lang('Suppliers'); ?></a></li>
			
			<li><a href="/system/admin/views/organizations.php"><?php lang('Organizations'); ?></a></li>
			
			<li><a href="/system/admin/views/retailers.php"><?php lang('Retailers'); ?></a></li>
			
			<li><a href="/system/admin/views/professionals.php"><?php lang('Professionals'); ?></a></li>
			
			<li><a href="/system/admin/views/reps.php"><?php lang('Representatives'); ?></a></li>
			
			<li><a href="/system/admin/views/modifications_history.php"><?php lang('Modifications history'); ?></a></li>
			
	        <!--
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
	        -->
	        
	      </ul>
	   
	    	 <ul class="nav navbar-nav pull-right">
	        
				 <li><a href="/system/admin/views/site_configuration.php"><span title="<?php lang('Site Configuration'); ?>" alt="<?php lang('Site Configuration'); ?>" class="glyphicon glyphicon-cog"></span></a></li>
				 
				 <li class="dropdown">
					 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
					 	<span class="glyphicon glyphicon-user"></span>
					 </a>
					 <ul class="dropdown-menu">
					 	<li class="disabled"><a href="">Admin name</a></li>
					 	<li class="divider"></li>
			            <li><a href="#"><span class="glyphicon glyphicon-log-out"></span> <?php lang('Log Out'); ?></a></li>
					 </ul>
				 </li>
				 
				 <li><?php include("language_selector.php"); ?></li>
	        
	    	 </ul>
	    
	
	      
     </div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</nav>