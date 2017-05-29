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
        $link = $this->baseWikiUrlEn.'Home.md';
        return view('wiki.index', compact('link'));
    }
    /**
     * Get wiki page from github wiki
     */
    public function getWiki(Request $request, $title){
        //set proper format for title
        $title = explode('-', $title);
        foreach ($title as &$row) {
            $row = ucfirst($row);
        }
        $title = implode("-", $title);
        $link = $this->baseWikiUrlEn.$title.'.md';
        return view('wiki.index', compact('link'));
    }
}
?>
