Description
===============

ReleaseNoteMaker: A PHP script to generate a complete Release Note list

## Usage
 
    cd <path/to/repo>
    php <path to ReleaseNotemaker.php> > ReleaseNotes.md

You probably want to clean up unnecessary commits in the final list.

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

* Added a small routine to create release notes for the first version as well.
* First running version of the script
* Created empty script

## v0.2
*Changes from `v0.1` to `v0.2`:*

* Improved markdown for subline
* Removed path to project from Release notes header
* Adjusted Markdown output
* Added header and changed access rights to make the script executable
* F001: Rename first and last commit in output - FIXED
* Bugfix: Added output for latest changes again


