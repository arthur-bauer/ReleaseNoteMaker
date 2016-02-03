# Release notes
## v0.1
**First release**  
2015-12-16  
*Changes from `project start` to `v0.1`:*

* Created empty script
* First running version of the script
* Added a small routine to create release notes for the first version as well.
* Updated version number

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
* Release notes and version number updated

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
* Version number updated

## v0.4
**Fourth release**  
2015-12-17  
*Changes from `v0.3` to `v0.4`:*

* Switched to a more reliable sort function for version-numbers
* Version number updated

## v0.5
**Last development release**  
2015-12-18  
*Changes from `v0.4` to `v0.5`:*

* Added tag message to output
* Small bugfix for tag commit message that messed up the markdown
* New routine to add the commit date to the notes
* Bugfix on the date routine
* Version number updated

## v1.0
**First release**  
2016-01-11  
*Changes from `v0.5` to `v1.0`:*

* Changed grep routine to make it easier to add or remove grep strings
* Added possibility to add parameters
* Version number updated

## v1.1
**Bugfix release**  
2016-01-25  
*Changes from `v1.0` to `v1.1`:*

* If no tags found, get the first commit instead. Closes #1
* Add description about commit filter. Closes #2
* Updated readme and version number

## Current version (not yet released)
2016-02-05  
*Changes from `v1.1` to current version:*

* Updated documentation
