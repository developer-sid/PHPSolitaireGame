<?php
/**
 * Created by SiD 
 * Date: 27/01/15
 * Time: 1:14 PM
 * Description: Class contains all methods related to cards
 */

namespace lib;


class Card {

    protected $counter = 0;
    protected $suitColors = array(
                                'H' =>  'red',
                                'D' =>  'red',
                                'S' =>  'black',
                                'C' =>  'black'
                            );

    /**
     * @Method(
     *  name="getAllSuitCards"
     *  description="get cards of all suits",
     *  @responses(
     *      @response(
     *          description="cards"
     *          responseType="array"
     *      )
     *  )
     * )
     */
    public function getAllSuitCards(){
        $suit['hearts'] = $this->getSuitCards('H'); // all heart cards
        $suit['clubs'] = $this->getSuitCards('C');  // all club cards
        $suit['spades'] = $this->getSuitCards('S'); // all spade cards
        $suit['diamonds'] = $this->getSuitCards('D');   // all diamond cards
        $allCards = array_replace($suit['hearts'], $suit['clubs'], $suit['spades'], $suit['diamonds']); // merge arrays to one array
        unset($suit);
        return $allCards;
    }

    /**
     * @Method(
     *  name="getSuitCards"
     *  description="get all cards of a suit",
     *  @operation(
     *      @parameters(
     *          @parameter(
     *           name="suit",
     *           description="suit id",
     *           paramType="string",
     *           required="true"
     *          )
     *      )
     *  ),
     *  @responses(
     *      @response(
     *          description="cards"
     *          responseType="array"
     *      )
     *  )
     * )
     */
    private function getSuitCards($suit){
        for($j = 1; $j <= 13; $j++)
        {
            $this->counter++;
            $suitCards[$this->counter] = array($j, $suit, $this->suitColors[$suit]);
        }
        return $suitCards;
    }

    /**
     * @Method(
     *  name="toString"
     *  description="get card info as string",
     *  @operation(
     *      @parameters(
     *          @parameter(
     *           name="cards",
     *           description="array of cards",
     *           paramType="array",
     *           required="true"
     *          )
     *      )
     *  ),
     *  @responses(
     *      @response(
     *          description="card info as string"
     *          responseType="string"
     *      )
     *  )
     * )
     */
    public function toString($cards){
        $string = '';
        $con = '';
        foreach($cards as $cardId => $cardData){    // loop all cards
            $cardNumber = $cardData[0];
            if($cardNumber == 11){  // card number 11 = J
                $cardNumber = 'J';
            }elseif($cardNumber == 12){   // card number 12 = Q
                $cardNumber = 'Q';
            }elseif($cardNumber == 13){   // card number 13 = K
                $cardNumber = 'K';
            }
            $string .= $con . $cardNumber . $cardData[1];;
            $con = ' ';
        }
        return $string;
    }
} 