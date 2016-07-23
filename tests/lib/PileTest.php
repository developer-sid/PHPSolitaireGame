<?php
/**
 * Created by SiD 
 * Date: 31/01/15
 * Time: 3:44 PM
 */

require_once 'vendor/autoload.php';
require_once '../lib/Pile.php';
require_once '../lib/Card.php';

class PileTest extends PHPUnit_Framework_TestCase {

    protected $Pile;

    protected function setUp(){
        $this->Pile = $this->getMockForAbstractClass('\lib\Pile');
    }

    public function testCreate(){
        $response = $this->Pile->create(array(
            'type'              =>  'fdn',
            'title'             =>  'Foundation',
            'maximumCards'      =>  13,
            'baseCardRule'      =>  'strict',
            'sortOrder'         =>  'asc',
            'sameSuit'          =>  1,
            'cardDisplay'       =>  'top'
        ));

        $this->assertInternalType('array', $response);
        $this->assertNotEmpty($response);
    }

    public function testGetPileString(){
        $testPile = $this->Pile->create(array(
            'type'              =>  'fdn',
            'title'             =>  'Foundation',
            'maximumCards'      =>  13,
            'baseCardRule'      =>  'strict',
            'sortOrder'         =>  'asc',
            'sameSuit'          =>  1,
            'cardDisplay'       =>  'top'
        ));

        $Card = new \lib\Card();
        $response = $this->Pile->getPileString(1, $testPile, $Card);
        $this->assertInternalType('string', $response);
    }

    public function testGetTopCard(){

        $class = new ReflectionClass($this->Pile);
        $method = $class->getMethod('getTopCard');
        $method->setAccessible(true);

        $topCard = $method->invokeArgs($this->Pile, array(
            array(
                '45'    =>  array('8', 'H', 'red'),
                '10'    =>  array('5', 'S', 'black'),
                '23'    =>  array('1', 'H', 'red'),
                '36'    =>  array('4', 'S', 'black'),
            )
        ));

        $this->assertInternalType('array', $topCard);
        $arrKeys = array_keys($topCard);
        $this->assertEquals($topCard[45][0], '8');
    }

    public function testGetBaseCard(){

        $class = new ReflectionClass($this->Pile);
        $method = $class->getMethod('getBaseCard');
        $method->setAccessible(true);

        $topCard = $method->invokeArgs($this->Pile, array(
            array(
                '45'    =>  array('8', 'H', 'red'),
                '10'    =>  array('5', 'S', 'black'),
                '23'    =>  array('1', 'H', 'red'),
                '36'    =>  array('4', 'S', 'black'),
            )
        ));

        $this->assertInternalType('array', $topCard);
        $arrKeys = array_keys($topCard);
        $this->assertEquals($topCard[36][0], '4');
    }

    public function testGetTopCardSuit(){

        $class = new ReflectionClass($this->Pile);
        $method = $class->getMethod('getTopCardSuit');
        $method->setAccessible(true);

        $suit = $method->invokeArgs($this->Pile, array(
            array(
                '45'    =>  array('8', 'H', 'red'),
                '10'    =>  array('5', 'S', 'black'),
                '23'    =>  array('1', 'H', 'red'),
                '36'    =>  array('4', 'S', 'black'),
            )
        ));

        $this->assertInternalType('string', $suit);
        $this->assertEquals($suit, 'H');
    }

    public function testGetTopCardColor(){

        $class = new ReflectionClass($this->Pile);
        $method = $class->getMethod('getTopCardColor');
        $method->setAccessible(true);

        $suit = $method->invokeArgs($this->Pile, array(
            array(
                '45'    =>  array('8', 'H', 'red'),
                '10'    =>  array('5', 'S', 'black'),
                '23'    =>  array('1', 'H', 'red'),
                '36'    =>  array('4', 'S', 'black'),
            )
        ));

        $this->assertInternalType('string', $suit);
        $this->assertEquals($suit, 'red');
    }

    public function testGetTopCardNumber(){

        $class = new ReflectionClass($this->Pile);
        $method = $class->getMethod('getTopCardNumber');
        $method->setAccessible(true);

        $number = $method->invokeArgs($this->Pile, array(
            array(
                '45'    =>  array('8', 'H', 'red'),
                '10'    =>  array('5', 'S', 'black'),
                '23'    =>  array('1', 'H', 'red'),
                '36'    =>  array('4', 'S', 'black'),
            )
        ));

        $this->assertInternalType('string', $number);
        $this->assertEquals($number, '8');
    }

    public function testGetBaseCardNumber(){

        $class = new ReflectionClass($this->Pile);
        $method = $class->getMethod('getBaseCardNumber');
        $method->setAccessible(true);

        $number = $method->invokeArgs($this->Pile, array(
            array(
                '45'    =>  array('8', 'H', 'red'),
                '10'    =>  array('5', 'S', 'black'),
                '23'    =>  array('1', 'H', 'red'),
                '36'    =>  array('4', 'S', 'black'),
            )
        ));

        $this->assertInternalType('string', $number);
        $this->assertEquals($number, '4');
    }

    public function testMoveCard(){

        $piles['pile1'] = $this->Pile->create(array(
            'type'          =>  'tbl',
            'title'         =>  'Tableau',
            'maximumCards'  =>  14,
            'sortOrder'     =>  'desc',
            'sameSuit'      =>  1,
            'movableTo'     =>  array('tbl'),
            'cards'         =>  array(
                                    '12'    =>  array('3', 'H', 'red'),
                                    '18'    =>  array('6', 'S', 'black'),
                                    '22'    =>  array('3', 'C', 'black')
                                ),
            'cardDisplay'   =>  'fanned'
        ));

        $piles['pile2'] = $this->Pile->create(array(
            'type'          =>  'tbl',
            'title'         =>  'Tableau',
            'maximumCards'  =>  14,
            'sortOrder'     =>  'desc',
            'sameSuit'      =>  1,
            'movableTo'     =>  array('tbl'),
            'cards'         =>  array(
                                    '32'    =>  array('2', 'H', 'red'),
                                    '8'    =>  array('9', 'S', 'black'),
                                    '9'    =>  array('1', 'C', 'black')
                                ),
            'cardDisplay'   =>  'fanned'
        ));

        $response = $this->Pile->moveCard($piles['pile2'], $piles['pile1'], $piles);

        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('sourcePile', $response);
        $this->assertArrayHasKey('destinationPile', $response);
    }

    public function testGetPilesBasedOnType(){
        $piles['pile1'] = $this->Pile->create(array(
            'type'          =>  'fdn',
            'title'         =>  'Tableau',
            'maximumCards'  =>  13,
            'sortOrder'     =>  'asc',
            'sameSuit'      =>  1
        ));

        $piles['pile2'] = $this->Pile->create(array(
            'type'          =>  'tbl',
            'title'         =>  'Tableau',
            'maximumCards'  =>  14,
            'sortOrder'     =>  'desc',
            'sameSuit'      =>  1,
            'movableTo'     =>  array('tbl'),
            'cards'         =>  array(
                '32'    =>  array('2', 'H', 'red'),
                '8'    =>  array('9', 'S', 'black'),
                '9'    =>  array('1', 'C', 'black')
            ),
            'cardDisplay'   =>  'fanned'
        ));

        $typePiles = $this->Pile->getPilesBasedOnType('tbl', $piles);
        $this->assertInternalType('array', $typePiles);
        $this->assertEquals(count($typePiles), 1);
    }

} 