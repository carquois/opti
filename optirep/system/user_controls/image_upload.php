<?php


// define a constant for the maximum upload size
define ('MAX_FILE_SIZE', 1024 * 1000);

// define constant for upload folder
define('UPLOAD_DIR', "/");

$uploadResult = "";
$success = "";
$file = "";
$filepath = "";


if (array_key_exists('upload', $_POST))
{  
    
    // replace any spaces in original filename with underscores
    $file = str_replace(' ', '_', $_FILES['imageToUpload']['name']);
    
    // create an array of permitted MIME types
    $permitted = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
    
    // upload if file is OK
    if($file != "")
    {
        if (in_array($_FILES['imageToUpload']['type'], $permitted)
            && $_FILES['imageToUpload']['size'] > 0 
            && $_FILES['imageToUpload']['size'] <= MAX_FILE_SIZE)
            {
                switch($_FILES['imageToUpload']['error'])
                {
                    case 0:
                        // check if a file of the same name has been uploaded
                        if (!file_exists(UPLOAD_DIR . $file))
                        {
                            // move the file to the upload folder and rename it
                            $success = move_uploaded_file($_FILES['imageToUpload']['tmp_name'], UPLOAD_DIR . $file);
                            $filepath = UPLOAD_DIR . $file;
                        }
                        else
                        {
                            $uploadResult = lang('A file of the same name already exists');
                            break;
                        }
                    
                        // Verify if upload was successfull
                        if ($success)
                        {
                            $uploadResult = "$file" . lang('Uploaded Successfully');                            
                            break;
                        }
                        else
                        {
                            $uploadResult = lang('Error uploading') . "$file" . lang('Please verify and try again');
                            break;
                        }
                        break;
                    case 3:
                    case 4:
                        $uploadResult = lang('You did not select a file to be uploaded');
                    case 6:
                    case 7:
                    case 8:
                        $uploadResult = lang('Error uploading') . "$file" . lang('Please verify and try again');
                        break;
                    
                }
        }
        else
        {
            $uploadResult = $file . " " . lang('is either too big or not an image or type not supported');
        }
    }
    else
    {
        $uploadResult = lang('You did not select a file to be uploaded');
    }
    
    
}
?>

<form action="" method="post" enctype="multipart/form-data" name="uploadImage" id="uploadImage">
    <p>
      <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
      <label><?php lang('Logo'); ?></label>
      
      <input type="file" name="imageToUpload" id="imageToUpload"  />
      <img id="thumb" name="img1" src="<?php  echo($filepath);  ?>">
    </p>
    <p>
        <input type="submit" name="upload" value="<?php lang('Select'); ?>" />    
    </p>
    
    <!-- DEBUG -->
    <!--<label><?php  echo($filepath);  ?></label>-->
    
    
    

</form>





