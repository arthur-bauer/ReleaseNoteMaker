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

# Release notes
## v0.1
*Changes from `project start` to `v0.1`:*

* Created empty script
* First running version of the script
* Added a small routine to create release notes for the first version as well.

## v0.2
*Changes from `v0.1` to `v0.2`:*

* Bugfix: Added output for latest changes again
* F001: Rename first and last commit in output - FIXED
* Added header and changed access rights to make the script executable
* Adjusted Markdown output
* Removed path to project from Release notes header

## current version
*Changes from `v0.2` to `current version`:*

* Added a "--reverse"  to bring commits in a more logical order
* Adjusted some comments in the source code
