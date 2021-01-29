{{trans('site.dashboard')}}
<br>
{{ LaravelLocalization::getCurrentLocaleDirection() }}
<br>
{{ LaravelLocalization::getCurrentLocaleName() }}
<br>
{{ LaravelLocalization::getCurrentLocale() }}
<br>
{{ LaravelLocalization::getCurrentLocaleScript() }}

<ul>
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <li>
            <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                {{ $properties['native'] }}
            </a>
        </li>
    @endforeach
</ul>