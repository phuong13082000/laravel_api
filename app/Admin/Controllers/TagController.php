<?php

namespace App\Admin\Controllers;

use App\Models\Tag;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class TagController extends AdminController
{
    protected $title = 'Tag';

    protected function grid()
    {
        $grid = new Grid(new Tag());
        $grid->model()->latest();

        $grid->column('title', __('Title'));
        $grid->column('slug', __('Slug'));
        $grid->column('description', __('Description'));

        return $grid;
    }

    protected function detail($id)
    {
        return new Show(Tag::findOrFail($id));
    }

    protected function form()
    {
        $form = new Form(new Tag());

        $form->text('title', __('Title'));
        $form->text('slug', __('Slug'));
        $form->textarea('description', __('Description'));
        $form->saving(function (Form $form) {
            if (empty($form->slug)) $form->slug = Str::slug($form->title);
        });

        return $form;
    }
}
