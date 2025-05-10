<?php

if (!function_exists('buildTreeCategory')) {
    function buildTreeCategory($categories, $parentId = null): array
    {
        $tree = [];

        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $category->makeHidden('created_at', 'updated_at', 'parent_id');

                $children = buildTreeCategory($categories, $category->id);

                if ($children) {
                    $category->children = $children;
                } else {
                    $category->children = [];
                }

                $tree[] = $category;
            }
        }

        return $tree;
    }
}
