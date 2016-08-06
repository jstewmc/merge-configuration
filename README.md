# squash-config-directory
Squash a configuration directory.

It's much eaiser to _create_ your configuration settings when they're grouped into separate, logical files. However, it's much easier to _read_ your configuration settings when they're grouped into a single object.

This library will squash all the files in a directory into a single configuration instance. 

Keep in mind, how the files are merged is up to you. You can use any algorithm you'd like when you implement the `Config` interface. For example, you could use `array_merge()` or an intelligent, recursive algorithm provided by your framework.

## Example

For this example, we'll create two configuration files in the `/path/to` directory (`foo.php` and `bar.php`); we'll implement the `Config` interface in the `Foo` class; and, we'll put this library to use.

### /path/to/foo.php

The first configuration file:

```php
return [
    'foo' => 'bar'  
];
```

### /path/to/bar.php

The second configuration file:

```php
return [
    'bar' => 'baz'  
];
```

### `Config` implementation

We'll use a simple `array_merge()` for our merging algorithm in our `Config` implementation:

```php
use Jstewmc\SquashConfigDirectory;

class Foo implements Config
{
    public $config;
    
    public function merge(array $config)
    {
        $this->config = array_merge($this->config, $config);
        
        return;   
    }
}
```

### Put it to use

Finally, we can put our library to use:

```php
use Jstewmc\SquashConfigDirectory;

// instantiate a new config object (Foo was defined in example above)
$config = new Foo();

// squash the '/path/to' configuration directory
$config = (new Squash())('/path/to', $config);

// print the configuration
print_r($config->config);
```

The example above would produce something similar to the following output:

```
[
    "foo" => "bar", 
    "bar" => "baz"   
]
```

That's about it!

## Author

[Jack Clayton](mailto:clayjs0@gmail.com)

## License

[MIT](https://github.com/jstewmc/squash-config-directory)

## Version

### 0.1.0, August 6, 2016

* Initial release


