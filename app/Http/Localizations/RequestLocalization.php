<?php

namespace App\Http\Localizations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

trait RequestLocalization
{   
    protected function getLocale(Request $request): ?string
    {
        return $request->get('locale') ?? Config::get('app.locale');
    }

    protected function translate(string $key, string $locale, array $data=[]): ?string
    {
        $translation = __($key, $data, $locale);

        if (! $translation) {
            $translation = __($key, $data, $this->getLocale());
        }

        return $translation;
    }
}
