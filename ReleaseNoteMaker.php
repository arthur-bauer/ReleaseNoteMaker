<?php

// v0.1, 2015-12-16

$tags=`git tag | grep ^v | sort `; // get all the tags that start with a "v"
$tags=explode("\n",$tags);

$counter=count($tags)-2;

$tags[$counter+1]="HEAD"; // and the current HEAD as last "version"

//start output
echo "## Release notes for ";
echo `pwd`;

// Get the first commit and add it at the beginning of the list, so we also get the first commit messages
$commit1=`git log --oneline | tail -n 1`;
$commit1=explode(" ",$commit1);
array_unshift($tags,$commit1[0]);

// loop through all the tags and create an output for that version
for ($i=0;$i<=$counter+1;$i++)
{
$j=$i+1;
echo "\n### $tags[$j]\n";
echo "*Changes from $tags[$i] - $tags[$j]*\n\n";

// This command creates the actual release note, greps out commits that contain "(minor)" and "Todo"
// Feel free to add more greps if needed (e.g. for "version number update" etc)
$com="git log --no-merges --pretty=format:\"* %s\" ".$tags[$i]."..".$tags[$j]." | grep -v \(minor\) | grep -vi \"Todo\"";
echo `$com`;
}



?>