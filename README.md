Description
===============

ReleaseNoteMaker: A PHP script to generate a complete Release Note list from your repository, starting from the first commit. It summarises the commits for each version number (defined by tags starting with a "v"). 

## Usage
 
    cd <path/to/repo>
    <path to ReleaseNotemaker.php> > ReleaseNotes.md

You probably want to clean up unnecessary or double commits in the final list.

The release notes at the end of this document are created with the script.

Contact
===============
arthurbauer@mac.com

Bugs
===============

Features
===============
### `F001`: Rename first and last commit in output `FIXED`
Rename first and last commit in output: Give them better names than a commit number and `HEAD`

> FIXED

### `F002`: Add date to release note `FIXED`
Add date to release note: The date of the commit with the version number should be added.

> FIXED

# Release notes
## v0.1
**First release**  
2015-12-16  
*Changes from `project start` to `v0.1`:*

* Created empty script
* First running version of the script
* Added a small routine to create release notes for the first version as well.

## v0.2
**Second release**  
2015-12-16  
*Changes from `v0.1` to `v0.2`:*

* Updated the Markdown output a bit
* Bugfix: Added output for latest changes again
* F001: Rename first and last commit in output - FIXED
* Added header and changed access rights to make the script executable
* Adjusted Markdown output
* Removed path to project from Release notes header
* Improved markdown for subline

## v0.3
**Third release**  
2015-12-17  
*Changes from `v0.2` to `v0.3`:*

* Added a "--reverse"  to bring commits in a more logical order
* Adjusted some comments in the source code
* Improved output for latest, not yet released changes
* Only creates output if there is actually anything new since the last version tag
* Bugfix: Last entry was repeated under certain circumstances
* Cleaner sorting of versions

## v0.4
**Fourth release**  
2015-12-17  
*Changes from `v0.3` to `v0.4`:*

* Switched to a more reliable sort function for version-numbers

## v0.5
**Last development release**  
2015-12-18  
*Changes from `v0.4` to `v0.5`:*

* Added tag message to output
* Small bugfix for tag commit message that messed up the markdown
* New routine to add the commit date to the notes
* Bugfix on the date routine
