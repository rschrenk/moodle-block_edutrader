# moodle-block_trader
This is a gamification-plugin that builds upon the moodle block_xp-Plugin. EXP from block_xp are used as currency (called "Funnies | FNS") and can be traded against playing time in small games.


## Add any game
Any HTML5-Game can be added to this plugin, just by creating a small moodle-plugin. Please use our 1024-moves-Game as template: https://github.com/rschrenk/moodle-local_edutrader1024moves

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

### Modify db/install.php

Enter the details and settings for your game and rename the classname to match your game-name.

### Modify db/uninstall.php

Edit db/uninstall.php and enter the game-identifier of your game, so that it can be removed from the list of games if it is removed.

### Place the game contents

Place the game-contents in the subdirectory "item". Rename the index.html to index.php. The first lines in index.php should be
```
<?php
require_once('../../../config.php');
define('block_edutrader_item', 'gameidentifier');
require($CFG->dirroot . '/blocks/edutrader/launch.php');
?>
```
### Place an image

Place a screenshot in the pix folder that is called cover.png.
