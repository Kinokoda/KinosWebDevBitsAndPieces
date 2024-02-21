<!-- PHP Based file index creator. Made by Kinokoda. -->

<?php
$fileList = scandir('./'); #Scan the current directory for files and folders
$tempArr = explode('/', getcwd());
echo "<h1 style = 'text-align: center;'>Index of ".$tempArr[count($tempArr)-1]."</h1>"; #Title of the page
for ($i = 0; $i < count($fileList); $i++)  #Loop through the array of files and folders
{
    $hideCheck = $fileList[$i];
    if(is_dir($fileList[$i]) && $fileList[$i] != '.' && $hideCheck[0] != '.')  #If the current item is a folder...
    {
        if ($fileList[$i] == '..')  #and if it is the parent
        {
            echo "<a href='../' >Go Back</a><br>"; 
        }
        
        else
        {
        echo "<p><a href='./$fileList[$i]'><b><span>[DIR]</span></b> $fileList[$i]</a></p>";
        }
    }
    
    elseif(is_file($fileList[$i]))
    {
        if ($fileList[$i] != "index.php")
        {
            echo "<a href='./$fileList[$i]'><span>[FILE]</span> $fileList[$i]</a><br>";
        }
        
    }
}

?>

<style> /*Styling the page*/
    span
    {
        color: green;
    }
    a:link
    {
        color: ;
    }
    a:visited
    {
        color: purple;
        
    }
    a:active
    {
        color: red;
    }
    a:hover
    {
        color: orange;
    }
</style>