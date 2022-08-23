# WP Ajaxify Settings

Here is the list of all the settings used by this plugin.

| Group | Setting Name | Meta Key | Type | Default | Description |
| --- | --- | --- | --- | --- | --- |
| General | Enable/Disable | _wp_ajaxify_enable | boolean | true | Quickly Enable or Disable Ajaxify on the website. |
| General | Element IDs | _wp_ajaxify_elements | string | body, #wpadminbar | Selector for element IDs that are going to be swapped (e.g. `#page, #wpadminbar`) |
| General | Links Selectors | _wp_ajaxify_selector | string | body a:not(.no-ajaxy) | Selector for links to trigger swapping - not elements to be swapped - i.e. a selection of links (e.g. `#page a:not(.no-ajaxy, a[href*=logout], .ajax_add_to_cart), #outside-page a`) |
| General | Forms Selectors | _wp_ajaxify_forms | string | '' | Selector for ajaxifying forms (e.g. `form:not(.no-ajaxy)`), Leave empty to disable all forms. |
| General | Canonical | _wp_ajaxify_canonical | boolean | false | Fetch current URL from "canonical" link if given, updating the History API. In case of a re-direct. |
| General | Refresh | _wp_ajaxify_refresh | boolean | false | Refresh the page even if link clicked is current page. |
| General | Request Delay | _wp_ajaxify_requestdelay | number | 100 | In Milliseconds - Delay of Pronto request. |
| General | Scroll Top | _wp_ajaxify_scrolltop | string | true | Refresh the page even if link clicked is current page. |
| General | Scroll Delay | _wp_ajaxify_scrolldelay | number | 0 | Minimal delay on all scroll effects in Milliseconds, useful in case of e.g. smooth scroll |
| General | Body Classes | _wp_ajaxify_bodyclasses | boolean | true | Copy body attributes from target page, set to "false" to disable. |
| General | Deltas | _wp_ajaxify_deltas | boolean | true | True = deltas loaded, False = all scripts loaded |
| General | Async | _wp_ajaxify_asyncdef | boolean | false | Default async value for dynamically inserted external scripts, False = synchronous / True = asynchronous |
| General | Always Hints | _wp_ajaxify_alwayshints | string | '' | If matched in any external script URL - these are always loaded on every page load. Leave empty to disable it. |
| General | Inline | _wp_ajaxify_inline | boolean | true | True = all inline scripts loaded, False = only specific inline scripts are loaded. |
| General | Inline Hints | _wp_ajaxify_inlinehints | string | '' | If matched in any inline scripts - only these are executed - set "inline" to false beforehand. Leave empty to disable it. |
| General | Inline Skip | _wp_ajaxify_inlineskip | string | adsbygoogle | If matched in any inline scripts - these are NOT are executed - set "inline" to true beforehand. Leave empty to disable it. |
| General | Inline Append | _wp_ajaxify_inlineappend | boolean | true | Append scripts to the main content element, instead of "eval"-ing them |
| General | Intercept Events | _wp_ajaxify_intevents | boolean | true | Intercept events that are fired only on classic page load and simulate their trigger on ajax page load ("DOMContentLoaded") |
| General | Style | _wp_ajaxify_style | boolean | false | True = all style tags in the head loaded, False = style tags on target page ignored. |
| General | Prefetch Off | _wp_ajaxify_prefetchoff | string | true | Plugin pre-fetches pages on hoverIntent - true = set off completely // strings - separated by ", " - hints to select out. |
| General | Debugging | _wp_ajaxify_verbosity | boolean | false | Enable/Disable logs in console for debugging. |
| General | Passcount | _wp_ajaxify_passcount | boolean | false | Show number of pass for debugging. |
| General | Memory Off | _wp_ajaxify_memoryoff | string | true | Separated by ", " - if matched in any URLs - only these are NOT executed - set to "true" to disable memory completely. |
| Appearance | Loader Enable/Disable | _wp_ajaxify_loader_enable | boolean | true | If you enable Loader, it will appear on each page before Pronto Request. |
| Appearance | Loader Type | _wp_ajaxify_loader_type | string | type-1 | Choose the loader type. If you choose Custom Loader then put your loader HTML in Loader HTML field. |
| Appearance | Loader Html | _wp_ajaxify_loader_html | string | '' | HTML for custom loader. Write CSS for loader separatly in theme files or in WordPress Additional CSS.|
| Appearance | Loader Primary Color | _wp_ajaxify_loader_primary_color | string | #2872fa | Primary color for loader usage. |
| Appearance | Loader Overlay Color | _wp_ajaxify_loader_overlay_color | string | #000000 | Overlay background color for loader usage. |
| Appearance | Loader Overlay Opacity | _wp_ajaxify_loader_overlay_opacity | number | 0.45 | Control the overlay opacity. |
| Misc | CDN Url | _wp_ajaxify_cdn_url | string | '' | If you want to use or test a different version of ajaxify.js then you can use a CDN or External url here to be load in frontend. |
| Misc | Uninstall | _wp_ajaxify_uninstall | boolean | false | Remove ALL WP Ajaxify data upon plugin deletion. All settings will be unrecoverable. |

## Settings Explanation

Below you'll find detailed information on each settings that will help you find the best settings for you theme and plugins that you're using with your WordPress website.
