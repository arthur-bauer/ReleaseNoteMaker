#!/usr/bin/php
<?php

// v0.4, 2015-12-17

$tags=trim(`git tag -l "v*" `); // get all the tags that start with a "v"

$tags=explode("\n",$tags);

// a short routine to sort prerelease versions (with different type of suffixes) before their full version
// it is important that one follows the semantic versioning principle closely:
//
//  vx.z.y-prerelease OR vx.z.y_prerelease
// 
// dash and underscore should not be mixed
//

usort($tags, 'version_compare');


$counter=count($tags)-1;

$tags[$counter+1]="HEAD"; // and the current HEAD as last "version"

//start output
echo "# Release notes";
//echo `pwd`;

// Get the first commit and add it at the beginning of the list, so we also get the first commit messages
$commit1=`git log --oneline | tail -n 1`;
$commit1=explode(" ",$commit1);
array_unshift($tags,$commit1[0]);

// loop through all the tags and create an output for that version
for ($i=0;$i<=$counter+1;$i++)
{
$j=$i+1;

// This command creates the actual release note, greps out commits that contain "(minor)", "Todo" and "Version number"/"Versionsnummer"
// Feel free to add more greps if needed 
$com="git log --reverse --no-merges --pretty=format:\"* %s\" ".$tags[$i]."..".$tags[$j]." | grep -v \(minor\) | grep -vi \"Todo\" | grep -vi \"Version number\" | grep -vi \"Versionsnummer\" ";

if ($tags[$j]!="HEAD") 
{
$log= "\n## $tags[$j]\n";

// let's get the tag message here and add it to the output
$tagmessage=`git show $tags[$j]`;
$tagmessage=explode("\n",$tagmessage);
if ($tagmessage[4]) $log.="**".trim($tagmessage[4])."**  \n";

$log.= "*Changes from `$tags[$i]` to `$tags[$j]`:*\n\n";
$log.= `$com`;
}
else 
{
// let's check if there is anything new anyway
$check=`$com`;
if ($check!==NULL)
{
$log= "\n## Current version (not yet released)\n";
$log.= "*Changes from `$tags[$i]` to current version:*\n\n";
$log.= `$com`;
}
}


// replace "HEAD" and the first commit hash with a more human-readable text. 
$log=str_replace("HEAD","current version",$log);
$log=str_replace($commit1[0],"project start",$log);

echo $log;
$log="";
}
?>