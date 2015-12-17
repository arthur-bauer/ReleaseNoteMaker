#!/usr/bin/php
<?php

// v0.2, 2015-12-16

$tags=`git tag | grep ^v | sort `; // get all the tags that start with a "v"

$tags=explode("\n",$tags);

$counter=count($tags)-2;

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
if ($tags[$j]!="HEAD") 
{
$log= "\n## $tags[$j]\n";
$log.= "*Changes from `$tags[$i]` to `$tags[$j]`:*\n\n";
}
else 
{
$log= "\n## Current version (not yet released)\n";
$log.= "*Changes from `$tags[$i]` to current version:*\n\n";
}
// This command creates the actual release note, greps out commits that contain "(minor)", "Todo" and "Version number"/"Versionsnummer"
// Feel free to add more greps if needed 
$com="git log --reverse --no-merges --pretty=format:\"* %s\" ".$tags[$i]."..".$tags[$j]." | grep -v \(minor\) | grep -vi \"Todo\" | grep -vi \"Version number\" | grep -vi \"Versionsnummer\" ";
$log.= `$com`;

// replace "HEAD" and the first commit hash with a more human-readable text. 
$log=str_replace("HEAD","current version",$log);
$log=str_replace($commit1[0],"project start",$log);

echo $log;
}
?>