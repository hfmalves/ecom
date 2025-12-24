<?php

namespace App\Controllers\Website\User;

use App\Controllers\BaseController;
use App\Models\Admin\Customers\CustomerWishlistModel;

class WishlistController extends BaseController
{
    protected CustomerWishlistModel $wishlist;

    public function __construct()
    {
        $this->wishlist = new CustomerWishlistModel();
    }

    private function customerId(): int
    {
        return session('user.id');
    }

    public function index()
    {
        return view('website/user/account/wishlist', [
            'wishlist' => $this->wishlist
                ->where('customer_id', $this->customerId())
                ->findAll(),
        ]);
    }

    public function add($productId)
    {
        $this->wishlist->insert([
            'customer_id' => $this->customerId(),
            'product_id'  => $productId,
        ]);

        return redirect()->back();
    }

    public function remove($id)
    {
        $this->wishlist
            ->where('id', $id)
            ->where('customer_id', $this->customerId())
            ->delete();

        return redirect()->back();
    }
}
