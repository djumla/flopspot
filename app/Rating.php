<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';

    protected $fillable = [
      'entrance',
      'exit',
      'trainNumber',
      'date',
      'rating'
    ];

    /**
     * @param $start
     * @param $end
     *
     * @return array
     */
    public function getCombinedRatings($start, $end)
    {
        $insufficient = $this->select('rating')
            ->whereMonth('created_at', '>', $start, 'and', '<', $end)
            ->where('rating', '=', 1)
            ->count();
        
        $satisfying = $this->select('rating')
            ->whereMonth('created_at', '>', $start, 'and', '<', $end)
            ->where('rating', '=', 2)
            ->count();
        
        $satisfactory = $this->select('rating')
            ->whereMonth('created_at', '>', $start, 'and', '<', $end)
            ->where('rating', '=', 3)
            ->count();

        /**
         * Every value in $ratings has a specific key. (insufficient => $insufficient)
         * This is done because this data will be used to generate charts with chart.js
         * To figure out which part of the value will be represented on the chart, every value has a key to identify.
         */
        $ratings = array("insufficient" => $insufficient, "satisfying" => $satisfying, "satisfactory" => $satisfactory);

        return $ratings;
    }
}
