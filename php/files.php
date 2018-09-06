<?php

function fileUpload(array $file, string $path, string $newName = '')
{
    $tempFile = $file["tmp_name"];
	
	if (file_exists($tempFile))
	{
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

        if (!$newName) 
        {
        	$newName = uniqid()  . '.' . $extension;
        }

        move_uploaded_file($tempFile, $path . $newName);

        return $newName;
    }
    else
    {
    	return false;
    }

}

function fileDownload($path, $downloadName = null)
{
	if (file_exists($path))
	{
		if(!$downloadName)
		{
			$downloadName = basename($path);
		}

	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename="' . $downloadName . '"');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($path));
	    readfile($path);
	    exit;
	}
}

