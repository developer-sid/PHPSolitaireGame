<?php
/**
 * Created by SiD 
 * Date: 31/01/15
 * Time: 1:16 PM
 */

require_once 'vendor/autoload.php';
require_once '../lib/Card.php';
require_once '../lib/Deck.php';
require_once '../lib/Pile.php';
require_once '../lib/FortyThievesPile.php';
require_once '../lib/Game.php';

class GameTest extends PHPUnit_Framework_TestCase {

    protected $Game;


    protected function setUp()
    {
        $testCards = array(
            '1'     =>  array('1', 'H', 'red'),
            '2'     =>  array('2', 'H', 'red'),
            '3'     =>  array('3', 'H', 'red'),
            '4'     =>  array('1', 'D', 'red'),
            '5'     =>  array('2', 'D', 'red'),
            '6'     =>  array('3', 'D', 'red'),
            '7'     =>  array('1', 'S', 'black'),
            '8'     =>  array('2', 'S', 'black'),
            '9'     =>  array('3', 'S', 'black'),
            '10'    =>  array('1', 'C', 'black'),
            '11'    =>  array('2', 'C', 'black'),
            '12'    =>  array('3', 'C', 'black'),
        );

        $Card = new \lib\Card();
        $Deck = new \lib\Deck;
        $Deck->loadCards($testCards);
        $Pile = new \lib\FortyThievesPile();

        $this->Game = $this->getMockForAbstractClass('\lib\Game', array($Card, $Deck, $Pile));

    }

    public function testIsValidMoveInput(){
        $response = $this->Game->isValidMoveInput('quit');
        $this->assertInternalType('string', $response);
    }

    public function testIsQuitGame(){
        $result = $this->Game->isQuitGame('quit');
        $this->assertInternalType('boolean', $result);
    }

} 