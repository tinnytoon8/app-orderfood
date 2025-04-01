<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Search;

class Menu extends Model
{
    //
    use HasFactory;
    use Search;

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'price_afterdiscount',
        'percent',
        'is_promo',
        'categories_id'
    ];

    protected $searchable = ['name', 'description'];

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public function getAllMenu()
    {
        return DB::table('menus')
            ->leftJoin('transaction_items', 'menus.id', '=', 'transaction_items.menus_id')
            ->select('menus.*', DB::raw('COALESCE(SUM(transaction_items.quantity), 0) as total_sold'))
            ->groupBy('menus.id')
            ->get();
    }

    public function getMenuDetails($id)
    {
        return DB::table('menus')
            ->leftJoin('transaction_items', 'menus.id', '=', 'transaction_items.menus_id')
            ->select('menus.*', DB::raw('COALESCE(SUM(transaction_items.quantity), 0) as total_sold'))
            ->where('menus.id', $id)
            ->groupBy('menus.id')
            ->get();
    }

    public function getPromo()
    {
        return DB::table('menus')
            ->leftJoin('transaction_items', 'menus.id', '=', 'transaction_items.menus_id')
            ->select('menus.*', DB::raw('COALESCE(SUM(transaction_items.quantity), 0) as total_sold'))
            ->where('menus.is_promo', 1)
            ->groupBy('menus.id')
            ->get();
    }

    public function getFavoriteMenu()
    {
        return TransactionItems::select(
            'menus.*',
            DB::raw('SUM(transaction_items.quantity) as total_sold') 
        )
        ->join('menus', 'transaction_items.menus_id', '=', 'menus.id')
        ->groupBy('menus.id')
        ->orderByDesc('total_sold')
        ->get();
    }
}
