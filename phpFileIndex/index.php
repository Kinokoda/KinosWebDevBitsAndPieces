<?php

$fileList = scandir('./'); #Scan the current directory for files and folders
for ($i = 0; $i < count($fileList); $i++)  #Loop through the array of files and folders
{
    if(is_dir($fileList[$i]) && $fileList[$i] != '.')  #If the current item is a folder...
    {
        if ($fileList[$i] == '..')  #and if it is the parent
        {
            echo "<a href='../'>Go Back</a><br>"; 
        }

    }elseif(is_file($fileList[$i]))
    {
        echo "$fileList[$i] is a file <br>";
    }
}

?>