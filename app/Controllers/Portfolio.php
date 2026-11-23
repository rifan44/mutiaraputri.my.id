<?php

namespace App\Controllers;

use App\Libraries\PortfolioData;

class Portfolio extends BaseController
{
    public function index(string $locale = 'id'): string
    {
        if (! in_array($locale, ['id', 'en'], true)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('portfolio/home', [
            ...PortfolioData::load(),
            'locale' => $locale,
        ]);
    }
}
