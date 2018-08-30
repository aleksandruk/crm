<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disposition extends Model
{
    protected $table = 'dispositions';
    protected $fillable = ['num_fak', 'nr_rach', 'client', 'comment', 'seats_amount', 'priority', 'stock_time', 'stock_id', 'driver_time', 'driver_id', 'report', 'report_time', 'status', 'archive'];
    protected $casts = [
        'report' => 'array',
    ];

    public function adminUser()
  {
    return $this->belongsTo('App\User', 'stock_id');
  }

  public function adminDriver()
  {
    return $this->belongsTo('App\User', 'driver_id');
  }

  public function storekeeper()
  {
    return $this->belongsTo('App\Storekeeper', 'stock_id');
  }

  public function driver()
  {
    return $this->belongsTo('App\Storekeeper', 'driver_id');
  }
}
