<?php
/**
 * Created by SiD 
 * Date: 29/01/15
 * Time: 11:16 PM
 * Description: Child class for Sixteens game piles
 */

namespace lib;


class SixteensPile extends Pile{

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
            'baseCardRule'      =>  'basecircular',
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
            'type'              =>  'tbl',
            'title'             =>  'Tableau',
            'maximumCards'      =>  3,
            'sortOrder'         =>  'desc',
            'sameSuit'          =>  0,
            'alternateColor'    =>  1,
            'movableTo'         =>  array('fdn', 'tbl'),
            'cards'             =>  $options['cards'],
            'cardDisplay'       =>  'fanned',
            'reusable'          =>  0
        ));
    }

    /**
     * @Method(
     *  name="createTableauPile",
     *  description="create special tableau pile"
     * )
     */
    public function createSpecialTableauPile($options)
    {
        return $this->create(array(
            'type'              =>  'tbl',
            'title'             =>  'Sp.Tableau',
            'maximumCards'      =>  3,
            'sortOrder'         =>  'desc',
            'sameSuit'          =>  0,
            'alternateColor'    =>  1,
            'movableTo'         =>  array('fdn', 'tbl'),
            'cards'             =>  $options['cards'],
            'cardDisplay'       =>  'fanned'
        ));
    }
} 