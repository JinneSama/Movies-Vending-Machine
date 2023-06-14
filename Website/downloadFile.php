<?php 

if(isset($_GET['dl']))
{
    $var_1 = $_GET['dl'];
    $file = $var_1;
    $file = str_replace('\\', '/', $file);


	set_time_limit(0); 
	ini_set('memory_limit', '512M'); 
	$filePath = $file; 
	downloadFiles($filePath);
	
            echo '<script> location.href="' . $filePath . '"</script>';
}

function downloadFiles($filePath) 
{     
  include("fileTypes.php");
    if(!empty($filePath)) 
    { 
        $fileInfo = pathinfo($filePath); 
        $fileName  = $fileInfo['basename']; 
        $fileExtnesion   = $fileInfo['extension']; 
        $default_contentType = "application/octet-stream"; 
        $content_types_list = mimeTypes(); 
        if (array_key_exists($fileExtnesion, $content_types_list))  
        { 
            $contentType = $content_types_list[$fileExtnesion]; 
        } 
        else 
        { 
            $contentType =  $default_contentType; 
        } 
        if(file_exists($filePath)) 
        { 
            $size = filesize($filePath); 
            $offset = 0; 
            $length = $size; 
            if(isset($_SERVER['HTTP_RANGE'])) 
            { 
                preg_match('/bytes=(\d+)-(\d+)?/', $_SERVER['HTTP_RANGE'], $matches); 
                $offset = intval($matches[1]); 
                $length = intval($matches[2]) - $offset; 
                $fhandle = fopen($filePath, 'r'); 
        fseek($fhandle, $offset); 
                $data = fread($fhandle, $length); 
                fclose($fhandle); 
                header('HTTP/1.1 206 Partial Content'); 
                header('Content-Range: bytes ' . $offset . '-' . ($offset + $length) . '/' . $size); 
            }
            //Heasers for download
            header("Content-Disposition: attachment;filename=".$fileName); 
            header('Content-Type: '.$contentType); 
            header("Accept-Ranges: bytes"); 
            header("Pragma: public"); 
            header("Expires: -1"); 
            header("Cache-Control: no-cache"); 
            header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0"); 
            header("Content-Length: ".filesize($filePath)); 
            $chunksize = 8 * (1024 * 1024); //8MB (highest possible fread length) 
            if ($size > $chunksize) 
            { 
              $handle = fopen($_FILES["file"]["tmp_name"], 'rb'); 
              $buffer = ''; 
              while (!feof($handle) && (connection_status() === CONNECTION_NORMAL))  
              { 
                $buffer = fread($handle, $chunksize); 
                print $buffer; 
                ob_flush(); 
                flush(); 
              } 
              if(connection_status() !== CONNECTION_NORMAL) 
              { 
                echo "Connection aborted"; 
              } 
              fclose($handle); 
            } 
            else  
            { 
              ob_clean(); 
              flush(); 
              readfile($filePath); 
            } 
         } 
         else 
         { 
           echo 'File does not exist!'; 
         } 
    } 
    else 
    { 
        echo 'There is no file to download!'; 
    } 
}   
?>