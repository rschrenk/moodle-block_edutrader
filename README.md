# moodle-block_trader
This is a gamification-plugin that builds upon the moodle block_xp-Plugin. EXP from block_xp are used as currency (called "Funnies | FNS") and can be traded against playing time in small games.

## Installation

Basically you have to install this plugin as the core, but this plugin itself does not contain any games. Games have to be installed separately as local plugins. Besides this block, three such local plugins have been published:
1. [local_edutrader1024moves](https://github.com/rschrenk/moodle-local_edutrader1024moves)
2. [local_edutraderhexgl](https://github.com/rschrenk/moodle-local_edutraderhexgl)
3. [local_edutradersuperchronoportalmaker](https://github.com/rschrenk/moodle-local_edutradersuperchronoportalmaker)

After you have installed all 4 plugins, you can toggle the available site wide of certain games.

![Website settings](/doc/edutrader-sitesettings.png)

## Usage

Teachers will have to use this plugin together with the "Level Up!"-Block, so that their students can gain levels. Once they added the edutrader-Block to the course, they can toggle availability of certain games on course level.

![Course settings](/doc/edutrader-coursesettings.png)

Once students gained enough experience from the "Level Up!"-Plugin, the button "Go and have som fun!" will apear in the edutrader-Block.

![Edutrader block](/doc/edutrader-block.png)

On the following page all available games are shown and the student can open the details page.

![Choose a game](/doc/edutrader-launch-choose.png)
![Launch a session](/doc/edutrader-launch-session.png)

If for any reason the browser is closed or students navigate away, the session will still be open for that amount of time.

![Re-enter session](/doc/edutrader-session-open.png)

## Add new games

Basically any HTML5-Game or other activity can be added to this plugin, just by creating a local moodle-plugin. Please use our 1024-moves-Game as template: https://github.com/rschrenk/moodle-local_edutrader1024moves

You only need to do the following changes to this template plugin:

### Choose gameitem-identifier

You need to use a unique identifier for your game, that should not contain whitespaces or special chars. For example out of "1024 moves" we made "1024moves". Note that name, it is referred to as "*gameidentifier*".

### fork it

Fork this GitHub-Repository. Choose as name for your repository
> moodle-block_edutrader*gameidentifier*

### Modify version.php

Enter the gameidentifier in the line
```
$plugin->component = 'local_edutrader1024moves';
```
### Modify lang/en/local_edutrader1024moves.php

Rename the file to lang/en/localedutrader*gameidentifier*.php

### Modify db/install.php

Enter the details and settings for your game and rename the classname to match your game-name.

### Modify db/uninstall.php

Edit db/uninstall.php and enter the game-identifier of your game, so that it can be removed from the list of games if it is removed.

### Place the game contents

Place the game-contents in the subdirectory "item". Rename the index.html to index.php. The first lines in index.php should be
```
<?php
require_once('../../../config.php');
define('block_edutrader_item', '*gameidentifier*');
require($CFG->dirroot . '/blocks/edutrader/launch.php');
?>
```
### Place an image

Place a screenshot in the pix folder that is called cover.png.

### Code styling

You will make the moodle developers happy (and you should do that!), if you also update the data in the comments on the top of each php-Script. Please enter your name, the new plugin name and copyright notice in each of the following files:

* classes/privacy/provider.php
* db/install.php
* db/uninstall.php
* item/index.SuperChronoPortalMaker
* lang/en/local_edutrader*gameidentifier*.php
* version.php
