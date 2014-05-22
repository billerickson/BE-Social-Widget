# BE Social Widget

A simple social widget that adds social icons for you to style.

### Supported Social URLs

* Twitter
* Facebook
* Google Plus
* LinkedIn
* Youtube
* RSS

### Reordering Socials

Use the `be_social_widget_order` filter. Ex: 

```php
<?php
 
/**
 * Change BE Social Widget Order 
 *
 * @param array $socials
 * @return array $socials
 */
function be_change_social_widget_order( $socials ) {
	return array(
			'facebook' => 'Facebook URL',
			'twitter'  => 'Twitter URL',
			'gplus'    => 'Google Plus URL',
			'linkedin' => 'LinkedIn URL',
			'youtube'  => 'Youtube URL',
			'rss'      => 'RSS URL',
		);
}
add_filter( 'be_social_widget_order', 'be_change_social_widget_order' );
```

### Adding New Socials

I only included the most used social icons since I didn't want an overwhelming UI or larger-than-necessary icon font. If you have a different social service you want added, I recommend this process:

1. Rename the plugin or bump the version number, so it's identifiably different than this repo
2. Go to icomoon.io and build an icon set that has all the social services you want (including those already in the plugin)
3. Upload your icon set to the /icons directory.
4. Modify the icon stylesheet like this: http://www.diffchecker.com/u7eeltkp
