<?php

namespace App\Traits;

trait OrderableTrait
{
    /**
     * Set order by column
     *
     * @param $request
     */
    public function OrderByColumn($request) {
        //get values from cookie
        $order_col  = $request->cookies->get('order_col');
        $order_type  = $request->cookies->get('order_type');
        //set values to request
        $request->attributes->set('order_col', $order_col);
        $request->attributes->set('order_type', $order_type);
    }
}