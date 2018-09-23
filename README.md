# Vibert Client Info
Vibert Client Info returns all information contained in User Agent in JSON format.

Example of use:

```php
...

$ClientInfo = new VibertClientInfo();
$AssociativeArray = json_decode($ClientInfo->getClientInfo(), true);

var_dump($AssociativeArray);

echo $AssociativeArray["IP"]                  . "<br>";
echo $AssociativeArray["Porta"]               . "<br>";
echo $AssociativeArray["Lingua"]              . "<br>";
echo $AssociativeArray["Nazione"]             . "<br>";
echo $AssociativeArray["TipoClient"]          . "<br>";
echo $AssociativeArray["NomeClient"]          . "<br>";
echo $AssociativeArray["VersioneClient"]      . "<br>";
echo $AssociativeArray["FamigliaClient"]      . "<br>";
echo $AssociativeArray["EngineClient"]        . "<br>";
echo $AssociativeArray["EngineClientVersion"] . "<br>";
echo $AssociativeArray["TipoDevice"]          . "<br>";
echo $AssociativeArray["BrandDevice"]         . "<br>";
echo $AssociativeArray["ModelDevice"]         . "<br>";
echo $AssociativeArray["NomeSO"]              . "<br>";
echo $AssociativeArray["VersioneSO"]          . "<br>";
echo $AssociativeArray["PiattaformaSO"]       . "<br>";
echo $AssociativeArray["FamigliaSO"]          . "<br>";
echo $AssociativeArray["UserAgent"]           . "<br>";
echo $AssociativeArray["LinguaPiuNazione"]    . "<br>";

...
```
