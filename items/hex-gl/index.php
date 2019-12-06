<?php
define('block_edutrader_item', 'hex-gl');
require('../launch.php');
?><!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>HexGL by BKcore</title>
    <meta charset="utf-8">
    <meta name="description" content="HexGL is a futuristic racing game built by Thibaut Despoulain (BKcore) using HTML5, Javascript and WebGL. Come challenge your friends on this fast-paced 3D game!">
    <meta property="og:title" content="HexGL, the HTML5 futuristic racing game.">
    <meta property="og:type" content="game">
    <meta property="og:url" content="http://hexgl.bkcore.com/">
    <meta property="og:image" content="http://hexgl.bkcore.com/image.png">
    <meta property="og:site_name" content="HexGL by BKcore">
    <meta property="fb:admins" content="1482017639">
    <link rel="icon" href="http://hexgl.bkcore.com/favicon.png" type="image/png">
    <link rel="shortcut icon" href="http://hexgl.bkcore.com/favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="src/multi.css" type="text/css" charset="utf-8">
    <link rel="stylesheet" href="src/fonts.css" type="text/css" charset="utf-8">
    <style>
      body {
        padding:0;
        margin:0;
      }
      canvas { pointer-events:none; width: 100%;}
      #overlay{
        position: absolute;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
      }
    </style>
    <script type="text/javascript" async="" src="src/ga.js"></script><script type="text/javascript">
    //analytics
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-26274524-4']);
    _gaq.push(['_trackPageview']);
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
    </script>
  </head>

  <body cz-shortcut-listen="true">
    <div id="step-1">
      <div id="global"></div>
      <div id="title">
      </div>
      <div id="menucontainer">
        <div id="menu">
          <div id="start">Start</div>
          <div id="s-controlType">Controls: KEYBOARD</div>
          <div id="s-quality">Quality: HIGH</div>
          <div id="s-platform">Platform: DESKTOP</div>
          <div id="s-godmode">Godmode: OFF</div>
        </div>
      </div>
    </div>
    <div id="step-2" style="display: none">
      <div id="ctrl-help">Click/Touch to continue.</div>
    </div>
    <div id="step-3" style="display: none">
      <div id="progressbar"></div>
    </div>
    <div id="step-4" style="display: none">
      <div id="overlay"></div>
      <div id="main"></div>
    </div>
    <div id="step-5" style="display: none">
      <div id="time"></div>
      <div id="ctrl-help">Click/Touch to continue.</div>
    </div>

    <div id="leapinfo" style="display: none"></div>

    <script src="src/leap-0.js"></script>
    <script src="src/Three.js"></script>
    <script src="src/ShaderExtras.js"></script>
    <script src="src/EffectComposer.js"></script>
    <script src="src/RenderPass.js"></script>
    <script src="src/BloomPass.js"></script>
    <script src="src/ShaderPass.js"></script>
    <script src="src/MaskPass.js"></script>
    <script src="src/Detector.js"></script>
    <script src="src/Stats.js"></script>
    <script src="src/DAT.js"></script>

    <script src="src/TouchController.js"></script>
    <script src="src/OrientationController.js"></script>
    <script src="src/GamepadController.js"></script>

    <script src="src/Timer.js"></script>
    <script src="src/ImageData.js"></script>
    <script src="src/Utils.js"></script>

    <script src="src/RenderManager.js"></script>
    <script src="src/Shaders.js"></script>
    <script src="src/Particles.js"></script>
    <script src="src/Loader.js"></script>

    <script src="src/HUD.js"></script>
    <script src="src/RaceData.js"></script>
    <script src="src/ShipControls.js"></script>
    <script src="src/ShipEffects.js"></script>
    <script src="src/CameraChase.js"></script>
    <script src="src/Gameplay.js"></script>

    <script src="src/Cityscape.js"></script>

    <script src="src/HexGL.js"></script>

    <script src="src/launch.js"></script>



</body></html>
