<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\CartModel;

class CartApi extends BaseController
{
    /* ADD TO CART */
    public function add()
    {
        $user = $this->request->user; // JWT filter se aata hai
        $fertilizer_id = $this->request->getPost('fertilizer_id');

        $cartModel = new CartModel();

        $existing = $cartModel
            ->where('user_id', $user->uid)   // ✅ FIX
            ->where('fertilizer_id', $fertilizer_id)
            ->first();

        if ($existing) {
            $cartModel->update($existing['id'], [
                'qty' => $existing['qty'] + 1
            ]);
        } else {
            $cartModel->insert([
                'user_id'       => $user->uid,   // ✅ FIX
                'fertilizer_id' => $fertilizer_id,
                'qty'           => 1
            ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Added to cart'
        ]);
    }

    /* CART LIST */
    public function list()
    {
        $user = $this->request->user;

        $cartModel = new CartModel();

        $data = $cartModel
            ->select('cart.id, fertilizers.name, fertilizers.price, fertilizers.image, cart.qty')
            ->join('fertilizers', 'fertilizers.id = cart.fertilizer_id')
            ->where('cart.user_id', $user->uid)   // ✅ FIX
            ->findAll();

        return $this->response->setJSON(['data' => $data]);
    }

    /* CART COUNT */
    public function count()
    {
        $user = $this->request->user;

        $cartModel = new CartModel();

        $count = $cartModel
            ->where('user_id', $user->uid)   // ✅ FIX
            ->countAllResults();

        return $this->response->setJSON(['count' => $count]);
    }

    /* REMOVE */
    public function remove($id)
    {
        $cartModel = new CartModel();
        $cartModel->delete($id);

        return $this->response->setJSON(['status' => true]);
    }
}
