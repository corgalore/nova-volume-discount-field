# Nova Volume Discount Field

### A Volume Discount field component package for the Laravel Nova admin.

Add/remove rows of discount levels and optionally columns of discount tiers. Saves values into convenient JSON format.

### Versions

 - Designed for Nova v3.x
 
### Installation
 
For now install by cloning the repo and linking in your composer.json file.
 
### Examples
 
##### Example 01 - Multiple price break rows and session length tiers
  
![Rows and Tiers](/docs/example-01.jpg?raw=true "Example 01")
 
<br/>
 
##### Example 02 - A single tier with 2 price break levels
  
![Showing a single tier](/docs/example-02.jpg?raw=true "Example 02")
 
<br/>

##### Data 01 - The JSON data stored by the field

![The field value](/docs/data-01.jpg?raw=true "The JSON data stored by the field")

<br/>

### Usage

```php
public function fields( Request $request ) {
    return [
        VolumeDiscount::make('Volume Discounts')
            ->qtyColumnHeading('Qty')
            ->discountColumnHeading('Tier')
            ->maxTiers(4)
    ];
}
```