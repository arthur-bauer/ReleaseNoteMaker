Description
===============

**ReleaseNoteMaker:** A PHP script to generate a complete Release Note list from your repository, starting from the first commit. It summarises the commits for each version number (defined by tags starting with a "v"). 

## Usage
 
    cd <path/to/repo>
    <path to ReleaseNotemaker.php> > ReleaseNotes.md

or, if you have commits that are not part of the latest tagged version, you can also pass on two arguments. If you don't provide at least the version number, then the script will try to estimate the upcoming version number – see below.

    cd <path/to/repo>
    <path to ReleaseNotemaker.php> > ReleaseNotes.md <versionsnummer> <shortdescription>


You probably want to clean up unnecessary or double commits in the final list.

The [CHANGELOG](CHANGELOG.md) of this project is created with the script.

### Filtering
The script contains a simple routine to filter out some commits. Per default, the following commits are **not** part of the release notes:

* Commits that contain `(minor)`
* Commits that contain `Todo aktualisiert`
* Commits that contain `(-)`

This can be changed in the script. You can add, delete or edit filters here:

```
$greppers=array("\(minor\)","Todo aktualisiert");
```

### Version number proposal
If there are commits that are not yet part of a release, the script will show them at the end of the log. It will also try to estimate the upcoming version number based on the number of commits and their commit messages:

- Commits with `(minor)` or other filtered strings in the commit message will be excluded from calculation (see above, *Filtering*).
- Commits with `(!)` in their message will be considered commits that **break compatibility**. This will always create a **major** release version number (e.g. from `v4.2.1` to `v5.0`).
- Commits with `(+)` will be considered commits that **add an important new feature**. This will always create a **minor** release version number (e.g. from `v5.0.2` to `v5.1`). Its commit text will be proposed as tag annotation.
- More than 10 normal commits will also create a **minor** release version number (e.g. from `v5.0.2` to `v5.1`). The proposal for the tag annotation will be `Maintenance release`. 
- Everything else (no (!) or (+) in the commit message, less than 10 commits) will be considered a bug fix release version number (e.g. from `v5.1` to `v5.1.1`). The proposal for the tag annotation will be `Small bugfix release`.

### Good practices

* Create a version tag starting with `v`, e.g. `v1.3.4`
* Add a short summary in the tag message, e.g. `Improved routine to calculate the entries properly. Fixes #2 and #3`
* Add `(!)` in the commit message when your commit introduces a major change in the functionality that would break compatibility or changes the way the user would work with the software. E.g. if you change the database format or the way you store information in a file. This will automatically lead to a *major release*.
* Add a `(+)` to your commit message if you introduce a new function. This will automatically lead to a *minor release*.
* Use the filter function to hide commits from the logfile. E.g. use `(minor)` in the commit message when you just fixed a typo, or if you cleaned up the code etc.
* Adjust the filters according to your workflow and preferences 

Contact
===============
arthurbauer@mac.com