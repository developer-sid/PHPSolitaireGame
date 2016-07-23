<?php
/**
 * Created by SiD 
 * Date: 30/01/15
 * Time: 10:36 AM
 * Description: Child class for the game version Towers
 */

namespace lib;


class Towers extends Game{

    protected $Card;
    protected $Deck;
    protected $Pile;
    protected $gamePiles;
    protected $playing;

    public function __construct($Card, $Deck, $Pile){
        $this->Card = $Card;
        $this->Deck = $Deck;
        $this->Pile = $Pile;

        parent::__construct($this->Card, $this->Deck, $this->Pile);
    }

    /**
     * @Method(
     *  name="startGame",
     *  description="start the game towers"
     * )
     */
    public function startGame()
    {
        $this->setNewGame();

        $message = 'Welcome to Towers' . PHP_EOL .
            '-+-+-+-+-+-+-+-+-';

        $this->display($message);   // display welcome message
        $this->redrawBoard($this->gamePiles);   // display piles on console

        while($this->playing)   // game continues
        {
            $userInput = $this->moveReuqest();  // get move input
            $userInput = trim($userInput);
            if($parsedInput = $this->isValidMoveInput($userInput)){ // validate move input
                if(!$this->isQuitGame($parsedInput)){   // if input is not for quiting the game
                    if($this->doMove($parsedInput)){    // perform move
                        $gameStatus = $this->getGameStatus();   // get game status won/not completed
                        if($gameStatus == 'won'){   // if won the game
                            $this->display('Congratulations!! You won the game' . PHP_EOL); // display winning message
                            $this->playing = false; // stop forty thieves
                        }
                        else{   // if game not completed yet
                            $this->redrawBoard($this->gamePiles);   // display updated pile cards on console
                        }
                    }
                }
                else{   // if input is for quiting the game
                    $this->playing = false; // stop forty thieves
                }
            }
        }
    }

    /**
     * @Method(
     *  name="setNewGame",
     *  description="create piles and set vars for towers game"
     * )
     */
    private function setNewGame(){
        $this->playing = true;
        $this->gamePiles = array();

        $cards = $this->Card->getAllSuitCards();    // get all cards
        $this->Deck->loadCards($cards); // load cards to deck
        $this->Deck->shuffleCards();    // shuffle deck cards

        // create 4 Foundation piles
        for($j = 1; $j <= 4; $j++)
        {
            $this->gamePiles[$j] = $this->Pile->createFoundationPile();
        }


        // create 10 Tableau piles
        for($j = 5; $j <= 14; $j++)
        {
            $this->gamePiles[$j] = $this->Pile->createTableauPile(array(
                'cards'     =>  $this->Deck->getCards(5)
            ));
        }

        // create 2 Special Tableau piles with cards
        for($j = 21; $j <= 22; $j++)
        {
            $this->gamePiles[$j] = $this->Pile->createSpecialTableauPile(array(
                'cards'     =>  $this->Deck->getCards(1)
            ));
        }

        // create 2 Special Tableau piles without cards
        for($j = 23; $j <= 24; $j++)
        {
            $this->gamePiles[$j] = $this->Pile->createSpecialTableauPile();
        }
    }
} 