<?php
/**
 * Created by SiD 
 * Date: 27/01/15
 * Time: 1:14 PM
 * Description: Child class for Forty Thieves game piles
 */

namespace lib;


class FortyThievesPile extends Pile{

    /**
     * @Method(
     *  name="createFoundationPile",
     *  description="create foundation pile"
     * )
     */
    public function createFoundationPile()
    {
        return $this->create(array(
            'type'              =>  'fdn',
            'title'             =>  'Foundation',
            'maximumCards'      =>  13,
            'baseCardRule'      =>  'strict',
            'sortOrder'         =>  'asc',
            'sameSuit'          =>  1,
            'cardDisplay'       =>  'top'
        ));
    }

    /**
     * @Method(
     *  name="createTableauPile",
     *  description="create tableau pile"
     * )
     */
    public function createTableauPile($options)
    {
        return $this->create(array(
            'type'          =>  'tbl',
            'title'         =>  'Tableau',
            'maximumCards'  =>  14,
            'sortOrder'     =>  'desc',
            'sameSuit'      =>  1,
            'movableTo'     =>  array('fdn', 'tbl'),
            'cards'         =>  $options['cards'],
            'cardDisplay'   =>  'fanned'
        ));
    }

} 