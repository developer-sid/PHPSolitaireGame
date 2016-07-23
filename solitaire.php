<?php
/**
 * Created by SiD 
 * Date: 27/01/15
 * Time: 12:39 AM
 */


require 'lib/Card.php';
require 'lib/Deck.php';
require 'lib/Pile.php';
require 'lib/Game.php';
require 'lib/Player.php';
require 'lib/FortyThievesPile.php';
require 'lib/FortyThieves.php';
require 'lib/SixteensPile.php';
require 'lib/Sixteens.php';
require 'lib/TowersPile.php';
require 'lib/Towers.php';

$Card = new \lib\Card;
$Deck = new \lib\Deck;
$Player = new \lib\Player;

$FortyThievesPile = new \lib\FortyThievesPile;
$FortyThieves = new \lib\FortyThieves($Card, $Deck, $FortyThievesPile);

$SixteensPile = new \lib\SixteensPile;
$Sixteens = new \lib\Sixteens($Card, $Deck, $SixteensPile);

$TowersPile = new \lib\TowersPile;
$Towers = new \lib\Towers($Card, $Deck, $TowersPile);

$games = array(
  'f'   =>  $FortyThieves,
  's'   =>  $Sixteens,
  't'   =>  $Towers
);

$Player->start($games);
exit();