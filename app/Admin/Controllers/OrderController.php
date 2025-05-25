<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use Illuminate\Support\Facades\Storage;

class OrderController extends AdminController
{
    protected $title = 'Order';

    protected function grid()
    {
        $grid = new Grid(new Order());
        $grid->model()->latest();

        $grid->column('invoiceReceipt', __('Invoice receipt'))->modal('products', function ($model) {
            $product = $model->products()->get()->map(function ($product) {
                return [
                    'image' => '<img src="' . Storage::disk('public')->url($product->image) . '" width="150" height="150" />',
                    'title' => $product->title,
                    'price' => $product->price,
                    'discount' => $product->discount ?? 0,
                    'quantity' => $product->pivot->quantity ?? null,
                ];
            });

            return new Table(['image', 'title', 'price', 'discount', 'quantity'], $product->toArray());
        });

        $grid->column('user.name', __('Name'))->modal('address', function ($model) {
            $address = $model->address()->get()->map(function ($address) {
                return [
                    'address_line' => $address->address_line,
                    'city'=> $address->city,
                    'state'=> $address->state,
                    'pincode'=> $address->pincode,
                    'country'=> $address->country,
                    'mobile'=> $address->mobile,
                ];
            });

            return new Table(['address line', 'city', 'state', 'pin code', 'country', 'mobile'], $address->toArray());
        });

        $grid->column('paymentMethod', __('Payment method'));
        $grid->column('subTotalAmt', __('Sub total amount'));
        $grid->column('totalAmt', __('Total amount'));

        return $grid;
    }

    protected function detail($id)
    {
        return new Show(Order::findOrFail($id));
    }

    protected function form()
    {
        return new Form(new Order());
    }
}
