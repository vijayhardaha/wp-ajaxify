# WP Ajaxify Settings

Here is the list of all the settings used by WP Ajaxify plugin.

| Name             | Key                                  | Type    | Default          | Description                    |
| :--------------- | :----------------------------------- | :------ | :--------------- | :----------------------------- |
| Enable Ajaxify   | `_wp_ajaxify_enable`                 | boolean | true             | [Read Here](#enable-ajaxify)   |
| Element IDs      | `_wp_ajaxify_elements`               | string  | body             | [Read Here](#element-ids)      |
| Links Selectors  | `_wp_ajaxify_selector`               | string  | a:not(.no-ajaxy) | [Read Here](#links-selectors)  |
| Forms Selectors  | `_wp_ajaxify_forms`                  | string  | _null_           | [Read Here](#forms-selectors)  |
| Canonical        | `_wp_ajaxify_canonical`              | boolean | false            | [Read Here](#canonical)        |
| Refresh          | `_wp_ajaxify_refresh`                | boolean | false            | [Read Here](#refresh)          |
| Request Delay    | `_wp_ajaxify_requestdelay`           | number  | 100              | [Read Here](#request-delay)    |
| Scroll Top       | `_wp_ajaxify_scrolltop`              | string  | true             | [Read Here](#scroll-top)       |
| Scroll Delay     | `_wp_ajaxify_scrolldelay`            | number  | 0                | [Read Here](#scroll-delay)     |
| Body Classes     | `_wp_ajaxify_bodyclasses`            | boolean | true             | [Read Here](#body-classes)     |
| Deltas           | `_wp_ajaxify_deltas`                 | boolean | true             | [Read Here](#deltas)           |
| Async            | `_wp_ajaxify_asyncdef`               | boolean | false            | [Read Here](#async)            |
| Always Hints     | `_wp_ajaxify_alwayshints`            | string  | _null_           | [Read Here](#always-hints)     |
| Inline           | `_wp_ajaxify_inline`                 | boolean | true             | [Read Here](#inline)           |
| Inline Hints     | `_wp_ajaxify_inlinehints`            | string  | _null_           | [Read Here](#inline-hints)     |
| Inline Skip      | `_wp_ajaxify_inlineskip`             | string  | adsbygoogle      | [Read Here](#inline-skip)      |
| Inline Append    | `_wp_ajaxify_inlineappend`           | boolean | true             | [Read Here](#inline-append)    |
| Intercept Events | `_wp_ajaxify_intevents`              | boolean | true             | [Read Here](#intercept-events) |
| Style            | `_wp_ajaxify_style`                  | boolean | false            | [Read Here](#style)            |
| Prefetch Off     | `_wp_ajaxify_prefetchoff`            | string  | true             | [Read Here](#prefetch-off)     |
| Debugging        | `_wp_ajaxify_verbosity`              | boolean | false            | [Read Here](#debugging)        |
| Passcount        | `_wp_ajaxify_passcount`              | boolean | false            | [Read Here](#passcount)        |
| Memory Off       | `_wp_ajaxify_memoryoff`              | string  | true             | [Read Here](#memory-off)       |
| Enable Loader    | `_wp_ajaxify_loader_enable`          | boolean | true             | [Read Here](#enable-loader)    |
| Loader Type      | `_wp_ajaxify_loader_type`            | string  | type-1           | [Read Here](#loader-type)      |
| Loader Html      | `_wp_ajaxify_loader_html`            | string  | _null_           | [Read Here](#loader-html)      |
| Primary Color    | `_wp_ajaxify_loader_primary_color`   | string  | #2872fa          | [Read Here](#primary-color)    |
| Overlay Color    | `_wp_ajaxify_loader_overlay_color`   | string  | #000000          | [Read Here](#overlay-color)    |
| Overlay Opacity  | `_wp_ajaxify_loader_overlay_opacity` | number  | 0.45             | [Read Here](#overlay-opacity)  |
| Ajaxify JS URL   | `_wp_ajaxify_cdn_url`                | string  | _null_           | [Read Here](#cajaxify-js-url)  |
| Uninstall        | `_wp_ajaxify_uninstall`              | boolean | false            | [Read Here](#uninstall)        |

---

## Detailed description of Settings

Below you'll find detailed information on each settings that will help you find the best settings for you theme and plugins that you're using with your WordPress website.

### Enable Ajaxify

```
Setting Key     : _wp_ajaxify_enable
Setting Type    : boolean
Default Value   : true
Allowed Values  : true || false
```

You can enable or disable the WP Ajaxify on frontend using this settings.

---

### Element IDs

```
Setting Key     : _wp_ajaxify_elements
Setting Type    : string
Default Value   : body
Allowed Values  : CSS selectors string
```

In this setting, You have to put Selector for element IDs that are going to be swapped (e.g. `#page, #wpadminbar`).

This means if you put `#page, #wpadminbar` in this setting, only content inside `#page` & `#wpadminbar` will be swapped after Ajaxify render is completed.

When `body` is used as a value, it will swap all the body content. But using `body` could bring some conflicts in WordPress in some cases, in those cases, you can choose the different selectors.

To know more about it, See [ID selection](https://4nf.org/interface/#idselection) page.

---

### Links Selectors

```
Setting Key     : _wp_ajaxify_selector
Setting Type    : string
Default Value   : body a:not(.no-ajaxy)
Allowed Values  : CSS selectors string
```

In this setting, you have to put Selector for links to trigger swapping - not elements to be swapped - i.e. a selection of links (e.g. `#page a:not(.no-ajaxy, a[href*=logout])`).

This means we have to define in which links click Ajaxify should trigger swapping. Using the CSS selectors, we can easily disable the Ajaxify trigger on various links on pages.

In above example, links inside `#page` ID content without `no-ajaxy` CSS class or not containing `logout` keyword in url will trigger the Ajaxify.

---

### Forms Selectors

```
Setting Key     : _wp_ajaxify_forms
Setting Type    : string
Default Value   : null
Allowed Values  : CSS selectors string
```

In this setting, you have to put Selector for ajaxifying forms (e.g. `form:not(.no-ajaxy)`).

This is similar to the above setting but here we target `form` tags.

We should keep it disabled for all the forms in WordPress, to do that you can leave this field empty.

---

### Canonical

```
Setting Key     : _wp_ajaxify_canonical
Setting Type    : boolean
Default Value   : false
Allowed Values  : true || false
```

In this setting, You can choose to Fetch current URL from "canonical" link if given, updating the History API. In case of a re-direct.

---

### Refresh

```
Setting Key     : _wp_ajaxify_refresh
Setting Type    : boolean
Default Value   : false
Allowed Values  : true || false
```

In this setting, You can choose to Refresh the page even if link clicked is current page.

---

### Request Delay

```
Setting Key     : _wp_ajaxify_requestdelay
Setting Type    : number
Default Value   : 100
Allowed Values  : 0 || Any positive integer with increment range 100
```

From this setting, you can add a delay(in Milliseconds) on the Pronto request. If you are keeping loader enabled then you should keep this value higher than 0.

---

### Scroll Top

```
Setting Key     : _wp_ajaxify_scrolltop
Setting Type    : string
Default Value   : true
Allowed Values  : s || true || false
```

From this setting, you can enable or disable the scroll top feature or can set Smooth scroll. When you have scroll enabled each page will be scrolled back to the top after rendering.

To know more about it, See [Scroll](https://4nf.org/scroll/) page.

---

### Scroll Delay

```
Setting Key     : _wp_ajaxify_scrolldelay
Setting Type    : number
Default Value   : 0
Allowed Values  : 0 || Any positive integer with increment range 100
```

From this setting, you can add a Minimal delay on all scroll effects in Milliseconds, useful in case of e.g. smooth scroll

---

### Body Classes

```
Setting Key     : _wp_ajaxify_bodyclasses
Setting Type    : boolean
Default Value   : true
Allowed Values  : true || false
```

From this setting, you can choose to copy body attributes from target page.

You should keep this enabled in WordPress because each WordPress page has different class on body tag and some themes put different `data-` attributes in body tag.

---

### Deltas

True = deltas loaded, False = all scripts loaded

```
Setting Key     : _wp_ajaxify_deltas
Setting Type    : boolean
Default Value   : true
Allowed Values  : true || false
```

This setting allows you control the Deltas loading.

To know more about it, See [Delta-loading](https://4nf.org/delta-loading/) page.

---

### Async

```
Setting Key     : _wp_ajaxify_asyncdef
Setting Type    : boolean
Default Value   : false
Allowed Values  : true || false
```

Default async value for dynamically inserted external scripts, False = synchronous / True = asynchronous

---

### Always Hints

```
Setting Key     : _wp_ajaxify_alwayshints
Setting Type    : string
Default Value   : null
Allowed Values  : Text strings
```

From this setting, you can control files to be loaded every time around, even if you don’t control their inclusion on the server side.

To know more about it, See [Alwayshints](https://4nf.org/alwayshints/) page.

---

### Inline

True = all inline scripts loaded, False = only specific inline scripts are loaded.

```
Setting Key     : _wp_ajaxify_inline
Setting Type    : boolean
Default Value   : true
Allowed Values  : true || false
```

From this setting, you can control the how you want to execute inline scripts.
If settings is set to true then All inline scripts are re-fired, no matter what the contents of "Inline Hints" is, but excluding those specified in "Inline Skip".

To know more about it, See [Inline](https://4nf.org/inline-scripts/) page.

---

### Inline Hints

```
Setting Key     : _wp_ajaxify_inlinehints
Setting Type    : string
Default Value   : null
Allowed Values  : Text strings
```

If matched in any inline scripts - only these are executed - set "inline" to false beforehand.

To know more about it, See [Inline](https://4nf.org/inline-scripts/) page.

---

### Inline Skip

Leave empty to disable it.

```
Setting Key     : _wp_ajaxify_inlineskip
Setting Type    : string
Default Value   : adsbygoogle
Allowed Values  : Text strings
```

If matched in any inline scripts - these are NOT are executed - set "inline" to true beforehand.

To know more about it, See [Inline](https://4nf.org/inline-scripts/) page.

---

### Inline Append

```
Setting Key     : _wp_ajaxify_inlineappend
Setting Type    : boolean
Default Value   : true
Allowed Values  : true || false
```

From this setting, you can Append scripts to the main content element, instead of "eval"-ing them.

---

### Intercept Events

```
Setting Key     : _wp_ajaxify_intevents
Setting Type    : boolean
Default Value   : true
Allowed Values  : true || false
```

From this setting you can control Intercept events.

Intercept events that are fired only on classic page load and simulate their trigger on ajax page load ("DOMContentLoaded")

---

### Style

```
Setting Key     : _wp_ajaxify_style
Setting Type    : boolean
Default Value   : false
Allowed Values  : true || false
```

From this setting, you can control the style tags loading.

True = all style tags in the head loaded, False = style tags on target page ignored.

You should keep it disabled in WordPress, if you enable it might create some design conflicts.

---

### Prefetch Off

```
Setting Key     : _wp_ajaxify_prefetchoff
Setting Type    : string
Default Value   : true
Allowed Values  : true || false || Text strings
```

From this setting, you can control the pre-fetch.

Plugin pre-fetches pages on hoverIntent - true = set off completely // strings - separated by ", " - hints to select out.

To know more about it, See [Prefetch](https://4nf.org/prefetch/) page.

---

### Debugging

```
Setting Key     : _wp_ajaxify_verbosity
Setting Type    : boolean
Default Value   : false
Allowed Values  : true || false
```

You can control the console log debugging from this setting.

---

### Passcount

```
Setting Key     : _wp_ajaxify_passcount
Setting Type    : boolean
Default Value   : false
Allowed Values  : true || false
```

You can control the show number of pass for debugging from this setting.

---

### Memory Off

```
Setting Key     : _wp_ajaxify_memoryoff
Setting Type    : string
Default Value   : true
Allowed Values  : true || false || Text strings
```

From this setting you can control the Memory effect. You can set true or false or provide page urls Separated by ", "

Separated by ", " - if matched in any URLs - only these are NOT executed - set to "true" to disable memory completely.

To know more about it, See [Memory](https://4nf.org/memory/) page.

---

### Enable Loader

```
Setting Key     : _wp_ajaxify_loader_enable
Setting Type    : boolean
Default Value   : true
Allowed Values  : true || false
```

From this setting, you can turn on/off the loader.
If you enable Loader, it will appear on each page before Pronto Request.

---

### Loader Type

```
Setting Key     : _wp_ajaxify_loader_type
Setting Type    : string
Default Value   : type-1
Allowed Values  : type-1 || type-2 || type-3 || type-4 || custom
```

You can choose the loader type to be used in frontend.
If you choose Custom Loader then put your loader HTML in Loader HTML field.

---

### Loader Html

```
Setting Key     : _wp_ajaxify_loader_html
Setting Type    : string
Default Value   : null
Allowed Values  : Allowed WordPress HTML strings
```

You can add custom loader HTML in this setting, This HTML will be used when you choose `Loader type = Custom`.

If you leave this field empty after choosing the `Loader type = Custom` then Loader Type 1 will shown as your custom Loader HTML is empty.

Use `<div>`, `<span>`,`<p>` tags in setting, Don't use `<script>` and `<style>` tag in this setting, Write CSS for loader separatly in theme files or in WordPress Additional CSS.

---

### Primary Color

```
Setting Key     : _wp_ajaxify_loader_primary_color
Setting Type    : string
Default Value   : #2872fa
Allowed Values  : Any HEX color code.
```

From this setting, you can choose the primary color for the in-built loaders.

---

### Overlay Color

```
Setting Key     : _wp_ajaxify_loader_overlay_color
Setting Type    : string
Default Value   : #000000
Allowed Values  : Any HEX color code.
```

From this setting, you can choose the overlay background color for the loader.

---

### Overlay Opacity

```
Setting Key     : _wp_ajaxify_loader_overlay_opacity
Setting Type    : number
Default Value   : 0.45
Allowed Values  : Any 2 Digit Decimal value between 0 to 1
```

From this setting, you can choose the overlay background opacity for the loader.

---

### Ajaxify JS URL

```
Setting Key     : _wp_ajaxify_cdn_url
Setting Type    : string
Default Value   : null
Allowed Values  : Text Strings
```

If you want to use or test a different version of Ajaxify.js then you can use a CDN or External url in this setting. Provide JS url will load in frontend by replacing default Ajaxify.js url.

---

### Uninstall

```
Setting Key     : _wp_ajaxify_uninstall
Setting Type    : boolean
Default Value   : false
Allowed Values  : true || false
```

From this setting you can control Remove ALL WP Ajaxify data upon plugin deletion. All settings will be unrecoverable.
