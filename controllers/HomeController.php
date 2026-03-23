<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/../models/gericht.php');

class HomeController
{
    public function index(RequestData $request) {
        logger()->info('Zugriff auf Hauptseite');
        $gerichte = db_gericht_select_for_homepage();
        $anzahl = count($gerichte);
        return view('home', [
            'gerichte' => $gerichte,
            'anzahl' => $anzahl,
            'rd' => $request
        ]);
    }
    
    public function debug(RequestData $request) {
        return view('debug');
    }
}
