WP-Bootstrap2 shortcodes
========================

Shortcodes for specific Bootstrap UI Scaffolding and Components are included with the WP-Bootstrap2 theme.

 * See: [Bootstrap scaffolding](http://twitter.github.io/bootstrap/scaffolding.html)
 * See: [Bootstrap components](http://twitter.github.io/bootstrap/components.html)

_(If you code your content in HTML then you can skip these and just use the Bootstrap examples above.)_

Nesting columns
---------------

Use `[row]` to start a nested column group

Use `[one_half]`, `[one_third]`, `[two_thirds]`, `[one_fourth]` & `[three_fourths]` to generate nested columns.

 - _Optional_ attribute `class="{yourownclass}"` allows you to set a custom css class
 - _Optional_ attribute `box` creates an inner box. You can also set the inner class with `box="yourownclass"` 

Example 1:
	
	[row]
	[one_fourth]

	Content narrow left

	[/one_fourth]
	[one_half]

	Content for wide middle

	[/one_half]
	[one_fourth]

	Content narrow right

	[/one_fourth]
	[/row]

You can also use `[column]` to generate a custom width column in a fluid row.

 - *Required* attribute `span{x}`, where _'{x}'_ is 1, 2, 3 ... 12 
 - Bootstrap works in 12 column segments, so work to a sum up to 12

Example 2:
	
	[row]
	[column span7]

	Wide column left

	[/column][column span5]

	Narrow column right

	[/column]
	[/row]


Responsive visibility
---------------------

Use `[hidden]` & `[visible]` for showing and hiding content by device.

 - *Required* attribute `on="{device}"` sets devise viability, where _'{device}'_ is one of; `phone`, `tablet`, `desktop`, `all` or `none`

Example:

	[visible on="tablet"]

	This content will only display on a tablet

	[\visible]


Buttons and Button Groups
-------------------------

Use `[button]` to display a A (anchor) or BUTTON html components.  Use `buttons` to join multiple buttons together as one composite component.

 - Either `link` or `action` is _required_
   - Attribute `link="{yoururl}"` sets the button as an anchor.
   - Attribute `action="{yourcode}"` sets the button to execute JavaScript.
 - _Optional_ attribute `size="{size}"` sets the button size, where _'{size}'_ is one of: `mini`, `small` or `large`
 - _Optional_ attribute `type="{type}"` sets the button type (color), where _'{type}'_ is one of: `primary`, `danger`, `warning`, `success`, `info` & `inverse`
 - _Optional_ attribute `id="{yourownid}"` allows one to set a custom tag id
 - _Optional_ attribute `title="{yourtitle}"` allows one to set a custom tag title

Example:

	[button link="http://vinorodrigues.com" size="large" type="success"] Visit this site! [/button]

	<br/>&nbsp;<br/>

	[buttons]
	[button link="#"] 1 [/button]
	[button link="#"] 2 [/button]
	[button link="#"] 3 [/button]
	[/buttons]


Tabbable navigation
-------------------

Use `[tabs]` and `[tab]` to build tabbable sections

Example

	[tabs]
	[tab caption="One"]
	
	Content of first tab
	
	[/tab]
	[tab caption="Two"]
	
	Content of second tab
	
	[/tab]
	[/tabs]


Breaks
------

Use `[break]` to break content cleanly.  This is the same as a `<br/>` HTML tag, but Bootstrap safe.


Typographic components
----------------------

Use `[hero]` for a flexible component called a hero unit to showcase content on your site.

Example:

	[hero]
	
	This content will really stand out
	
	[/hero]


Miscellaneous
-------------
	
Use a `well` as a simple effect on an element to give it an inset effect.

 - _Optional_ attribute `size="{size}"` allows one to set a size.  Acceptable sizes are `small` and `large`

Example:

	[well]
	
	This content will be in a inset, shaded box
	
	[/well]


Inline labels and badges
------------------------

Use `[label]` to label and annotate text and a `[badge]` for displaying an indicator or count of some sort.

 - _Opptional_ attribute `type="_type_"` sets the button type (color), where _type_ is one of: `primary`, `danger`, `warning`, `success`, `info` & `inverse`
 
Example:

	[label type="success"]We won't be beaten on price![/label]

	[badge type="info"]1[/badge] First step is to ...


Alerts
------

Example:

	[alert]This is an alert[/alert]



Advanced Shortcodes
===================

There are also some additional shortcodes, including:


Equal Heights
-------------

The WP-Bootstrap2 theme includes a jQuery script to aid in equalizing the height of adjoining columns.

The `[equalheights]` shortcode activates this feature.

 - *Required* attribute `class="{tag_class}"` or `id="{tag_id}"` identifies which components to equalize.
 - _Optional_ attribute `wait="{milli_seconds}"` tells equalheights to wait a few milliseconds before calculating heights.  Use full if you have content that takes some time to load.  Default is _100_.


Example:

	[row]
	[column span4 class="well eq123"]

	This will be a long column. Lorem ipsum dolor sit amet,
	consectetur adipiscing elit. Nullam et pellentesque tortor,
	quis suscipit diam.

	[/column]
	[column span4 class="well eq123"]

	But this one is short.

	[/column]
	[column span4 class="well eq123"]

	But all three will be the same height

	[/column]
	[/row]

	[equalheights class="eq123"]


Carousel
--------

Example:

	[carousel]
	[item]<img src="/wordpress/wp-content/uploads/2013/07/chloe.jpg" width="100%" />[/item]
	[item]<img src="/wordpress/wp-content/uploads/2013/07/adriana.jpg" width="100%" />[/item]
	[caption]<h4>This is caption one</h4>[/caption]
	[caption]<h4>This is caption two</h4>[/caption]
	[/carousel]


Gallery
-------

WP-Bootstrap2 overrides the gallery shortcode, but keeps most of its functionality.

See [Gallery Shortcode on Wordpress Codex](http://codex.wordpress.org/Gallery_Shortcode)
	
In addition it adds:

 - _Optional_ attribute `singular="{0|1}"` sets the display mode
   - `singular="1"` displays the gallery as a table.
   - `singular="0"` displays the gallery as a carousel.   
 - _Optional_ wait `wait="{milli_seconds}"` tells the inner equalheights to wait a few milliseconds before calculating heights.  Default is _100_.
 - _Optional_ wait `interval="{milli_seconds}"` sets the delay between swipes.  Default is _10,000_ _(10 Seconds)_.



*
-
