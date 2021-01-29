<?php

use App\ManagementPage;
use CodeItNow\BarcodeBundle\Utils\QrCode;

use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

if (!function_exists('barcode')) {
    function barcode($text)
    {

        $barcode = new BarcodeGenerator();
        $barcode->setText("$text");
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setScale(2);
        $barcode->setThickness(25);
        $barcode->setFontSize(20);
        return $code = $barcode->generate();
    }
}


if (!function_exists('qrCode')) {
    function qrCode($text)
    {
        $qrCode = new QrCode();
        return $qrCode
            ->setText("$text")
            ->setSize(70)
            ->setPadding(10)
            ->setErrorCorrection('high')
            ->setForegroundColor(array('r' => 0, 'g' => 100, 'b' => 100, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            ->setLabel("$text")
            ->setLabelFontSize(20)
            ->setImageType(QrCode::IMAGE_TYPE_PNG);
    }
}


if (!function_exists('isError')) {
    function isError($errors, $name)
    {
        if ($errors->has($name)) {
            return   '<span class="focus-input100" data-placeholder="&#xf207;" role="alert"></span>' .
                '<strong style="color: red;font-size: larger;">' . $errors->first($name) . '</strong>';
        }
    }
}

if (!function_exists('pages')) {

    function pages()
    {
        $pages = App\ManagementPage::where('type', 1)->orWhere('type', 4)->get();

        foreach ($pages as $page) {
            if ($page->type == 1) {
                echo '<li class="treeview li_' . $page->id . '">';
                echo    '<a href="' . $page->route . '">
                            <i class="' . $page->fa_icon . '"></i>
                            <span>' . $page->name . '</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>';
                subpages($page);
                echo '</li>';
            } else {
                $class = (Route::currentRouteName() == $page->route) ? 'active' : '';

                echo    '<li class="' . $class . '" ><a href="' . route($page->route) . '"><i class="' . $page->fa_icon . '"></i> ' . $page->name . '</a></li>';
            }
        }


        //dd($pages);
    }
}
if (!function_exists('subpages')) {

    function subpages($page)
    {
        echo '<ul class="treeview-menu ui_' . $page->id . '" style="display: none;">';
        foreach ($page->pages as $p) {
            if ($p->type == 2) {
                echo '<li class="treeview " >';
                echo    '<a href="' . $p->route . '">
                            <i class="' . $p->fa_icon . '"></i>
                            <span>' . $p->name . '</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>';
                // $ps = App\ManagementPage::where('management_page_id', $p->id)->get();
                subpages($p);
                echo '</li>';
            } else {
                $class = (Route::currentRouteName() == $p->route) ? 'active' : '';

                echo    '<li   class="' . $class . '" ><a href="' . route($p->route) . '" ><i class="' . $p->fa_icon . '"></i> ' . $p->name . '</a></li>';
            }
        }
        echo '</ul>';
    }
}
