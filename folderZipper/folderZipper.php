<?php
/*
This took a bit to make, but we are finally here! Welcoem to folderZipper. This lil' fella takes a folder and its contents, puts them in a zip, and then streams the zip
to the users who requested the download. I wrote this so that i wouldn't have to store zips of folders for people to download. It also seemed like a fun idea. Thanks to 
Mr. Nikos from the 1st Vocational High School of Chaidari for fixing a weird bug with the slashes.
*/
$autoloadDir = $_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php";        //Set this to your composer project's directory.
require $autoloadDir;

function folderSleuth($dirName, $didInit = false, $startDirParent = "", $zipStreamItem)     //Finds and adds the folders and files of our selected folder inside the zipStream.
{
    if (!$didInit)      //Init code, must run only at the start.
    {
        $startDirParent = (explode("/", realpath($dirName)))[count(explode("/", realpath($dirName)))-2];
    }

    $dirCount = 0;
    $trueDirName = realpath($dirName);      //Get definitive path of our folder.
    $workingPath = explode("/", $trueDirName);      //Seperate path folders into seperate elements of a temporary array.
    array_splice($workingPath, 0, array_search($startDirParent, $workingPath) + 1);     //Remove the folders we do not require for the zip's folder structure.
    $workingPath = implode("/", $workingPath);      //Consolidate the array into a new string.

    foreach (scandir($trueDirName) as $currentItem) //Count the folders.
    { 
        if ($currentItem[0] == '.') 
        {
            continue;   //Skip hidden stuff.
        } 
        elseif (is_dir($trueDirName . DIRECTORY_SEPARATOR . $currentItem)) 
        {
            $dirCount++;       //Increment folder counter.
        } 
        elseif (is_file($trueDirName . DIRECTORY_SEPARATOR . $currentItem)) 
        {
            continue;   //Skip files.
        }
    }
    if ($dirCount == 0)     //List all the files found if there are no directories in our folder.
    {
        foreach (scandir($trueDirName) as $currentItem)
        {
            if ($currentItem[0] == '.' | pathinfo($currentItem, PATHINFO_EXTENSION) == "php") {     //Ignore php and hidden files.
                continue;
            } else 
            {
                $zipStreamItem->addFileFromPath(fileName:$workingPath . DIRECTORY_SEPARATOR . $currentItem, path:$trueDirName . DIRECTORY_SEPARATOR . $currentItem);        //Add found file to zipStream.
            }
        }
    } 
    if ($dirCount > 0)      //If any folders are found in our folder, list them and call the function again when we hit one.
    {
        foreach (scandir($trueDirName) as $currentItem) 
        {
            if ($dirCount == 0) 
            {
                $zipStreamItem->addDirectory("ERROR"); //Better be safe than sorry.
                break;
            } 
            elseif ($currentItem[0] == '.' | pathinfo($currentItem, PATHINFO_EXTENSION) == "php") { //Skip hidden stuff and PHP code.
                continue;
            } 
            elseif (is_dir($trueDirName . DIRECTORY_SEPARATOR . $currentItem))      //If the currentItem is a directory, list it and call the function again.
            {
                $zipStreamItem->addDirectory($workingPath);
                folderSleuth($trueDirName . DIRECTORY_SEPARATOR . $currentItem, true, $startDirParent, $zipStreamItem);     //Recursively call function for subfolders.
            } 
            else {

                $zipStreamItem->addFileFromPath(fileName:$workingPath . DIRECTORY_SEPARATOR . $currentItem, path:$trueDirName . DIRECTORY_SEPARATOR . $currentItem);    //Second possible place for files to be added to the zipStream.
            }
        }
    }
}

function folderZipStreamer($folderName)
{
    if($folderName == "" | $folderName[0] == "." | $folderName[0] == "/" | is_dir($folderName) == false) //We don't wanna download everything in the server, do we?
    {
        echo "<script>alert('Prompt Is Illegal. Error Name: Fox')</script>";
        return 1;
    }
    else
    {
        $zipTemp = new ZipStream\ZipStream(outputName: "$folderName.zip", sendHttpHeaders: true); //Create zipStream.
        folderSleuth($folderName, false, "", $zipTemp); //Start going through the folder's contents.
        $zipTemp->finish();     //Send ZIP footer. 
    }
}
