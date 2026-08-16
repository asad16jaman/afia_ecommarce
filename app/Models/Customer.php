<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable{
    use HasFactory;

    protected $table = 'tbl_customer';
    public $timestamps = false;
    protected $primaryKey = 'Customer_SlNo';
    // protected $fillable = [
    //     'Customer_Name',
    //     'Customer_Mobile',
    //     'Customer_Address',
    //     'Password',
    //     'district_id',
    //     'thana_id',
    //     'area_id',
    // ];

    protected $guarded = [] ;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // protected function casts(): array
    // {
    //     return [
    //         'password' => 'hashed',
    //     ];
    // }


}