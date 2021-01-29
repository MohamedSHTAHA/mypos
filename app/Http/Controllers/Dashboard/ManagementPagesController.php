<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ManagementPage;
use Illuminate\Support\Facades\Route;

class ManagementPagesController extends Controller
{
    public function index()
    {
        $pages = ManagementPage::where('type', 1)->orWhere('type', 4)->get();

        foreach ($pages as $page) {
            echo '<li class="treeview">';
            if ($page->type == 1) {
                echo    '<a href="' . $page->route . '">
                        <i class="' . $page->fa_icon . '"></i>
                        <span>' . $page->name . '</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>';
                $this->submain($page);
            } else {
                echo    '<a href="' . $page->route . '">
                            <i class="' . $page->fa_icon . '"></i>
                            <span>' . $page->name . '</span>
                        </a>';
            }
            echo '</li>';
        }


        //dd($pages);
    }

    public function submain($page)
    {
        echo '<ul class="treeview-menu" style="display: none;">';
        foreach ($page->pages as $p) {
            //echo $p->id . '-----' . $p->management_page_id . '------' . $p->name . '<br>';
            if ($p->type == 2) {
                echo    '<a href="' . $p->route . '">
                            <i class="' . $p->fa_icon . '"></i>
                            <span>' . $p->name . '</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>';
                $ps = ManagementPage::where('management_page_id', $p->id)->get();
                foreach ($ps as $ppp) {
                    echo $ppp->id . '+++' . $ppp->management_page_id . '+++' . $ppp->name . '<br>';
                    if ($ppp->type == 2) {
                        $this->submain($ppp);
                    }
                }
            } else {
                echo    '<a href="' . $p->route . '">
                            <i class="' . $p->fa_icon . '"></i>
                            <span>' . $p->name . '</span>
                        </a>';
            }
        }
        echo '</ul>';
    }

    public function create()
    {
        $routes = Route::getRoutes(); //$app->routes->getRoutes(); //
        $management_page_ids = ManagementPage::where('type', 1)->orWhere('type', 2)->get();
        //dd($management_page_ids);
        return view('dashboard.managementPages.create', compact('routes', 'management_page_ids'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'type' => 'required|numeric|in:1,2,3,4',
            'status' => 'required|in:open,close',
            //'sorted' => 'required|numeric',
            'fa_icon' => 'required',
        ];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => 'required|min:3',];
            $rules += [$locale . '.description' => 'required|min:3',];
        } //end of for each


        if (request('type') == 2 || request('type') == 3) {
            $rules += ['management_page_id' => 'required|numeric|in:' . str_replace([']', '['], ',', ManagementPage::pluck('id'))];
        }

        if (request('type') == 1 || request('type') == 2) {
            $rules += ['permission' => 'sometimes|required|regex:/^[A-Za-z-_]+$/|unique:management_pages'];
        } else {
            $rules += ['route' => 'required'];
        }
        //dd($rules);


        $request->validate($rules);

        $ManagementPage = ManagementPage::Create($request->all());

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.managementPages.create');
    }
}
