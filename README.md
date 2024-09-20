# PCR GUI Inserts

Die Pflege dieses Forks der MediaWiki-Erweiterung [PCR GUI Inserts](https://www.mediawiki.org/wiki/Extension:PCR_GUI_Inserts) wird von WikiMANNia verwaltet.

The maintenance of this fork of the MediaWiki extension [PCR GUI Inserts](https://www.mediawiki.org/wiki/Extension:PCR_GUI_Inserts) is managed by WikiMANNia.

El mantenimiento de esta bifurcación de la extensión de MediaWiki [PCR GUI Inserts](https://www.mediawiki.org/wiki/Extension:PCR_GUI_Inserts) está gestionado por WikiMANNia.


## Purpose

The PCR GUI Inserts extension lets you easily add pieces of HTML code at several useful places of the GUI.


## Compatibility

* PHP 5.6+
* MediaWiki 1.35+

See also the CHANGELOG.md file provided with the code.


## Installation

(1) Obtain the code from [GitHub](https://github.com/WikiMANNia/mediawiki-extensions-PCRGUIInserts/releases)

(2) Extract the files in a directory called `PCRGUIInserts` in your `extensions/` folder.

(3) Add the following code at the bottom of your "LocalSettings.php" file:
```
wfLoadExtension( 'PCRGUIInserts' );
```
(4) Configure this extension as needed for your wiki. See the [documentation](https://www.mediawiki.org/wiki/Extension:PCR_GUI_Inserts#Configuration).

(5) Go to "Special:Version" on your wiki to verify that the extension is successfully installed.

(6) Done.
