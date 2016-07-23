<?php
/**
 * Created by SiD 
 * Date: 27/01/15
 * Time: 1:14 PM
 * Description: Abstract class for game piles
 */

namespace lib;


abstract class Pile {

    /**
     * @Method(
     *  name="create"
     *  description="create a new pile",
     *  @operation(
     *      @parameters(
     *          @parameter(
     *           name="pile",
     *           description="array of pile options",
     *           paramType="array",
     *           required="true",
     *              @parameters(
     *                  @parameter(
     *                   name="type",
     *                   description="type of pile",
     *                   valueOptions="fdn,tbl,stk,dcd",
     *                   paramType="string",
     *                   required="true"
     *                  ),
     *                  @parameter(
     *                   name="name",
     *                   description="name for pile",
     *                   paramType="string",
     *                   required="true"
     *                  ),
     *                  @parameter(
     *                   name="maximumCards",
     *                   description="maximum number of cards allowed in the pile",
     *                   paramType="integer",
     *                   required="true"
     *                  ),
     *                  @parameter(
     *                   name="cardDisplay",
     *                   description="set how the pile should display its cards",
     *                   paramType="string",
     *                   valueOptions="fanned,top,none",
     *                   required="true"
     *                  ),
     *                  @parameter(
     *                   name="sortOrder",
     *                   description="order of cards in the pile",
     *                   paramType="string",
     *                   valueOptions="asc,desc,none",
     *                   required="false",
     *                   defaultValue="none"
     *                  ),
     *                  @parameter(
     *                   name="sameSuit",
     *                   description="set the pile can contain only cards from same suit",
     *                   paramType="integer",
     *                   valueOptions="1,0",
     *                   required="false",
     *                   defaultValue="0"
     *                  ),
     *                  @parameter(
     *                   name="movableTo",
     *                   description="to which type of piles the cards can move from this pile",
     *                   paramType="array",
     *                   required="false"
     *                  ),
     *                  @parameter(
     *                   name="baseCardRule",
     *                   description="restrict the base card for an empty pile",
     *                   paramType="string",
     *                   valueOptions="circular,basecircular,strict",
     *                   required="false",
     *                   defaultValue="circular"
     *                  ),
     *                  @parameter(
     *                   name="alternateColor",
     *                   description="sets only alternate colored cards can be added to pile",
     *                   paramType="integer",
     *                   valueOptions="1,0",
     *                   required="false",
     *                   defaultValue="0"
     *                  ),
     *                  @parameter(
     *                   name="reusable",
     *                   description="reusability of empty pile",
     *                   paramType="integer",
     *                   valueOptions="1,0",
     *                   required="false",
     *                   defaultValue="0"
     *                  ),
     *                  @parameter(
     *                   name="cards",
     *                   description="array of cards",
     *                   paramType="array"
     *                  ),
     *              )
     *          )
     *      )
     *  ),
     *  @responses(
     *      @response(
     *          description="created pile"
     *          responseType="array"
     *      ),
     *      @response(
     *          value="false",
     *          description="pile creation failed",
     *          responseType="boolean"
     *      )
     *  )
     * )
     */
    public function create($pile){
        if(!empty($pile['title']))
        {
            $createPile = true;
            if(!empty($pile['maximumCards']) && !empty($pile['cards'])) // if pile is not empty and there is a limit set for maximum number of cards
            {
                if(count($pile['cards']) > $pile['maximumCards'])   // if cards exceeds the maximum limit
                {
                    $createPile = false;

                    // write error log code here
                }
            }

            if($createPile == true)
            {
                return $pile; // return pile
            }
            return false;
        }
    }

    /**
     * @Method(
     *  name="getPileString"
     *  description="get pile data as a string",
     *  @operation(
     *      @parameters(
     *          @parameter(
     *           name="id",
     *           description="id of file",
     *           paramType="integer",
     *           required="true"
     *          ),
     *          @parameter(
     *           name="pile",
     *           description="pile itself",
     *           paramType="array",
     *           required="true"
     *          ),
     *          @parameter(
     *           name="card",
     *           description="object of card class",
     *           paramType="object",
     *           required="true"
     *          )
     *      )
     *  ),
     *  @responses(
     *      @response(
     *          description="pile string"
     *          responseType="string"
     *      )
     *  )
     * )
     */
    public function getPileString($id, $pile, $Card){
        $pileString = '';
        $pileNumber = '['. $id .']'; // id of pile
        $pileString = PHP_EOL . str_pad($pileNumber, 5, ' ', STR_PAD_RIGHT) . $pile['title'] . ':'; //  format pile id with pile title
        if(empty($pile['cards'])){
            $pileString .= ' Empty';    // if no cards in pile show empty text
        }
        else{
            if($pile['cardDisplay'] == 'fanned')    // if pile is set as fanned show all cards
            {
                foreach($pile['cards'] as $pileCardId => $pileCard)
                {
                    $pileString .= ' ' . $Card->toString(array($pileCardId =>$pileCard));
                }
            }
            elseif($pile['cardDisplay'] == 'none')  // if set as none hide cards and show only count
            {
                $pileString .= ' ' . count($pile['cards']) . ' card(s): Faced down';
            }
            elseif($pile['cardDisplay'] == 'top')   // if set to show only top card
            {
                $topCard = $this->getTopCard($pile['cards']);   // get pile top card
                $pileString .= ' ' . $Card->toString($topCard) . ' (Remaining ' . (count($pile['cards']) - 1) . ' card(s) below)';
            }
        }

        return $pileString;
    }

    /**
     * @Method(
     *  name="getTopCard"
     *  description="get top card from the pile",
     *  @operation(
     *      @parameters(
     *          @parameter(
     *           name="cards",
     *           description="all cards from the pile",
     *           paramType="array",
     *           required="true"
     *          )
     *      )
     *  ),
     *  @responses(
     *      @response(
     *          description="top card data"
     *          responseType="array"
     *      )
     *  )
     * )
     */
    protected function getTopCard($cards){
        return array_slice($cards, 0, 1, true); // get first element from array
    }

    /**
     * @Method(
     *  name="getBaseCard"
     *  description="get base card from the pile",
     *  @operation(
     *      @parameters(
     *          @parameter(
     *           name="cards",
     *           description="all cards from the pile",
     *           paramType="array",
     *           required="true"
     *          )
     *      )
     *  ),
     *  @responses(
     *      @response(
     *          description="base card data"
     *          responseType="array"
     *      )
     *  )
     * )
     */
    protected function getBaseCard($cards){
        return array_slice($cards, -1, 1, true);    // get last element from array
    }

    /**
     * @Method(
     *  name="getTopCardSuit"
     *  description="get suit of top card",
     *  @operation(
     *      @parameters(
     *          @parameter(
     *           name="cards",
     *           description="all cards from the pile",
     *           paramType="array",
     *           required="true"
     *          )
     *      )
     *  ),
     *  @responses(
     *      @response(
     *          description="suit letter"
     *          responseType="string"
     *      )
     *  )
     * )
     */
    protected function getTopCardSuit($cards){
        $topCard = $this->getTopCard($cards); // get top card
        foreach($topCard as $cardData){
            return $cardData[1]; // return suit letter
        }
    }

    /**
     * @Method(
     *  name="getTopCardColor"
     *  description="get color of top card",
     *  @operation(
     *      @parameters(
     *          @parameter(
     *           name="cards",
     *           description="all cards from the pile",
     *           paramType="array",
     *           required="true"
     *          )
     *      )
     *  ),
     *  @responses(
     *      @response(
     *          description="color"
     *          responseType="string"
     *      )
     *  )
     * )
     */
    protected function getTopCardColor($cards){
        $topCard = $this->getTopCard($cards); // get top card
        foreach($topCard as $cardData){
            return $cardData[2]; // return suit color
        }
    }

    /**
     * @Method(
     *  name="getTopCardNumber"
     *  description="get number of top card",
     *  @operation(
     *      @parameters(
     *          @parameter(
     *           name="cards",
     *           description="all cards from the pile",
     *           paramType="array",
     *           required="true"
     *          )
     *      )
     *  ),
     *  @responses(
     *      @response(
     *          description="number"
     *          responseType="integer"
     *      )
     *  )
     * )
     */
    protected function getTopCardNumber($cards){
        $topCard = $this->getTopCard($cards); // get top card
        foreach($topCard as $cardData){
            return $cardData[0]; // return suit letter
        }
    }

    /**
     * @Method(
     *  name="getBaseCardNumber"
     *  description="get number of base card",
     *  @operation(
     *      @parameters(
     *          @parameter(
     *           name="cards",
     *           description="all cards from the pile",
     *           paramType="array",
     *           required="true"
     *          )
     *      )
     *  ),
     *  @responses(
     *      @response(
     *          description="number"
     *          responseType="integer"
     *      )
     *  )
     * )
     */
    protected function getBaseCardNumber($cards){
        $baseCard = $this->getBaseCard($cards); // get top card
        foreach($baseCard as $cardData){
            return $cardData[0]; // return suit letter
        }
        return false;
    }

    /**
     * @Method(
     *  name="moveCard"
     *  description="move a card from one pile to another",
     *  @operation(
     *      @parameters(
     *          @parameter(
     *           name="sourcePile",
     *           description="the pile from which the card should be moved",
     *           paramType="array",
     *           required="true"
     *          )
     *      ),
     *      @parameters(
     *          @parameter(
     *           name="destinationPile",
     *           description="the pile to which the card should be moved",
     *           paramType="array",
     *           required="true"
     *          )
     *      ),
     *      @parameters(
     *          @parameter(
     *           name="gamePiles",
     *           description="all piles created for the game",
     *           paramType="array",
     *           required="true"
     *          )
     *      )
     *  ),
     *  @responses(
     *      @response(
     *          description="if success, array containing updated source pile and destination pile"
     *          responseType="array"
     *      ),
     *      @response(
     *          value="false"
     *          description="if move failed"
     *          responseType="boolean"
     *      )
     *  )
     * )
     */
    public function moveCard($sourcePile, $destinationPile, $gamePiles){
        if(!empty($sourcePile['movableTo'])){   // check source pile allowed to move cards to other piles
            if(in_array($destinationPile['type'], $sourcePile['movableTo'])){   // check source pile allowed to move cards to destination pile

                // check destination pile already reached its limit
                $doMove = true;
                if(!empty($destinationPile['maximumCards']) && !empty($destinationPile['cards'])){
                    if(count($destinationPile['cards']) == $destinationPile['maximumCards']){
                        $doMove = false;
                    }
                }

                if($doMove === true){   // if destination pile not reached its card limit yet

                    if(!empty($destinationPile['cards'])){  // if pile is not empty
                        /* suit validation */
                        if(!empty($destinationPile['sameSuit'])){ // if destionation pile can accept cards only from same suit
                            $sourceTopCardSuit = $this->getTopCardSuit($sourcePile['cards']);   // get top card from source pile
                            $destinationTopCardSuit = $this->getTopCardSuit($destinationPile['cards']);   // get top card from source pile
                            if($sourceTopCardSuit != $destinationTopCardSuit){
                                $doMove = false;
                            }
                        }
                        elseif(!empty($destinationPile['alternateColor'])){ // if destionation pile can accept alternate color cards only
                            // alternative color checking
                            $sourceTopCardColor = $this->getTopCardColor($sourcePile['cards']);   // get top card from source pile
                            $destinationTopCardColor = $this->getTopCardColor($destinationPile['cards']);   // get top card from source pile
                            if($sourceTopCardColor == $destinationTopCardColor){
                                $doMove = false;
                            }
                        }

                    }
                    else{ /* base card rule validation */

                        // pile reusability check
                        if(isset($destinationPile['reusable'])){
                            if($destinationPile['reusable'] == '0'){    // if pile is not allowed to reuse
                                $doMove = false;
                            }
                        }

                        if($doMove == true && !empty($destinationPile['sortOrder'])){
                            // base card rule validation
                            $sourceTopCardNumber = $this->getTopCardNumber($sourcePile['cards']);   // get top card from source pile

                            if($destinationPile['baseCardRule'] == 'strict'){   // if the empty pile can only accept 1 or K depeneding upoon the sort order value
                                if($destinationPile['sortOrder'] == 'asc'){ // if sort order is ascending
                                    if($sourceTopCardNumber != '1'){    // if moving card number is not 1, stop move process
                                        $doMove = false;
                                    }
                                }
                                else{   // if sort order is descending
                                    if($sourceTopCardNumber != '13'){    // if moving card number is not K, stop move process
                                        $doMove = false;
                                    }
                                }
                            }
                            elseif($destinationPile['baseCardRule'] == 'basecircular'){ // if pile is set as circular with common base
                                if(!$this->isValidCircularCardNumber($sourceTopCardNumber, $destinationPile, $gamePiles)){  // common base circular validation
                                    $doMove = false;
                                }
                            }
                        }
                    }

                    if($doMove === true){   // if suit condition matches

                        /* card sort order validation for non empty pile */
                        if(!empty($destinationPile['sortOrder']) && !empty($destinationPile['cards'])){ // if sort order rule set for destionation pile
                            $sourceTopCardNumber = $this->getTopCardNumber($sourcePile['cards']);   // get top card from source pile
                            $destinationTopCardNumber = $this->getTopCardNumber($destinationPile['cards']);   // get top card from source pile

                            $isCircularPile = 1;
                            if(!empty($destinationPile['baseCardRule'])){
                                if($destinationPile['baseCardRule'] == 'strict'){
                                    $isCircularPile = 0;
                                }
                            }

                            if($destinationPile['sortOrder'] == 'asc'){ // ascending order checking
                                if(($destinationTopCardNumber + 1) != $sourceTopCardNumber){
                                    $doMove = false;
                                }

                                //  if circular pile allow card A after K
                                if($isCircularPile == 1){
                                    if($destinationTopCardNumber == 13 && $sourceTopCardNumber == 1){
                                        $doMove = true;
                                    }
                                }
                            }
                            elseif($destinationPile['sortOrder'] == 'desc'){    // descending order checking
                                if(($destinationTopCardNumber - 1) != $sourceTopCardNumber){
                                    $doMove = false;
                                }

                                //  if circular pile allow card K after A
                                if($isCircularPile == 1){
                                    if($destinationTopCardNumber == 1 && $sourceTopCardNumber == 13){
                                        $doMove = true;
                                    }
                                }
                            }
                        }

                        if($doMove === true){   // if move passed sort order validation
                            $sourceTopCard = $this->getTopCard($sourcePile['cards']);   // get top card from source pile
                            if($destinationPile = $this->addCard($destinationPile, $sourceTopCard)){    // add sourced top card to destination pile
                                $sourcePile = $this->removeCard($sourcePile, $sourceTopCard);   // remove top card from source file if it successfully added to destinatiion pile
                                return array(
                                    'sourcePile'        =>  $sourcePile,
                                    'destinationPile'   =>  $destinationPile
                                );
                            }
                        }
                    }
                }
            }
        }
        return false;
    }

    /**
     * @Method(
     *  name="removeCard"
     *  description="remove cards from a pile",
     *  @operation(
     *      @parameters(
     *          @parameter(
     *           name="pile",
     *           description="the pile from which the card should be removed",
     *           paramType="array",
     *           required="true"
     *          )
     *      ),
     *      @parameters(
     *          @parameter(
     *           name="cards",
     *           description="cards need to be removed",
     *           paramType="array",
     *           required="true"
     *          )
     *      )
     *  ),
     *  @responses(
     *      @response(
     *          description="updated pile"
     *          responseType="array"
     *      )
     *  )
     * )
     */
    private function removeCard($pile, $cards){
        foreach($cards as $cardId => $card){
            if(isset($pile['cards'][$cardId])){
                unset($pile['cards'][$cardId]);
            }
        }
        return $pile;
    }

    /**
     * @Method(
     *  name="addCard"
     *  description="add cards to a pile",
     *  @operation(
     *      @parameters(
     *          @parameter(
     *           name="pile",
     *           description="the pile to which the card should be added",
     *           paramType="array",
     *           required="true"
     *          )
     *      ),
     *      @parameters(
     *          @parameter(
     *           name="cards",
     *           description="cards need to be added",
     *           paramType="array",
     *           required="true"
     *          )
     *      )
     *  ),
     *  @responses(
     *      @response(
     *          description="updated pile"
     *          responseType="array"
     *      )
     *  )
     * )
     */
    private function addCard($pile, $cards){

        $cardAdded = false;

        $pileCards = array();
        if(!empty($pile['cards'])){
            $pileCards = $pile['cards'];
        }

        foreach($cards as $cardId => $card){
            if(!isset($pileCards[$cardId])){
                $pileCards = array($cardId => $card) + $pileCards;
                $cardAdded = true;
            }
        }

        if($cardAdded){
            if(!empty($pileCards)){
                $pile['cards'] = $pileCards;
            }
            return $pile;
        }
        return false;
    }

    /**
     * @Method(
     *  name="isValidCircularCardNumber"
     *  description="checking a card whether its a valid circular base card",
     *  @operation(
     *      @parameters(
     *          @parameter(
     *           name="cardNumber",
     *           description="number of the card",
     *           paramType="integer",
     *           required="true"
     *          )
     *      ),
     *      @parameters(
     *          @parameter(
     *           name="destionationPile",
     *           description="pile to which card should be added",
     *           paramType="array",
     *           required="true"
     *          )
     *      ),
     *      @parameters(
     *          @parameter(
     *           name="gamePiles",
     *           description="all piles of the game",
     *           paramType="array",
     *           required="true"
     *          )
     *      )
     *  ),
     *  @responses(
     *      @response(
     *          value="true",
     *          description="if validation passed"
     *          responseType="boolean"
     *      ),
     *      @response(
     *          value="false",
     *          description="if validation failed"
     *          responseType="boolean"
     *      )
     *  )
     * )
     */
    private function isValidCircularCardNumber($cardNumber, $destionationPile, $gamePiles){
        $typePiles = $this->getPilesBasedOnType($destionationPile['type'], $gamePiles); // get all pile based on destination pile type
        if(!empty($typePiles)){
            foreach($typePiles as $pile){   // loop same type piles
                if(!empty($pile['cards'])){
                    $baseCardNumber = $this->getBaseCardNumber($pile['cards']); // get base card number
                    if(!empty($baseCardNumber)){
                        if($baseCardNumber != $cardNumber){ // if any base card number is not maching with moving card number, validation fails
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * @Method(
     *  name="getPilesBasedOnType"
     *  description="get same type files based on give type",
     *  @operation(
     *      @parameters(
     *          @parameter(
     *           name="type",
     *           description="pile type",
     *           paramType="string",
     *           required="true"
     *          )
     *      ),
     *      @parameters(
     *          @parameter(
     *           name="gamePiles",
     *           description="all piles of the game",
     *           paramType="array",
     *           required="true"
     *          )
     *      )
     *  ),
     *  @responses(
     *      @response(
     *          description="same type piles"
     *          responseType="array"
     *      ),
     *      @response(
     *          value="false",
     *          description="if no piles found with the given type"
     *          responseType="boolean"
     *      )
     *  )
     * )
     */
    public function getPilesBasedOnType($type, $gamePiles){
        foreach($gamePiles as $pile){   // loop each pile
            if($pile['type'] == $type){ // check type of pile
                $typePiles[] = $pile;
            }
        }

        if(!empty($typePiles)){
            return $typePiles; // returns same type piles
        }
        return false;
    }
} 