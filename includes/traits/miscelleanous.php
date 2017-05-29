<?php

/*
 * Traits divers
 */

trait frenchDates
{
    /* formatte une date MySql au format FR */
    function frenchDate(string $date)
    {
        $fr_date = explode('-', $date);
        $fr_date = $fr_date[2] . '/' . $fr_date[1] . '/' . $fr_date[0];
        return $fr_date;
    }
}
