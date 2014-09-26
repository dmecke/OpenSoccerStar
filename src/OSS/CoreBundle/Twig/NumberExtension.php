<?php

namespace OSS\CoreBundle\Twig;

class NumberExtension extends \Twig_Extension
{
    /**
     * @return \Twig_SimpleFilter
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('money', array($this, 'moneyFilter')),
            new \Twig_SimpleFilter('signed', array($this, 'signedFilter')),
            new \Twig_SimpleFilter('cssClass', array($this, 'cssClassFilter')),
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
     * @param int $amount
     *
     * @return string
     */
    public function signedFilter($amount)
    {
        if ($amount > 0) {
            return '+' . $amount;
        } else {
            return (string) $amount;
        }
    }

    /**
     * @param int $amount
     *
     * @return string
     */
    public function cssClassFilter($amount)
    {
        if ($amount > 0) {
            return 'plus';
        } elseif ($amount < 0) {
            return 'minus';
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oss.core.number';
    }
}
