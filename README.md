# VibertClientInfo
VibertClientInfo returns all information contained in User Agent in JSON format.

Example os use:

```php
...

$ClientInfo = new VibertClientInfo();
$Array = $ClientInfo->getClientInfo();

echo "<pre>";
echo $Array;
echo "</pre>";

...
```
