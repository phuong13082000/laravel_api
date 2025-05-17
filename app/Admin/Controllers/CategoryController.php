<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class CategoryController extends AdminController
{
    protected $title = 'Category';

    protected function grid()
    {
        $grid = new Grid(new Category());
        $grid->model()->latest();

        $grid->column('id', __('Id'));
        $grid->column('image', 'Image')->image('', 150, 150);
        $grid->column('title', __('Title'));
        $grid->column('slug', __('Slug'));
        $grid->column('icon', __('Icon'));
        $grid->column('color', __('Color'));
        $grid->column('description', __('Description'));
        $grid->column('parent.title', __('Parent'));

        return $grid;
    }

    protected function detail($id)
    {
        return new Show(Category::findOrFail($id));
    }

    protected function form()
    {
        $form = new Form(new Category());

        $form->text('title', __('Title'));
        $form->text('slug', __('Slug'));
        $form->text('icon', __('Icon'));
        $form->text('color', __('Color'));
        $form->textarea('description', __('Description'));
        $form->image('image', __('Image'))
            ->move('category')
            ->uniqueName();
        $form->select('parent_id', 'Parent')
            ->options(Category::all()->pluck('title', 'id'));
        $form->saving(function (Form $form) {
            if (empty($form->slug)) {
                $form->slug = Str::slug($form->title);
            }
        });

        return $form;
    }
}
