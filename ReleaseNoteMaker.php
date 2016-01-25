#!/usr/bin/php
<?php
date_default_timezone_set("Europe/Berlin");
// v1.1 2016-01-25

$cv=$argv;

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

if (!$tags[0]) $notags=true;

$counter=count($tags)-1;

$tags[$counter+1]="HEAD"; // and the current HEAD as last "version"

//start output
echo "# Release notes";
//echo `pwd`;

// Get the first commit and add it at the beginning of the list, so we also get the first commit messages
$commit1=`git log --oneline | tail -n 1`;
$commit1=explode(" ",$commit1);
array_unshift($tags,$commit1[0]);

if ($notags) 
{
$tags[0]=trim(`git log --reverse  --oneline | head -n 1 | awk '{print $1}'`);
$tags[1]="HEAD";
$firstcom=$tags[0];
}

// loop through all the tags and create an output for that version
for ($i=0;$i<=$counter+1;$i++)
{
$j=$i+1;

// This command creates the actual release note, greps out commits that contain "(minor)", "Todo" and "Version number"/"Versionsnummer"
// Feel free to add more greps if needed 

$grepstring="";
$greppers=array("\(minor\)","Todo aktualisiert");//,"Version[s| ]num[m|b]er");

foreach ($greppers as $grep1) $grepstring.=" | grep -vi '$grep1'";

$com="git log --reverse --no-merges --pretty=format:\"* %s\" ".$tags[$i]."..".$tags[$j]."  ".$grepstring;

if ($tags[$j]!="HEAD") 
{
$log= "\n## $tags[$j]\n";

// let's get the tag message here and add it to the output
$tagmessage=`git show $tags[$j]`;
$tagmessage=explode("\n",$tagmessage);
if ($tagmessage[4]) $log.="**".trim($tagmessage[4])."**  ";

// let's get the commit date here and add it to the output
$tagtime=`git log --pretty=tformat:%at $tags[$j] | head -n 1`;
if ($tagtime) $log.="\n".date("Y-m-d",$tagtime)."  \n";



$log.= "*Changes from `$tags[$i]` to `$tags[$j]`:*\n\n";
$log.= `$com`;
}
else 
{
// let's check if there is anything new anyway
$check=`$com`;
if ($check!==NULL)
{
if (!$cv[1])
{
$log= "\n## Current version (not yet released)\n";
$log.=date("Y-m-d")."  \n";
$log.= "*Changes from `$tags[$i]` to current version:*\n\n";
}
else
{
$log= "\n## $cv[1]".($cv[2]?"\n**$cv[2]**  ":"");
$log.="\n".date("Y-m-d")."  \n";
$log.= "*Changes from `$tags[$i]` to `$cv[1]`:*\n\n";
}
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