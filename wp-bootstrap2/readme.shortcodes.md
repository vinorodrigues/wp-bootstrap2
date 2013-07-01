Bootstrap shortcodes
====================

Shortcodes for specific Bootstrap UI Scaffolding and Components are included.


 * See: [Bootstrap scaffolding](http://twitter.github.io/bootstrap/scaffolding.html)
 * See: [Bootstrap components](http://twitter.github.io/bootstrap/components.html)

_(If you code your content in HTML then you can skip these and just use the Bootstrap examples above.)_

Nesting columns
---------------

Use `[row]` to start a nested column group

Use `[one_half]`, `[one_third]`, `[two_thirds]`, `[one_fourth]` & `[three_fourth]` to generate nested columns.

 - _Opptional_ attribute `class="yourownclass"` allows you to set a custom css class
 - _Opptional_ attribute `box` creates an inner box. You can also set the inner class with `box="yourownclass"` 

You can also use `[column]` to generate a custom width column.

 - _Required_ attribute `span{x}`, where _'{x}'_ is 1, 2, 3 ... 12 

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

 - Whitespaces between the shortcodes will also output, so place your rows and columns flush: _e.g._ <code>[row][one_half] xxx</code>
 - Bootstrap works in 12 column segments, so you may see a _gap_ when your column widths plus the side bar do not sum up to a divisor of 12



Responsive visibility
---------------------

Use `[hide]` & `[show]` for showing and hiding content by device.

 - *Required* attribute `on="_device_"` sets devise visability, where _device_ is one of; `phone`, `tablet`, `desktop`, `all` or `none`

Example:

	[show on="tablet"]

	This content will only display on a tablet

	[\show]


Buttons and Button Groups
-------------------------

Use `[button]` to display a A (anchor) or BUTTON html components.  Use `button_group` to join multiple buttons together as one composite component.

 - _Opptional_ attribute `link="_yoururl_"` sets the button as an anchor.
 - _Opptional_ attribute `size="_size_"` sets the button size, where _size_ is one of: `mini`, `small` or `large`
 - _Opptional_ attribute `type="_type_"` sets the button type (color), where _type_ is one of: `primary`, `danger`, `warning`, `success`, `info` & `inverse`
 - _Opptional_ attribute `id="_yourownif_"` allows one to set a custom tag id
 - _Opptional_ attribute `title="_yourtitle_"` allows one to set a custom tag title

Example:

	[button link="http://en.wp.obenland.it/the-bootstrap/" size="large" type="success"] Visit this site! [/button]

	[button_group]
	[button] 1 [/button]
	[button] 2 [/button]
	[button] 3 [/button]
	[/button_group]

### Tabbable navigation

Use `[tab_group]` and `[tab]` to build tabbable sections

Example

	[tab_group]
	[tab caption="One"]
	
	Content of first tab
	
	[/tab]
	[tab caption="Two"]
	
	Content of second tab
	
	[/tab]
	[/tab_group]


Breaks
------

Use `[break]` to break


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

Inline labels and badges
------------------------

Use `[label]` to label and annotate text and a `[badge]` for displaying an indicator or count of some sort.

 - _Opptional_ attribute `type="_type_"` sets the button type (color), where _type_ is one of: `primary`, `danger`, `warning`, `success`, `info` & `inverse`
 
