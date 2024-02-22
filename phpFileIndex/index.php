<!-- PHP Based file index creator. Made by Kinokoda. Thanks panos907 for the help!-->

<?php

$filesExcluded = ['index.php', 'style.css']; #Files to exclude from the index
$fileList = scandir('./'); #Scan the current directory for files and folders
$tempArr = explode('/', getcwd()); #Get the current directory name.
echo "<h1 style = 'text-align: center;'>Index of ".$tempArr[count($tempArr)-1]."</h1>"; #Main Header of the index.
foreach($fileList as $file) #For each file in the directory
{
    if (array_search($file, $filesExcluded, true) !== false) #If the file is in the excluded list
    unset($fileList[$file]); #Remove it from the list
    else
    {
        if ($file == '..')  #and if it is the parent
        {
            echo "<h3><a href='../' >Go Back</a></h3>"; #Add the "Go Back" option.
        }else

        if(is_dir($file) && $file != '.' && $file != '..' && !($file[0] == '.' && $file[1] != '.'))  /*Check if the current item is a folder 
                                                                                                       and not the current or parent directory
                                                                                                       or a hidden folder.*/
        {
            echo "<p><a href='./$file'><b><span>[DIR]</span></b> $file</a></p>"; #List the folder.
        }
        
        elseif(is_file($file)) #Check if the current item is a file
        {
            echo "<a href='./$file'><span>[FILE]</span> $file</a><br>";     #List the file.
        }
    }
}
?>

<link rel="stylesheet" href="Put your style sheet URL here!"> <!-- Link to your style sheet. -->