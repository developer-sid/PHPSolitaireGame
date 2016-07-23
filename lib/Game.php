<?php
/**
 * Created by SiD 
 * Date: 27/01/15
 * Time: 1:14 PM
 * Description: Abstract class for game
 */

namespace lib;


abstract class Game {

    protected $running = true;
    protected $selectedGame = false;

    public function __construct($Card = null, $Deck = null, $Pile = null){
        $this->Card = $Card;
        $this->Deck = $Deck;
        $this->Pile = $Pile;
    }

    /**
     * @Method(
     *  name="start"
     *  description="start solitaire game",
     *  @operation(
     *       @parameters(
     *         @parameter(
     *           name="games",
     *           description="array of game version class objects",
     *           paramType="array",
     *           required="true"
     *         )
     *       )
     *     )
     * )
     */
    public function start(array $games){

        $message = 'Welcome to Solitaire!' . PHP_EOL .  // message to to display on game load
            'Today\'s menu of solitaire games includes:' . PHP_EOL .
            '       1. The Towers (t)' . PHP_EOL .
            '       2. Forty Thieves (f)' . PHP_EOL .
            '       3. Sixteens (s)' . PHP_EOL .
            'All to challenge you. Enjoy!' . PHP_EOL;
        $this->display($message); // display message
        unset($message);

        while($this->running) // game running
        {
            while(!$this->selectedGame) // if user not selected the game version yet
            {
                $input = $this->gameVersionReuqest();   // get game version input from user
                $input = strtolower($input);

                if(!empty($games[$input]))  // if user entered a valid game value
                {
                    $this->selectedGame = $input;   // set as user selected the game version
                    $games[$input]->startGame();    // start user selected game version
                    unset($input);
                    $playAgain = $this->playAgainReuqest(); //  if game completed or quit as for play again
                    if(strtolower($playAgain) == 'y'){  //  if user choose to play again
                        $this->selectedGame = false;    //  unset selecteg game value so that user can choose a new game version
                    }
                    else{   // else stop game
                        $this->running = false;
                    }
                }
                else    // if user entered an invalid game version value
                {
                    unset($input);
                    $this->display('Valid  choices are t(towers), f(forty thieves) or s(sixteens)' . PHP_EOL);  // display valid game version values
                }
            }
        }
    }

    /**
     * @Method(
     *  name="getUserInput"
     *  description="get user input from via console",
     *  @operation(
     *       @parameters(
     *         @parameter(
     *           name="message",
     *           description="message to display in console",
     *           paramType="string",
     *           required="true"
     *         )
     *       )
     *     ),
     *  @responses(
     *      @response(
     *          description="user input"
     *          responseType="string"
     *      )
     *  )
     * )
     */
    public function getUserInput($message){
        echo $message;
        $fr=fopen("php://stdin","r");   // open our file pointer to read from stdin
        $input = fgets($fr,128);        // read a maximum of 128 characters
        $input = rtrim($input);         // trim any trailing spaces.
        fclose ($fr);                   // close the file handle
        return $input;
    }

    /**
     * @Method(
     *  name="display"
     *  description="display text in console",
     *  @operation(
     *       @parameters(
     *         @parameter(
     *           name="text",
     *           description="text to display in console",
     *           paramType="string",
     *           required="true"
     *         )
     *       )
     *     )
     * )
     */
    public function display($text){
        echo $text;
    }

    /**
     * @Method(
     *  name="redrawBoard"
     *  description="display game pile cards",
     *  @operation(
     *       @parameters(
     *         @parameter(
     *           name="piles",
     *           description="array of game piles",
     *           paramType="array",
     *           required="true"
     *         )
     *       )
     *  )
     * )
     */
    public function redrawBoard($piles){
        $content = '';
        foreach($piles as $key => $pile)    // loop all piles
        {
            $content .= $this->Pile->getPileString($key, $pile, $this->Card);   // get pile cards data as string
        }
        $this->display($content);   // display pile data as string
    }

    /**
     * @Method(
     *  name="moveReuqest"
     *  description="display move request text and get user input",
     *  @responses(
     *      @response(
     *          description="user input"
     *          responseType="string"
     *      )
     *  )
     * )
     */
    public function moveReuqest(){
        return $this->getUserInput(PHP_EOL . 'Enter move as src# dst# (or quit to end game):'); //  get user input
    }

    /**
     * @Method(
     *  name="playAgainReuqest"
     *  description="display play again request text and get user input",
     *  @responses(
     *      @response(
     *          description="user input"
     *          responseType="string"
     *      )
     *  )
     * )
     */
    public function playAgainReuqest(){
        return $this->getUserInput('Play Again. (Y/N)?');   // get user input
    }

    /**
     * @Method(
     *  name="gameVersionReuqest"
     *  description="get game version input from user",
     *  @responses(
     *      @response(
     *          description="user input"
     *          responseType="string"
     *      )
     *  )
     * )
     */
    public function gameVersionReuqest(){
        return $this->getUserInput('Which version of solitaire would you like to play?');   // get user input
    }

    /**
     * @Method(
     *  name="isValidMoveInput"
     *  description="check submitted a valid move request values",
     *  @operation(
     *       @parameters(
     *         @parameter(
     *           name="input",
     *           description="input value",
     *           paramType="string",
     *           required="true"
     *         )
     *       )
     *  ),
     *  @responses(
     *      @response(
     *          value="quit",
     *          description="passed the validation with the input 'quit'",
     *          responseType="string"
     *      ),
     *      @response(
     *          value="2 pile ids",
     *          description="passed the validation with 2 pile ids",
     *          responseType="array"
     *      ),
     *      @response(
     *          value="false",
     *          description="validation failed",
     *          responseType="boolean"
     *      )
     *  )
     * )
     */
    public function isValidMoveInput($input){
        if($input == 'quit'){   //  if user choose to quit
            return $input;
        }else{
            $inputValues = explode(' ', $input);    //  split values
            $inputValues = array_filter($inputValues);  //  remove blank array items

            if(count($inputValues) == 2)    // if there are only 2 input values
            {
                if($inputValues[0] != $inputValues[1]){ // check if 2 inputs are not same
                    if(isset($this->gamePiles[$inputValues[0]]) && isset($this->gamePiles[$inputValues[1]])){   // if 2 inputs are valid pile ids
                        return $inputValues;
                    }
                }
                $this->display('Invalid srs# or dst#'); // show invalid pile id message
                return false;
            }
            $this->display('Badly formatted request');  // display the message that user entered the values in incorrect format
            return false;
        }
    }

    /**
     * @Method(
     *  name="isQuitGame"
     *  description="check entered input is for quit the game",
     *  @operation(
     *       @parameters(
     *         @parameter(
     *           name="input",
     *           description="input value",
     *           paramType="string",
     *           required="true"
     *         )
     *       )
     *  ),
     *  @responses(
     *      @response(
     *          value="true",
     *          description="passed the validation with the input 'quit'",
     *          responseType="boolean"
     *      ),
     *      @response(
     *          value="false",
     *          description="validation failed",
     *          responseType="boolean"
     *      )
     *  )
     * )
     */
    public function isQuitGame($input){
        $inputValue = $input;
        if(is_array($input))
        {
            $inputValue = $input[0];
        }

        if(strtolower($inputValue) == 'quit'){
            return true;
        }
        return false;
    }

    /**
     * @Method(
     *  name="doMove"
     *  description="process card move request",
     *  @operation(
     *       @parameters(
     *         @parameter(
     *           name="input",
     *           description="source pile id and destination pile id",
     *           paramType="array",
     *           required="true"
     *         )
     *       )
     *  ),
     *  @responses(
     *      @response(
     *          value="true",
     *          description="if card successfully moved",
     *          responseType="boolean"
     *      ),
     *      @response(
     *          value="false",
     *          description="if faild to move the card",
     *          responseType="boolean"
     *      )
     *  )
     * )
     */
    public function doMove($input){
        if(is_array($input)){   // confirm paramter is an array
            if(count($input) == 2)
            {
                $sourcePile = $this->gamePiles[$input[0]];  //  get source pile using its id
                $destinationPile = $this->gamePiles[$input[1]]; // get destination pile using its id
                if($response = $this->Pile->moveCard($sourcePile, $destinationPile, $this->gamePiles)){ // pass data to pile class to move the card
                    $this->gamePiles[$input[0]] = $response['sourcePile'];  // store updated source pile
                    $this->gamePiles[$input[1]] = $response['destinationPile']; // store update destination pile
                    return true;
                }
                else{
                    $this->display('Illegal Move'); // if move faild show message
                }
            }
            else{
                // write error log code here
            }
        }
        else{
            // write error log code here
        }
        return false;
    }

    /**
     * @Method(
     *  name="getGameStatus"
     *  description="check game completed",
     *  @responses(
     *      @response(
     *          value="notCompleted",
     *          description="game not completeted yet",
     *          responseType="string"
     *      ),
     *      @response(
     *          value="won",
     *          description="game completed and won",
     *          responseType="string"
     *      )
     *  )
     * )
     */
    public function getGameStatus(){
        $foundationPiles = $this->Pile->getPilesBasedOnType('fdn', $this->gamePiles); // get all foundation piles
        foreach($foundationPiles as $pile){
            if(empty($pile['cards'])){
                return 'notCompleted';
            }
            else{
                if(count($pile['cards']) < 13){ // if any foundation pile not reached its limit yet
                    return 'notCompleted';
                }
            }
        }
        return 'won';
    }
} 