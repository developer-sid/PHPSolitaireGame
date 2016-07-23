<?php
/**
 * Created by SiD 
 * Date: 31/01/15
 * Time: 12:50 PM
 */

require_once 'vendor/autoload.php';
require_once '../lib/Deck.php';

class DeckTest  extends PHPUnit_Framework_TestCase {

    protected $Deck;
    protected $testCards = array(
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

    protected function setUp()
    {
        $this->Deck = new \lib\Deck;
    }

    public function testLoadCards(){
        $this->Deck->loadCards($this->testCards);
        $this->assertInternalType('array', $this->Deck->cards);
        $this->assertEquals(12, count($this->Deck->cards));
    }

    public function testShuffleCards(){
        $this->Deck->loadCards($this->testCards);
        $cardsBeforeShuffle = $this->Deck->cards;
        $this->Deck->ShuffleCards();
        $this->assertInternalType('array', $this->Deck->cards);
        $this->assertEquals(12, count($this->Deck->cards));
        $this->assertNotSame($this->Deck->cards, $cardsBeforeShuffle);
    }

    public function testGetCards(){
        $this->Deck->loadCards($this->testCards);
        $toCards = $this->Deck->getCards(2);
        $this->assertInternalType('array', $toCards);
        $this->assertEquals(2, count($toCards));
        $this->assertEquals(10, count($this->Deck->cards));
    }


} 