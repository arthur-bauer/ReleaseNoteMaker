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

### Version number proposal
If there are commits that are not yet part of a release, the script will show them at the end of the log. It will also try to estimate the upcoming version number:

- Commits with `(minor)` will be excluded from calculation
- Commits with `(!)` will be considered commits that **break compatibility**. This will always create a **major** release version number (e.g. `v5.0`).
- Commits with `(+)` will be considered commits that **add a major new feature**. This will always create a **minor** release version number (e.g. `v5.1`). Its commit text will be proposed as tag annotation.
- More than 10 normal commits will also create a **minor** release version number (e.g. `v5.1`). The proposal for the tag annotation will be `Maintenance release`. 
- Everything else (no (!) or (+) in the commit message, less than 10 commits) will be considered a bug fix release version number (e.g. `v5.1.1`). The proposal for the tag annotation will be `Small bugfix release`.

### Good practices

* Create a version tag starting with `v`, e.g. `v1.3.4`
* Add a short summary in the tag message, e.g. `Bugfix release. Fixes B002 and B003`
* Use the filter function to hide commits. E.g. use `(minor)` in the commit message when you just fixed a typo, or if you cleaned up the code etc.
* Adjust the filters according to your workflow and preferences 

Contact
===============
arthurbauer@mac.com