<?php
/**
 * Created by SiD 
 * Date: 30/01/15
 * Time: 10:37 AM
 * Description: Child class for Towers game piles
 */

namespace lib;


class TowersPile extends Pile{

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
            'type'              =>  'tbl',
            'title'             =>  'Tableau',
            'maximumCards'      =>  17,
            'sortOrder'         =>  'desc',
            'sameSuit'          =>  1,
            'baseCardRule'      =>  'strict',
            'movableTo'         =>  array('fdn', 'tbl'),
            'cards'             =>  $options['cards'],
            'cardDisplay'       =>  'fanned'
        ));
    }

    /**
     * @Method(
     *  name="createSpecialTableauPile",
     *  description="create special tableau pile"
     * )
     */
    public function createSpecialTableauPile($options = array())
    {
        $pileOptions = array(
            'type'              =>  'tbl',
            'title'             =>  'Sp.Tableau',
            'maximumCards'      =>  1,
            'sortOrder'         =>  'none',
            'sameSuit'          =>  0,
            'baseCardRule'      =>  'none',
            'movableTo'         =>  array('fdn', 'tbl'),
            'cardDisplay'       =>  'fanned'
        );

        if(!empty($options['cards']))
        {
            $pileOptions['cards'] = $options['cards'];
        }

        return $this->create($pileOptions);
    }
} 