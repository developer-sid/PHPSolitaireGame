<?php
/**
 * Created by SiD 
 * Date: 31/01/15
 * Time: 11:20 AM
 */

require_once 'vendor/autoload.php';
require_once '../lib/Card.php';

class CardTest extends PHPUnit_Framework_TestCase {

    protected $Card;

    protected function setUp()
    {
        $this->Card = new \lib\Card();
    }

    public function testGetAllSuitCards(){
        $allCards = $this->Card->getAllSuitCards();
        $this->assertInternalType('array', $allCards);
        $this->assertEquals(52, count($allCards));
    }

    public function testToString(){
        $cardString = $this->Card->toString(array(
            '8'    =>   array('1', 'H', 'red')
        ));
        $this->assertInternalType('string', $cardString);
        $this->assertEquals($cardString, '1H');
    }
} 