# VibertClientInfo
VibertClientInfo return the User Agent information in JSON format.

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
