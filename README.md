# PHPSolitaireGame
The famous solitaire card game coded in php.


#Games

Sixteens 

This Game has the following Piles: 

•	Four FoundationPiles each of which can hold a maximum of 13 Cards, all belonging to same suit and building up from A to K. This Game requires that the four FoundationPiles are circular. That is, they may start from any card and build up in a circular fashion. However, the baseCard of all four of these Piles must be the same. These Piles are not fanned.

•	Sixteen Tableau piles (call them SixteensTableauPiles) each of which starts with carrying 3 Cards each after the initial deal. During the play, each of these Piles can carry a maximum of 3 Cards. These Piles are fanned and all Cards are faced up. These Piles can accept Cards from any other Pile in the Game except from the FoundationPiles, as long as they build down alternating on color and do not exceed the 3-card limit. For example, either 4C or 4S can be played on 5H, etc. This pile becomes unusable once it becomes empty. Even a K cannot be played on an empty SixteensTableauPile . This Pile is also circular meaning that KD can be played on 1C/AC.

Two SpecialTableauPiles which are exactly the same as the other Tableau Piles in this Game except that they are reusable even after they are empty. An empty SpecialTableauPile can accept any card. However, the restrictions remain the same as the regular tableau Piles used in this Game, i.e., no more than 3 Cards and building down alternating in colour. You must derive this class from SixteensTableauPile class. 
