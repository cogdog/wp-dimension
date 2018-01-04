# HTML5up Dimension Theme for Wordpress

A configurable Wordpress Theme version of [HTML5up Dimension Theme](https://html5up.net/dimension) made for the internet by [@cogdog](http://cog.dog). It creates a simple, elegant calling card something that looks like

![Screenshot of Theme](screenshot.png "Screenshot of Theme")

The box links below open content overlays (each is a Wordpress post) with optional links to external sites or to a Wordpress Page created on the same site:

![Sample Page](images/sample-page.jpg "Sample Page")

Now you can also create standalone WordPress pages in case you have more info than you want to show in a front box, so it can link internally to a full page.


![Static Page](images/dimension-page.jpg "Static Page")

## Examples

* Mariana Funes http://marianafun.es/
* Laura Killam http://nursekillam.com/
* Dan Zuberbier http://dpzuberbier.com/
* Kim Jaxon http://www.kimjaxon.com/me/
* Simon Thompson http://about.digis.im/
* SPLOT demo site http://splot.ca/domains2017/


## Installing from Scratch

Install this theme on any self hosted Wordpress site. No luck on Wordpress.com, get a real web hosting package.

You should download a ZIP file of this GitHub Repo (that's via the green **Clone or Download*" button above as a file `wp-dimension-master.zip`). 

The zip can be uploaded directly to your site via Add Themes in the Wordpress dashboard. Of you run into size upload limits or just prefer going old school like me, unzip the package and ftp the entire folder into your `wp-content/themes` directory.


## Installing from The Instant Mix

As a new approach for using my themes, I have set up this one as a prebuilt package that includes the theme, initial settings, plugins, and demo content. All you need to be able to do is to install a fresh Wordpress site into the location/domain you want your site.

First [download the Instant Site package file](https://github.com/cogdog/instant-splot/raw/master/noodles/dimension-wpress.zip) and expand the file to reveal the single `*.wpress` file.

Then follow the [Instant SPLOT directions for Using a Packaged Kit](https://github.com/cogdog/instant-splot#got-hosting-use-a-packaged-kit) to import into your new site.

Reference the directions below for customizing (but you have all the plugins it needs already installed). 


## Updating the Theme

If you have ftp/sftp access to your site (or this can be done in a cpanel file manager), simply upload the new theme files to the `wp-content/themes` directory that includes the older version theme. 

For those that lack direct file upload access or maybe that idea sends shivers down the spine, upload and activate the [Easy Theme and Plugin Upgrades](https://wordpress.org/plugins/easy-theme-and-plugin-upgrades/) plugin -- this will allow you to upload a newer version of a theme as a ZIP archive, the same way you add a theme by uploading.


## Customizing with the Customizer

The main elements are set and previewed in `Appearance` -> `Customize`

### Site Name and Tagline. Anything you want!
Under `Site Identity` edit to define the headline elements (leave blank to remove)

![](images/customizer-name.jpg "Customizer Name")

### It says Set Headers but it's really Set Background. So sneaky!
Under `Header Image` upload an image (recommended size 1568 x 1024 px or bigger) to place a background image

![](images/customizer-header.jpg "Header Image")

The reason we use Header image controller, is you can upload more than one image, and use the option to randomize each time.


### Front Quote and Footer
Under `Dimension Front Text` edit fields to add an optional quote (appears below tagline) and custom footer text

![](images/customizer-front-text.jpg "Front Text")

Any Footer text added will be placed before the current credits line at the bottom.

### Front Icon
Under `Dimension Logo` upload your own image. Amazing!

![](images/customizer-logo.jpg "Custom Logo")

### Social Media Icons

> **NOTE** Previous versions of this theme recommended the [Customizer Social Icons](https://wordpress.org/plugins/customizer-social-icons/) plugin but it conflicts with the current version of Wordpress and make the Customizer unusable. If you have this plugin, Deactivate it and delete it.  You will not lose your menus, just follow the instructions below to modify your menu to work with a different plugin.

To have a customized set of icon links on the front of the site, install and activate the [Font Awesome 4 Menus](https://wordpress.org/plugins/font-awesome-4-menus/) plugin. This allows you to add an icon to any menu item.

From the Wordpress Dashboard look under **Appearances** for **Menus**. Click **create a new menu**  name it whatever you like -- `social` is  a good choice. Under  **Menu Settings** next to **Display Location** check the box for `Social Media`. 

To add a social media (or any link), open the panel for **Custom Link**. 

![](images/add-custom-link.jpg "Adding Menu Items Links")

Enter a title for the site and provide the URL that points to your content on that site. Add as many as you like. You can drag and drop them to change the order.

To set the icon, you must first enable the visibility of CSS classes for each menu item.  Click **Screen Options** in the upper right, and check the box for **CSS Classes**.

![](images/screen-options.jpg "Enabling screen options for menus")

Open an item in your Social Menu and you will now see a field for entering CSS Class names. You have the choice to add from [well over 400 icons in the Font Awesome collection](http://fontawesome.io/icons/). Find the name of the icon you wish to use, and enter it's name as a CSS class with `fa-` in front. 

For example, these are the class names to render the icon for typical social media sites (these should be all lower case):

* fa-twitter
* fa-facebook
* fa-youtube
* fa-linkedin
* fa-instagram
* fa-flickr

With the Font Awesome icons, you can add any site you wish to be represented on the front page and pick the icon you prefer.

**Save** your menu and check out the spiffy icons up front.

![](images/front-icons.jpg "")

## Buttons! On the Bottom!

The content for the lower row of buttons is driven by plain old posts. You can have up to 8, but 4 or 6 look better.

For each create a post. You can use long titles.

A featured image os optional, but will appear on the content overlay. The order of the buttons is via the post sidebar option for... **Order**

![](images/post-side-edits.jpg "Sidebar edits")


## Extra "Stuff" on Posts

Look for a few more settings in  **Extra Dimension Stuff** box below the post content. The text entered in `Front Button Label` will be what is used to diplay the link in the box on the front page. If left blank, the theme will use the text of the post title. The label allows you to use a longer title when the box opens up.

You can also enter and optional link applied to the featured image and a bottom button to go to a designated URL. 

![](images/extra-dimension-stuff.jpg "Extra Stuff for posts")

Enter under `Go Button Destintion URL` the web address the bottom button should link to. You can edit the label on the button as well (if left blank it will be `Go`) The `Font Awesome Icon Button` can be changed to anything available from [Font Awesome](http://fontawesome.io/icons/). 


## Note on Featured images

The featured images displayed for each post will be scaled down to fit a size with an aspect ratio of 480px wide and 200px high. Wordpress can never scale an uploaded image large than the original

![](http://placehold.it/480x200 "Thumbnail Sizes")

**The image you upload needs to be bigger than this in both dimensions** It will be scaled and cropped to the center of the image. If you do not want to experience cropping, creating your image with the same aspect ratio (it can be larger, e.g. 960x400).

## Suggested Plugins

* [Font Awesome 4 Menus](https://wordpress.org/plugins/font-awesome-4-menus/) used to add the icons to the social media links below the tag line
* [Fluid Video Embeds](https://wordpress.org/plugins/fluid-video-embeds/) will make sure your auto embedded videos (and other content wordpress can embed by URL) are responsive sized to fill the column width
* [Easy Theme and Plugin Upgrades](https://wordpress.org/plugins/easy-theme-and-plugin-upgrades/) allows you yo update the theme by uploading the zip file again as a new server (because wordpress does not provide this capability)
* [JetPack](https://wordpress.org/plugins/jetpack/) can add a number of capabilities, such as adding a contact form. If you do [create a contact form](https://jetpack.com/support/contact-form/), make sure you also add and activate [Akismet](http://akismet.com/) because *you will get spam*
* [Regenerate Thumbnails](https://wordpress.org/plugins/regenerate-thumbnails/) If you change to this theme from another one, you should run this plug to re-generate previously uploaded images in the specific sizes used by the theme.


## Features / History

* v1.4 (Jan  3, 2018)  Deprecated use of Customizer Social Icons plugin and re-wrote instructions to use Font-Awesome 4 Menus
* v1.3 (Aug 21, 2017)  Integration of Social Media Icons for the WordPress Customizer plugin to provide a front page display of icons / links for social media sites, new post meta data field option to store an optional short name for the button display, another field to customize the link button label, CSS updates for `aligncenter`, `alignleft`, `alignright classes`, edit links added to post display.
* v1.2 (Jun 19, 2017)  Added a page template to create longer content pieces
* v1.1 (May 20, 2017) Added shortcodes for link buttons, display and show  order in the posts view of  Wordpress Editor
* v1.0 (Feb 19, 2017) First release http://cogdogblog.com/2017/02/new-dimension/

### Requests

* *you tell me* Fork and edit to suggest features or [toss them into the Issues bin](https://github.com/cogdog/wp-dimension/issues)
