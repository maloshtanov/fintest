<?php

/**
 * @param int|float  $price
 * @return string
 */
function price_format($price)
{
    return number_format($price, 2, ',' , '.');
}

/**
 * @param DateTime $date
 * @return string
 */
function dt_format(DateTime $date)
{
    return $date->format('d.m.Y H:i (T, P)');
}
