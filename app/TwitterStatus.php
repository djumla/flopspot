<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterStatus extends Model
{
    protected $table = 'tweet_statuses';

    protected $fillable = [
        'status_id',
        'status_author',
        'author_poked',
        'poked_date'
    ];

    /**
     * Get only authors who has not been poked yet.
     *
     * @return mixed
     */
    public function getNotPoked()
    {
        return $this->select('status_id', 'status_author')
            ->where('author_poked', '=', '0')
            ->get();
    }

    /**
     * @return mixed
     */
    public function deletePokedStatusEveryMonth()
    {
        return $this->where('author_poked', '=', '1')
            ->whereRaw('DATEDIFF( NOW(), poked_date ) > 30')
            ->delete();
    }

    /**
     * Set poked to 1(true) so he won't get poked again
     *
     * @param string $author
     *
     * @return mixed
     */
    public function updateStatus($author)
    {
        return $this->where('status_author', '=', $author)
            ->update([
                'author_poked' => 1,
                'poked_date' => date("Y-m-d")
            ]);
    }

    /**
     * Check if the author has already been registered
     *
     * @param string $author
     *
     * @return mixed
     */
    public function checkIfUserRegistered($author)
    {
        return $this->where('status_author', '=', $author)
            ->get();
    }
}
