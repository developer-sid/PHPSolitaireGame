# PHPSolitaireGame
The famous solitaire card game coded in php.


#Games

Sixteens 

This Game has the following Piles: 

•	Four FoundationPiles each of which can hold a maximum of 13 Cards, all belonging to same suit and building up from A to K. This Game requires that the four FoundationPiles are circular. That is, they may start from any card and build up in a circular fashion. However, the baseCard of all four of these Piles must be the same. These Piles are not fanned.

•	Sixteen Tableau piles (call them SixteensTableauPiles) each of which starts with carrying 3 Cards each after the initial deal. During the play, each of these Piles can carry a maximum of 3 Cards. These Piles are fanned and all Cards are faced up. These Piles can accept Cards from any other Pile in the Game except from the FoundationPiles, as long as they build down alternating on color and do not exceed the 3-card limit. For example, either 4C or 4S can be played on 5H, etc. This pile becomes unusable once it becomes empty. Even a K cannot be played on an empty SixteensTableauPile . This Pile is also circular meaning that KD can be played on 1C/AC.

• Two SpecialTableauPiles which are exactly the same as the other Tableau Piles in this Game except that they are reusable even after they are empty. An empty SpecialTableauPile can accept any card. However, the restrictions remain the same as the regular tableau Piles used in this Game, i.e., no more than 3 Cards and building down alternating in colour. You must derive this class from SixteensTableauPile class. 



Towers 

This Game has the following Piles: 

•	Four FoundationPiles each of which can hold a maximum of 13 Cards, all belonging to same suit and building up from A to K. This Game requires that the four FoundationPiles are not circular. That is, they must start from A and end at K upon completion. These Piles are not fanned. 

•	Ten Tableau piles (call them TowersTableauPiles) each of which starts with carrying 5 Cards each after the initial deal. During the play, each of these can carry a maximum of 17 Cards (restrictions in Card movement will not let you place more than 17 Cards on any of these Piles). These Piles are fanned and all Cards are up. These Piles can accept Cards from any other Pile in the Game except from the FoundationPiles, as long as they build down on the same suit. For example, only 4H can be played on 5H, etc. Once a TowersTableauPile becomes empty, it can only accept a K of any suit. These Piles are non-circular meaning that KD cannot be played on 1D/AD.

• Four special TowersPiles. After the initial deal any two of these contain one Card each. These Cards should be faced up. TowersPiles can accept any Card as long as it is coming from the TowersTableauPiles. These Piles cannot carry more than a single card.



FortyThieves 

This Game has the following Piles: 

• Four FoundationPiles each of which can hold a maximum of 13 Cards, all belonging to same suit and building up from A to K. This Game requires that the four FoundationPiles are not circular. That is, they must start from A and end at K upon completion. These Piles are not fanned.

• Ten non-Circular Tableau piles (call them FortyThievesTableauPiles) each of which starts with carrying 2 Cards each after the initial deal. During the play, each of these can carry a maximum of 14 Cards (restrictions in Card movement will not let you place more than 14 Cards on any of these Piles). These Piles are fanned and all Cards are up. These Piles can accept Cards from any other Pile in the Game except from the FoundationPiles and StockPile as long as they build down on the same suit. For example, only 4H can be played on 5H, etc. Once a FortyThievesTableauPile becomes empty, it can accept any Card of any suit. The FortyThievesTableauPile can act as a base class from which we can derive the TowersTableauPile class due to similar kind of behavior.

• One StockPile which contains the remaining 32 Cards, all faced down, and obviously not fanned.
One DiscardPile which is empty to start with. As described previously, Cards from StockPile can only be moved to DiscardPile which can only accept cards from a StockPile. DiscardPile is not fanned and all cards are faced up.
