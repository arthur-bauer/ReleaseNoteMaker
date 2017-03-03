#!/usr/bin/php
<?php
// v1.2.1 2016-03-09

/* CONFIG AREA */

$greppers=array("\(minor\)", "Todo aktualisiert","(-)","(-m)","Add build"); // all these strings are filtered out
$tagmajor="(!)"; // this string creates a major release
$tagminor="(+)"; // this string creates a minor release

/* END CONFIG AREA */

date_default_timezone_set("Europe/Berlin");

$cv=$argv;

if (is_numeric($cv[1]))
{
	$cv[3] = $cv[1];
	$cv[1]="";
}

$tags=trim(`git tag -l "v*" `); // get all the tags that start with a "v"

$tags=explode("\n", $tags);

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

//! Get the first commit and add it at the beginning of the list, so we also get the first commit messages
$commit1=`git log --oneline | tail -n 1`;
$commit1=explode(" ", $commit1);
array_unshift($tags, $commit1[0]);

if ($notags)
{
	$tags[0]=trim(`git log --reverse  --oneline | head -n 1 | awk '{print $1}'`);
	$tags[1]="HEAD";
	$firstcom=$tags[0];
}

//! loop through all the tags and create an output for that version
for ($i=0;$i<=$counter+1;$i++)
{
	$j=$i+1;

	//! This command creates the actual release note, greps out commits that contain "(minor)", "Todo" and "Version number"/"Versionsnummer"
	// Feel free to add more greps if needed

	$grepstring="";

	foreach ($greppers as $grep1) $grepstring.=" | grep -v '$grep1'";

	$com="git log --reverse --no-merges --pretty=format:\"* %s\" ".$tags[$i]."..".$tags[$j]."  ".$grepstring;

	if ($tags[$j]!="HEAD")
	{
		$log= "\n## $tags[$j]\n";

		//! let's get the tag message here and add it to the output
		$tagmessage=`git show $tags[$j]`;
		$tagmessage=explode("\n", $tagmessage);
		if ($tagmessage[4]) $log.="**".trim($tagmessage[4])."**  ";

		//! let's get the commit date here and add it to the output
		$tagtime=`git log --pretty=tformat:%at $tags[$j] | head -n 1`;
		if ($tagtime) $log.="\n".date("Y-m-d", $tagtime)."  \n";



		$log.= "*Changes from `$tags[$i]` to `$tags[$j]`:*\n\n";
		$log.= join("\n",array_unique(explode("\n",`$com`)));
	}
	else
	{
		//! let's check if there is anything new anyway
		$check=`$com`;
		if ($check!==NULL)
		{
			if (!$cv[1])
			{
				//! here we have a closer look at the new stuff to find out what kind of version number we get.
				$closelook=explode("\n",trim($check));
				$closelookcount=count($closelook);
				$major=$minor=$bugfix=false;
				foreach ($closelook as $closelookline)
				{
				if (strpos($closelookline, $tagmajor))
				{
					$major=true;
					$annot[]=trim(str_replace("* ","",trim(str_replace($tagmajor,"",$closelookline))));
				}
				if (strpos($closelookline, $tagminor)) 
				{
					$minor=true;
					$annot[]=trim(str_replace("* ","",trim(str_replace($tagminor,"",$closelookline))));
				
				}
				}
		
				$oldvn=explode(".",str_replace("v","",$tags[$i]));
				if ($major) 
				{
					$newvn=($oldvn[0]+1).".0";
					if (!$annot) $annot[]="Major release";
				}
				else if ($minor or $closelookcount>10) {
					$newvn=$oldvn[0].".".($oldvn[1]+1);
					if (!$annot) $annot[]="Maintenance release";
					//else $annot[]="feature release";
				}
				else 
				{
					$newvn=$oldvn[0].".".$oldvn[1].".".($oldvn[2]+1);
					$annot[]="Small bugfix release";
}
				$log= "\n## Upcoming version v$newvn *(not yet released)*  \n";
				if ($annot) $log.="**New:** ".join(", ",$annot)."  \n";
				$log.=date("Y-m-d")."  \n";
				$log.= "*Changes from `$tags[$i]` to current version:*\n\n";
			}
			else
			{
				$log= "\n## $cv[1]".($cv[2]?"\n**$cv[2]**  ":"");
				$log.="\n".date("Y-m-d")."  \n";
				$log.= "*Changes from `$tags[$i]` to `$cv[1]`:*\n\n";
			}
			$log.= join("\n",array_unique(explode("\n",`$com`)));
		}
	}


	//! replace "HEAD" and the first commit hash with a more human-readable text.
	$log=str_replace("HEAD", "current version", $log);
	$log=str_replace($commit1[0], "project start", $log);
	$log=str_replace("vproject start..1", "v0.1", $log);
	$log=str_replace("vproject start.1", "v0.1", $log);

	echo $log;
	$log="";


}
// get revision number per file
if ($cv[3])
{
echo "\n# Revision list\nFilename | Revision\n----|------:\n";
$alltrackedfiles= explode("\n",`git ls-tree -r HEAD --name-only`);
foreach ($alltrackedfiles as $mytrackedfile)
{
$log2=trim(`git log --follow --oneline -- "$mytrackedfile" | wc -l`);
if ($log2>$cv[3] and $mytrackedfile) echo "$mytrackedfile | $log2\n";
}
}

?>