<?php
namespace MicroweberPackages\Invoice;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    public $timestamps = false;
    protected $fillable = ['code','name','phonecode'];

    public function address()
    {
        return $this->hasMany(Address::class);
    }
}
