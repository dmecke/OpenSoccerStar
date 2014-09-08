<?php

namespace OSS\LeagueBundle\Twig;

class MoneyExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('money', array($this, 'moneyFilter')),
        );
    }

    /**
     * @param int $amount
     *
     * @return string
     */
    public function moneyFilter($amount)
    {
        return number_format($amount, 0, ',', '.') . '$';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oss.league.money_extension';
    }
}
