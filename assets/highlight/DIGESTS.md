## Subresource Integrity

If you are loading Highlight.js via CDN you may wish to use [Subresource Integrity](https://developer.mozilla.org/en-US/docs/Web/Security/Subresource_Integrity) to guarantee that you are using a legimitate build of the library.

To do this you simply need to add the `integrity` attribute for each JavaScript file you download via CDN. These digests are used by the browser to confirm the files downloaded have not been modified.

```html
<script
  src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/highlight.min.js"
  integrity="sha384-pGqTJHE/m20W4oDrfxTVzOutpMhjK3uP/0lReY0Jq/KInpuJSXUnk4WAYbciCLqT"></script>
<!-- including any other grammars you might need to load -->
<script
  src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/languages/go.min.js"
  integrity="sha384-Mtb4EH3R9NMDME1sPQALOYR8KGqwrXAtmc6XGxDd0XaXB23irPKsuET0JjZt5utI"></script>
```

The full list of digests for every file can be found below.

### Digests

```
sha384-BxojDi6ePBYN3unEc6aUEpUtUyx0Eq0i/UZPISuI2YQy6eAD5HzD0dtBC53uZ6R1 /es/languages/php.js
sha384-C28kAnknmyKQUME+2sa0tyQkFMN1S/aUSB1gQ+PKUf0+ewgxNh8CwAmd+C0UUaZ7 /es/languages/php.min.js
sha384-ZykOILPkcS6gVzXO56vF9mLmUbS20XhOnzaf7jxH0c13+7mKElNqtP6YCpBeND6v /es/languages/php-template.js
sha384-xcrjtkX6DU8emOzX0JkgBdUnCB6E5abIF80h1JDwLKDJPzmIJSWyaUELrPg28SsM /es/languages/php-template.min.js
sha384-swGDgtGOmzrsbFAaQRjzvGs0hhe0N86mfHIuisr3W9AT0hiheGyRORSGrbMDGOw5 /languages/php.js
sha384-Xd0AQIkWCEjBL8BNMtDMGVqFXkf445J6PNUJdXbh334ckjeSa90wtSUjXySuz+rt /languages/php.min.js
sha384-2e98DY/C99xqtaiqUR14UMy3FOrroooxZ43kHHlDMdLl45ymAaJ6OgWO1m95lfc5 /languages/php-template.js
sha384-qgAIdznqUzBBAS4nOYdZKnhkSxER8jn7g10EW176MLksxvnQCBcXOdawfqoRb67X /languages/php-template.min.js
sha384-2/Mr0Ku2xluLvXI0wrCPHqOPrKqjxizTHEVQJyfKwQ2EgzlStdlnMEkRcEsS8bMx /highlight.js
sha384-QaTTrsXAdCkauodHvy4y/FwUd799S39MtCNC6yxhfv9SFSrZG8DkEqctbUcewKNF /highlight.min.js
```

