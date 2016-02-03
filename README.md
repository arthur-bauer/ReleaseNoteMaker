Description
===============

**ReleaseNoteMaker:** A PHP script to generate a complete Release Note list from your repository, starting from the first commit. It summarises the commits for each version number (defined by tags starting with a "v"). 

## Usage
 
    cd <path/to/repo>
    <path to ReleaseNotemaker.php> > ReleaseNotes.md

or, if you have commits that are not part of the latest tagged version, you can also pass on two arguments

    cd <path/to/repo>
    <path to ReleaseNotemaker.php> > ReleaseNotes.md <versionsnummer> <shortdescription>


You probably want to clean up unnecessary or double commits in the final list.

The [CHANGELOG](CHANGELOG.md) of this project is created with the script.

### Filtering
The script contains a simple routine to filter out some commits. Per default, the following commits are **not** part of the release notes:

* Commits that contain `(minor)`
* Commits that contain `Todo aktualisiert`

This can be changed in the script. You can add, delete or edit filters here:

```
$greppers=array("\(minor\)","Todo aktualisiert");
```

### Good practices

* Create a version tag starting with `v`, e.g. `v1.3.4`
* Add a short summary in the tag message, e.g. `Bugfix release. Fixes B002 and B003`
* Use the filter function to hide commits. E.g. use `(minor)` in the commit message when you just fixed a typo, or if you cleaned up the code etc.
* Adjust the filters according to your workflow and preferences 

Contact
===============
arthurbauer@mac.com