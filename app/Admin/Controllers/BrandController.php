<?php

namespace App\Admin\Controllers;

use App\Models\Brand;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class BrandController extends AdminController
{
    protected $title = 'Brand';

    protected function grid()
    {
        $grid = new Grid(new Brand());
        $grid->model()->latest();

        $grid->column('image', 'Image')->image('', 150, 150);
        $grid->column('title', __('Title'));
        $grid->column('slug', __('Slug'));
        $grid->column('description', __('Description'));

        return $grid;
    }

    protected function detail($id)
    {
        return new Show(Brand::findOrFail($id));
    }

    protected function form()
    {
        $form = new Form(new Brand());

        $form->text('title', __('Title'));
        $form->text('slug', __('Slug'));
        $form->textarea('description', __('Description'));
        $form->image('image', __('Image'))
            ->move('brand')
            ->uniqueName();
        $form->saving(function (Form $form) {
            if (empty($form->slug)) $form->slug = Str::slug($form->title);
        });

        return $form;
    }
}
