<?php

namespace App\Http\ViewCompose;


use Illuminate\Contracts\View\View;

class MetaTagComposer
{
    /**
     * MetaTagComposer constructor.
     */
    public function __construct()
    {
        $this->tags = config('metatag.tags');
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $viewPage = explode('.',$view->name());

        switch($viewPage[0]){
        case "index":
                $metaTags = $this->tags['home'];
                break;
            case "tender":
                $metaTags = $this->tags['tenders'];
                break;
            case "about":
                $metaTags = $this->tags['about'];
                break;
            case "contracts":
                $metaTags = $this->tags['contracts'];
                break;
            case "agency":
                $metaTags = $this->tags['agencies'];
                break;
            case "goods":
                $metaTags = $this->tags['goods'];
                break;
            case "contact":
                $metaTags = $this->tags['contact'];
                break;
            default:
                $metaTags = $this->tags['home'];
        }

        $view->with('metaTag',$metaTags);

    }
}