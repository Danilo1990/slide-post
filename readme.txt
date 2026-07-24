=== CalaSlide – Posts Carousel for Elementor ===
Contributors: danicala23
Tags: elementor, slider, carousel, posts, slick
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Display your WordPress posts in a responsive Slick-based carousel, right inside Elementor.

== Description ==

CalaSlide adds a custom Elementor widget that displays your posts (or any public post type) as a responsive slider/carousel powered by Slick.

**Features**

* Show posts as a slider/carousel with arrows and dots navigation
* Choose what to display per item: featured image, title, excerpt, categories, read-more button
* Control slides to show and slides to scroll, with separate desktop/tablet/mobile values
* Full styling controls: typography, colors, spacing, borders, shadows — everything from the Elementor panel
* Works with the free version of Elementor (simple query controls) and unlocks the full Elementor Pro query builder when Pro is active
* Compatible with the Elementor Theme Builder
* All assets are bundled locally — no external CDN calls

**Requirements**

* Elementor 3.5 or newer (free version is enough)
* Elementor Pro is optional: when active, the widget uses the native Pro query builder (include/exclude, taxonomies, related queries)

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`, or install it from the Plugins screen directly.
2. Activate the plugin through the "Plugins" screen in WordPress.
3. Edit a page with Elementor and look for the **Slide Post** widget in the **DC Plugin** category.

== Frequently Asked Questions ==

= Does it require Elementor Pro? =

No. The widget works with the free version of Elementor using its built-in query options (post type, order). If Elementor Pro is active, the widget automatically switches to the full Pro query builder.

= Can I show custom post types? =

Yes, any public post type can be selected.

= Can I use more than one slider on the same page? =

Yes, each widget instance is initialized independently.

== Screenshots ==

1. The widget in the Elementor panel with content options.
2. A posts carousel on the frontend.

== Changelog ==

= 1.1.0 =
* Security: all dynamic output is now properly escaped (button text, term names, image URLs).
* Fixed: fatal error when Elementor Pro is not installed — the widget now falls back to basic query controls.
* Fixed: multiple widget instances on the same page no longer re-initialize each other.
* Changed: Slick assets are now bundled locally instead of being loaded from a CDN.
* Changed: assets are loaded only on pages that actually use the widget.
* Changed: migrated to the current Elementor registration APIs (Elementor 3.5+).
* Fixed: consistent text domain, translation-ready.

= 1.0.0 =
* First release.

== Upgrade Notice ==

= 1.1.0 =
Security and compatibility release: update recommended for all users. Existing pages and widget settings are preserved.
