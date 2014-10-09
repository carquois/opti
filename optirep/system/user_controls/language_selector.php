<?php
	@session_start();
	
	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	
	
	
	$user_lang = $_SESSION['LANGUAGE'];
	
	switch ($user_lang)
	{
		case "fr":
			$lang_abbr = $user_lang;			
			break;
		case "en":
			$lang_abbr = $user_lang;
			break;		
		default:
			$lang_abbr = "fr";
			break;
	}
?>

<select id="lang_selector" name="lang_selector" class="form-control" onchange="lang_select();">
	<?php foreach(cmnGetLanguageList()->languages_list as $language){ ?>
		 <option value="<?php echo($language['language_abbreviation']) ?>" <?php if( $language['language_abbreviation'] == $lang_abbr ) : ?> selected="selected"<?php endif; ?>>
		 	<?php echo($language['language_name']); ?>
		 </option>
    <?php } ?>
</select>

<script type="text/javascript">

	function lang_select()
	{		
		var lang = document.getElementById("lang_selector").value;

		var params = { culture : lang }
		
		$.post('/system/lang/set_culture.php',params,function(){			
		});

		location.reload();
	}
       
</script>


