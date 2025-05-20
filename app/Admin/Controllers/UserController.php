<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    protected $title = 'User';

    protected function grid()
    {
        $grid = new Grid(new User());
        $grid->model()->latest();

        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('email_verified_at', __('Email verified at'));
        $grid->column('role', __('Role'))->badge();
        $grid->column('status', __('Status'))->badge('blue');

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', 'id');
        $show->field('name', 'title');
        $show->field('email', 'email');
        $show->field('email_verified_at', 'email verified at');
        $show->field('role', 'role');
        $show->field('status', 'status');
        $show->field('created_at', 'created at');
        $show->field('updated_at', 'updated at');

        $show->addresses('Address', function ($address) {
            $address->id();
            $address->address_line();
            $address->city();
            $address->state();
            $address->pincode();
            $address->country();
            $address->mobile();
            $address->status();
            $address->created_at()->display(function ($value) {
                return Carbon::parse($value)->format('H:i d-m-y');
            });
            $address->updated_at()->display(function ($value) {
                return Carbon::parse($value)->format('H:i d-m-y');
            });
        });

        $show->carts('Carts', function ($cart) {
            $cart->product()->title();
            $cart->product()->price();
            $cart->product()->discount();
            $cart->quantity();
            $cart->created_at()->display(function ($value) {
                return Carbon::parse($value)->format('H:i d-m-y');
            });
            $cart->updated_at()->display(function ($value) {
                return Carbon::parse($value)->format('H:i d-m-y');
            });
        });

        $show->orders('Orders', function ($order) {
            $order->address()->id();
            $order->paymentMethod()->badge('green');
            $order->subTotalAmt();
            $order->totalAmt();
            $order->invoiceReceipt();
            $order->created_at()->display(function ($value) {
                return Carbon::parse($value)->format('H:i d-m-y');
            });
            $order->updated_at()->display(function ($value) {
                return Carbon::parse($value)->format('H:i d-m-y');
            });
        });

        $show->payments('Payments', function ($payment) {
            $payment->stripe_id()->limit(20);
            $payment->amount();
            $payment->currency()->badge();
            $payment->status()->badge(['paid' => 'gray', 'open' => 'blue', 'cancelled' => 'red']);
            $payment->description();
            $payment->checkout_url()->limit(20);
            $payment->created_at()->display(function ($value) {
                return Carbon::parse($value)->format('H:i d-m-y');
            });
            $payment->updated_at()->display(function ($value) {
                return Carbon::parse($value)->format('H:i d-m-y');
            });
        });

        return $show;
    }

    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->text('status', __('Status'));

        return $form;
    }
}
