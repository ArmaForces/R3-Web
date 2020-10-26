<?php

require_once('inc/bootstrap.php');
$replays = Replays::Instance();
$view = View::Instance();
$util = Util::Instance();

if(!isset($_GET['replayId']))
    $util->redirect301(WEB_PATH);

// Get info about our mission
$replayDetails = $replays->fetchOne($_GET['replayId'], isset($_GET['force']));

if(!$replayDetails)
    $util->redirect301(WEB_PATH . '?not-found');

// We do want people seeing where units are in a mission while it's still in play
if(!$replayDetails->minutesSinceLastEvent || $replayDetails->minutesSinceLastEvent < MINUTES_MISSION_END_BLOCK)
    $util->redirect301(WEB_PATH . '?not-finished');

$title = $replayDetails->missionName;
$metaDescription = 'Watch the interactive mission playback for ' . $replayDetails->missionName . ' (' . $util->humanTimeDifference(strtotime($replayDetails->lastEventMissionTime), strtotime($replayDetails->dateStarted)) . ')';
$headerTitle = UNIT_NAME;
$metaImage = WEB_PATH . '/maps/' . strtolower($replayDetails->map) . '/tiles/0/0/0.png';
$page = 'playback';

$url = TILES_PATH . '/config.json';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$mappingConfig = curl_exec($ch);
curl_close($ch);

$playerList = $replays->fetchReplayPlayers($_GET['replayId'], $replayDetails->playerList);

$sharedPresets = $_GET;

$icons = $replays->getIcons();
$objectiveMarkersConfig = $replays->getObjectiveMarkers();

// Do we have a cached version of this playback?
$cacheAvailable = $replays->isCachedVersionAvailable($replayDetails->id);

require_once(APP_PATH . '/views/templates/header.php');
require_once(APP_PATH . '/views/' . $page . '.php');
require_once(APP_PATH . '/views/templates/footer.php');
