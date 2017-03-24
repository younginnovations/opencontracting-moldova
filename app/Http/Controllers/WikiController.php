<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WikiController extends Controller {

    var $baseWikiUrlEn;

    public function __construct()
    {
       $this->baseWikiUrlEn = getenv('WIKI_REPO_EN');
    }

    public function index(){
        $link = $this->baseWikiUrlEn.'user-manual.md';
        return view('wiki.index', compact('link'));
    }
    /**
     * Get wiki page from github wiki
     */
    public function getWiki(Request $request, $title){
        $link = $this->baseWikiUrlEn.strtolower($title).'.md';
        return view('wiki.index', compact('link'));
    }
}
?>
