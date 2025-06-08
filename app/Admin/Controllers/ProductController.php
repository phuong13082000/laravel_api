<?php

namespace App\Admin\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class ProductController extends AdminController
{
    protected $title = 'Product';

    protected function grid()
    {
        $grid = new Grid(new Product());
        $grid->model()->latest();

        $grid->column('image', 'Image')->image('', 150, 150);
        $grid->column('title', __('Title'));
        $grid->column('category.title', __('Category'))->badge('gray');
        $grid->column('brand.title', __('Brand'))->badge('gray');
        $grid->column('price', __('Price'));
        $grid->column('discount', __('Discount'));
        $grid->column('stock', __('Stock'));
        $grid->column('publish', __('Status'))->switch([
            'on' => ['value' => 1, 'text' => 'on', 'color' => 'primary'],
            'off' => ['value' => 2, 'text' => 'off', 'color' => 'default'],
        ]);

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Product::findOrFail($id));

        $show->field('id', 'id');
        $show->field('title', 'title');
        $show->field('slug', 'slug');
        $show->field('image', 'image');
        $show->field('category_id', 'category id');
        $show->field('brand_id', 'brand id');
        $show->field('unit', 'unit');
        $show->field('price', 'price');
        $show->field('stock', 'stock');
        $show->field('discount', 'discount');
        $show->field('description', 'description');
        $show->field('tags', 'tag')->json();
        $show->field('publish', 'publish');
        $show->field('more_details', 'more details')->json();
        $show->field('created_at', 'created at');
        $show->field('updated_at', 'updated at');

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Product());

        $form->text('title', __('Title'));
        $form->text('slug', __('Slug'));
        $form->image('image', __('Image'))->move('product')->uniqueName();
        $form->select('category_id', 'Category')->options(Category::all()->pluck('title', 'id'));
        $form->select('brand_id', 'Brand')->options(Brand::all()->pluck('title', 'id'));
        $form->text('unit', __('Unit'));
        $form->number('stock', __('Stock'))->default(0)->min(0);
        $form->number('price', __('Price'))->default(0)->min(0);
        $form->number('discount', __('Discount'))->default(0)->min(0)->max(100);
        $form->textarea('description', __('Description'));
        $form->multipleSelect('tags','Tag')->options(Tag::all()->pluck('title','id'));
        $form->keyValue('more_details', __('More details'));
        $form->switch('publish', __('Publish'))->default(true);
        $form->saving(function (Form $form) {
            if (empty($form->slug) && !empty($form->title)) $form->slug = Str::slug($form->title);
        });

        return $form;
    }
}
