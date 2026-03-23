<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/../models/kategorie.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/gericht.php');


class ExampleController
{
    public function m4_6a_queryparameter(RequestData $rd) {
        return view('notimplemented', [
            'request'=>$rd,
            'url' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"
        ]);
    }
    // Aufgabe 7a: Query-Parameter
    public function m4_7a_queryparameter(RequestData $rd) {
        $name = $rd->query['name'] ?? 'Gast';
        return view('examples.m4_7a_queryparameter', [
            'name' => $name
        ]);
    }
    // Aufgabe 7b
    public function m4_7b_kategorie(RequestData $rd) {
        $kategorien = db_kategorie_select_all();
        return view('examples.m4_7b_kategorie', [
            'kategorien' => $kategorien
        ]);
    }
    // Aufgabe 7c
    public function m4_7c_gerichte(RequestData $rd) {
        $gerichte = db_gericht_select_expensive();
        return view('examples.m4_7c_gerichte', [
            'gerichte' => $gerichte
        ]);
    }

    // Aufgabe 7d
    public function m4_7d_layout(RequestData $rd) {
        $no = $rd->query['no'] ?? '1';
        if ($no == '2') {
            $page = 'examples.pages.m4_7d_page_2';
            $title = 'Layout Demo - Seite 2';
        } else {
            $page = 'examples.pages.m4_7d_page_1';
            $title = 'Layout Demo - Seite 1';
        }
        return view($page, ['title' => $title]);
    }
}
