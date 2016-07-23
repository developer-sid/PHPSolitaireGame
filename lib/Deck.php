<?php
/**
 * Created by SiD 
 * Date: 27/01/15
 * Time: 1:14 PM
 * Description: Class contains all methods related to deck
 */

namespace lib;


class Deck {

    public $cards;

    /**
     * @Method(
     *  name="loadCards"
     *  description="load cards to deck"
     * )
     */
    public function loadCards($cards){
        $this->cards = $cards;
    }

    /**
     * @Method(
     *  name="shuffleCards"
     *  description="shuffle all cards in the deck"
     * )
     */
    public function shuffleCards(){
        $keys = array_keys($this->cards);
        shuffle($keys);
        $random = array();
        foreach ($keys as $key) {
            $random[$key] = $this->cards[$key];
        }
        $this->cards = $random;
    }

    /**
     * @Method(
     *  name="getCards"
     *  description="get n cards from deck",
     *  @operation(
     *      @parameters(
     *          @parameter(
     *           name="number",
     *           description="number of card need to release from deck",
     *           paramType="integer",
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
    public function getCards($number){
        $cardsFromDeck = array_slice($this->cards, 0, $number, true);
        $this->cards = array_slice($this->cards, $number, count($this->cards), true);
        return $cardsFromDeck;
    }
} 