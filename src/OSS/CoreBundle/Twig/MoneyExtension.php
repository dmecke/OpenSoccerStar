<?php

namespace OSS\CoreBundle\Twig;

class MoneyExtension extends \Twig_Extension
{
    /**
     * @return \Twig_SimpleFilter
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
        return 'oss.core.money_extension';
    }
}
