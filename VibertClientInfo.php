<?php

	class VibertClientInfo
	{

		/* Informazioni su Indirizzo IP e Porta del Client */
		private $IP = "";
		private $Porta = "";

		/* Informazioni su Lingua e Nazione richiesta dal Client */
		private $LinguaPiuNazione = "";
		private $Lingua = "";
		private $Nazione = "";

		/* Informazioni sul Client */
		private $TipoClient = "";
		private $NomeClient = "";
		private $VersioneClient = "";
		private $FamigliaClient = "";
		private $EngineClient = "";
		private $EngineClientVersion = "";
		
		/* Informazioni sul Device */
		private $TipoDevice = "";
		private $BrandDevice = "";
		private $ModelDevice = "";

		/* Informazioni sul Sistema Operativo */
		private $NomeSO = "";
		private $VersioneSO = "";
		private $PiattaformaSO = "";
		private $FamigliaSO = "";

		/* UserAgent */
		private $UserAgent = "";
		private $ArrayUserAgent = "";

		private $ArrayKeywordNomeSO = ["Mac OS X"       => ["Macintosh", "Mac", "OS", "X"],
									   "iPhone OS"      => ["iPhone", "OS"],
									   "iPad OS"        => ["iPad", "OS"],
									   "iPod OS"        => ["iPod", "OS"],
									   "Windows"        => ["Windows"],
									   "Linux Ubuntu"   => ["Linux", "Ubuntu"],
									   "Linux"          => ["Linux"],
									   "PlayStation 4"  => ["PlayStation", "4"]];

		private $ArrayFamigliaSO = ["Macintosh" => ["Mac OS X"],
									"iOS"       => ["iPhone OS", "iPad OS", "iPod OS"],
									"Windows"   => ["Windows"],
									"Linux"     => ["Linux", "Linux Ubuntu", "PlayStation 4"]];

		private $ArrayTipoDevice = ["Desktop"    => ["Mac OS X", "Windows", "Linux", "Linux Ubuntu"],
									"Smartphone" => ["iPhone OS", "iPod OS"],
									"Tablet"     => ["iPad OS"],
									"Console"    => ["PlayStation 4"]];

		private $ArrayBrandDevice = ["Apple" => ["Mac OS X", "iPhone OS", "iPad OS", "iPod OS"],
									 "Sony"  => ["PlayStation 4"]];

		private $ArrayModelDevice = ["Mac OS X"      => "Mac",
									 "iPhone OS"     => "iPhone",
									 "iPad OS"       => "iPad",
									 "iPod OS"       => "iPod",
									 "PlayStation 4" => "PlayStation 4"];

		private $ArrayBrowserEngine = ["NetFront", "Edge", "Trident", "Blink", "AppleWebKit", "Presto", "Gecko", "KHTML"];

		private $ArrayPiattaformaSO = ["x64" => ["Intel", "Win64", "x64", "WOW64", "IA64", "x86.64"],
									   "x86" => ["Win32", "x86"],
									   "Arm" => ["Arm", "armv7l"]];

		private $ArrayNomeClient = ["PlayStation" => "PlayStation Browser",
									"Chromium"    => "Chromium",
									"Chrome"      => "Chrome",
									"CriOS"       => "Chrome for iOS",
									"Safari"      => "Safari",
									"Trident/7.0" => "Internet Explorer",
									"Trident/6.0" => "Internet Explorer",
									"MSIE 10.0"   => "Internet Explorer",
									"Trident/5.0" => "Internet Explorer",
									"MSIE 9.0"    => "Internet Explorer",
									"Trident/4.0" => "Internet Explorer",
									"MSIE 8.0"    => "Internet Explorer",
									"MSIE 7.0"    => "Internet Explorer",
									"MSIE 6.0"    => "Internet Explorer"];

		private $ArrayFamigliaClient = ["Safari"              => ["Safari"],
										"Chrome"              => ["Chrome", "Chromium", "Chrome for iOS"],
										"PlayStation Browser" => ["PlayStation Browser"],
										"Internet Explorer"   => ["Internet Explorer"]];

		private $ArrayTipoClient = ["Browser" => ["Safari", "Chrome", "Chromium", "PlayStation Browser", "Chrome for iOS", "Internet Explorer"]];
		
		public function VibertClientInfo($_UserAgent = "", $_LinguaPiuNazione = "", $_IP = "", $_Porta = "")
		{
			$this->Reset();

			if ($_UserAgent != "")        { $this->setUserAgent($_UserAgent);               }
			if ($_LinguaPiuNazione != "") { $this->setLinguaPiuNazione($_LinguaPiuNazione); }
			if ($_IP != "")               { $this->setIP($_IP);                             }
			if ($_Porta != "")            { $this->setPorta($_Porta);                       }

			$this->setLingua();
			$this->setNazione();

			$this->ArrayUserAgent = $this->UserAgent;
			$this->ArrayUserAgent = str_replace(";", "", $this->ArrayUserAgent);
			$this->ArrayUserAgent = str_replace("(", "", $this->ArrayUserAgent);
			$this->ArrayUserAgent = str_replace(")", "", $this->ArrayUserAgent);
			$this->ArrayUserAgent = str_replace(",", "", $this->ArrayUserAgent);
			$this->ArrayUserAgent = str_replace("_", ".", $this->ArrayUserAgent);

			$this->ArrayUserAgent = explode(" ", $this->ArrayUserAgent);

			foreach ($this->ArrayUserAgent as $key => $value) 
			{
				$this->ArrayUserAgent[$key] = explode("/", $value);
			}

			$this->setNomeClient();
			$this->setNomeSO();
			$this->setPiattaformaSO();
			$this->setBrowserEngine();

			/* Aggiungere ulteriori comandi QUI. */
		}

		private function Reset()
		{
			$this->IP = isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : "";
			$this->Porta = isset($_SERVER["REMOTE_PORT"]) ? $_SERVER["REMOTE_PORT"] : "";
			$this->LinguaPiuNazione = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? $_SERVER["HTTP_ACCEPT_LANGUAGE"] : "";
			$this->Lingua = "";
			$this->Nazione = "";
			$this->TipoClient = "";
			$this->NomeClient = "";
			$this->VersioneClient = "";
			$this->FamigliaClient = "";
			$this->EngineClient = "";
			$this->EngineClientVersion = "";
			$this->TipoDevice = "";
			$this->BrandDevice = "";
			$this->ModelDevice = "";
			$this->NomeSO = "";
			$this->VersioneSO = "";
			$this->PiattaformaSO = "";
			$this->FamigliaSO = "";
			$this->UserAgent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : "";
			$this->ArrayUserAgent = "";
		}

		public function getClientInfo()
		{
			$retVal = ["IP"                  => $this->getIP(),
					   "Porta"               => $this->getPorta(),
					   "Lingua"              => $this->getLingua(),
					   "Nazione"             => $this->getNazione(),
					   "TipoClient"          => $this->getTipoClient(),
					   "NomeClient"          => $this->getNomeClient(),
					   "VersioneClient"      => $this->getVersioneClient(),
					   "FamigliaClient"      => $this->getFamigliaClient(),
					   "EngineClient"        => $this->getBrowserEngine(),
					   "EngineClientVersion" => $this->getBrowserEngineVersion(),
					   "TipoDevice"          => $this->getTipoDevice(),
					   "BrandDevice"         => $this->getBrandDevice(),
					   "ModelDevice"         => $this->getModelDevice(),
					   "NomeSO"              => $this->getNomeSO(),
					   "VersioneSO"          => $this->getVersioneSO(),
					   "PiattaformaSO"       => $this->getPiattaformaSO(),
					   "FamigliaSO"          => $this->getFamigliaSO(),
					   "UserAgent"           => $this->getUserAgent(),
					   "LinguaPiuNazione"    => $this->getLinguaPiuNazione()];

			$retVal = json_encode($retVal, JSON_PRETTY_PRINT);

			return $retVal;
		}

		private function ArrayExistValue($_Value)
		{
			foreach ($this->ArrayUserAgent as $Key => $Value)
			{
				foreach ($this->ArrayUserAgent[$Key] as $Key1 => $Value1) 
				{
					if (strcmp($Value1, $_Value) === 0)
					{
						return true;
					}
				}
			}

			return false;
		}

		private function setUserAgent($_UserAgent)               { $this->UserAgent = $_UserAgent; }
		public  function getUserAgent()                          { return $this->UserAgent;        }

		private function setLinguaPiuNazione($_LinguaPiuNazione) { $this->LinguaPiuNazione = $_LinguaPiuNazione; }
		public  function getLinguaPiuNazione()                   { return $this->LinguaPiuNazione;               }

		private function setIP($_IP)                             { $this->IP = $_IP;               }
		public  function getIP()                                 { return $this->IP;               }

		private function setPorta($_Porta)                       { $this->Porta = $_Porta;         }
		public  function getPorta()                              { return $this->Porta;            }

		private function setLingua()                             { $this->Lingua = strtolower(substr($this->LinguaPiuNazione, 0, 2)); }
		public  function getLingua()                             { return $this->Lingua;                                              }

		private function setNazione()                            { $this->Nazione = strtolower(substr($this->LinguaPiuNazione, strpos($this->LinguaPiuNazione, "-") + 1, 2)); }
		public  function getNazione()                            { return $this->Nazione;                                                                                     }

		private function setNomeSO()
		{
			foreach ($this->ArrayKeywordNomeSO as $Key => $Value) 
			{
				$retVal = true;

				foreach ($this->ArrayKeywordNomeSO[$Key] as $Key1 => $Value1) 
				{
					if (!$this->ArrayExistValue($Value1))
					{
						$retVal = false;
					}
				}

				if ($retVal)
				{
					$this->NomeSO = $Key;
					$this->setVersioneSO();
					$this->setFamigliaSO($Key);
					$this->setTipoDevice($Key);
					$this->setBrandDevice($Key);
					$this->setModelDevice($Key);
					return;
				}
			}

			$this->NomeSO = "Unknown";
			$this->VersioneSO = "Unknown";
			$this->FamigliaSO = "Unknown";
			$this->TipoDevice = "Unknown";
			$this->BrandDevice = "Unknown";
			$this->ModelDevice = "Unknown";
		}

		public function getNomeSO()                              { return $this->NomeSO; }

		private function setVersioneSO()
		{
			if (strcmp($this->NomeSO, "Mac OS X") === 0)
			{
				$PosizioneVersioneSOInizio = strpos($this->UserAgent, "Mac OS X") + 9;
				$PosizioneVersioneSOFine = strpos($this->UserAgent, ")");
				$this->VersioneSO = str_replace("_", ".", substr($this->UserAgent, $PosizioneVersioneSOInizio,  $PosizioneVersioneSOFine - $PosizioneVersioneSOInizio));
			}
			else if (strcmp($this->NomeSO, "iPhone OS") === 0)
			{
				$PosizioneVersioneSOInizio = strpos($this->UserAgent, "iPhone OS") + 10;
				$PosizioneVersioneSOFine = strpos($this->UserAgent, "like Mac OS X") - 1;
				$this->VersioneSO = str_replace("_", ".", substr($this->UserAgent, $PosizioneVersioneSOInizio,  $PosizioneVersioneSOFine - $PosizioneVersioneSOInizio));
			}
			else if (strcmp($this->NomeSO, "iPad OS") === 0 || strcmp($this->NomeSO, "iPod OS") === 0)
			{
				$PosizioneVersioneSOInizio = strpos($this->UserAgent, "CPU OS") + 7;
				$PosizioneVersioneSOFine = strpos($this->UserAgent, "like Mac OS X") - 1;
				$this->VersioneSO = str_replace("_", ".", substr($this->UserAgent, $PosizioneVersioneSOInizio,  $PosizioneVersioneSOFine - $PosizioneVersioneSOInizio));
			}
			else if (strcmp($this->NomeSO, "PlayStation 4") === 0)
			{
				$PosizioneVersioneSOInizio = strpos($this->UserAgent, "PlayStation 4") + 14;
				$PosizioneVersioneSOFine = strpos($this->UserAgent, ")");
				$this->VersioneSO = substr($this->UserAgent, $PosizioneVersioneSOInizio,  $PosizioneVersioneSOFine - $PosizioneVersioneSOInizio);
			}
			else if (strcmp($this->NomeSO, "Windows") === 0)
			{
				if (strpos($this->UserAgent, "Windows NT 10.0") !== false)
				{
					$this->VersioneSO = "10";
				}
				else if (strpos($this->UserAgent, "Windows NT 6.3") !== false)
				{
					$this->VersioneSO = "8.1";
				}
				else if (strpos($this->UserAgent, "Windows NT 6.2") !== false)
				{
					$this->VersioneSO = "8";
				}
				else if (strpos($this->UserAgent, "Windows NT 6.1") !== false)
				{
					$this->VersioneSO = "7";
				}
				else if (strpos($this->UserAgent, "Windows NT 6.0") !== false)
				{
					$this->VersioneSO = "Vista";
				}
				else if (strpos($this->UserAgent, "Windows NT 5.2") !== false)
				{
					$this->VersioneSO = "XP";
				}
				else if (strpos($this->UserAgent, "Windows NT 5.1") !== false)
				{
					$this->VersioneSO = "XP";
				}
				else if (strpos($this->UserAgent, "Windows NT 5.01") !== false)
				{
					$this->VersioneSO = "2000 (SP1)";
				}
				else if (strpos($this->UserAgent, "Windows NT 5.0") !== false)
				{
					$this->VersioneSO = "2000";
				}
				else if (strpos($this->UserAgent, "Windows NT 4.0") !== false)
				{
					$this->VersioneSO = "NT 4.0";
				}
				else if (strpos($this->UserAgent, "Windows 98; Win 9x 4.90") !== false)
				{
					$this->VersioneSO = "ME";
				}
				else if (strpos($this->UserAgent, "Windows 98") !== false)
				{
					$this->VersioneSO = "98";
				}
				else if (strpos($this->UserAgent, "Windows 95") !== false)
				{
					$this->VersioneSO = "95";
				}
				else if (strpos($this->UserAgent, "Windows CE") !== false) 
				{
				    $this->VersioneSO = "CE";
				}
				else
				{
					$this->VersioneSO = "Unknown";
				}
			}
			else
			{
				$this->VersioneSO = "Unknown";
			}
		}

		public function getVersioneSO()							 { return $this->VersioneSO; }

		private function setFamigliaSO($_NomeSO)
		{ 
			foreach ($this->ArrayFamigliaSO as $Key => $Value)
			{
				foreach ($this->ArrayFamigliaSO[$Key] as $Key1 => $Value1) 
				{
					if (strcmp($Value1, $_NomeSO) === 0)
					{
						$this->FamigliaSO = $Key;
						return $Key;
					}
				}
			}
		}

		public function getFamigliaSO()                          { return $this->FamigliaSO; }

		private function setTipoDevice($_NomeSO)
		{ 
			foreach ($this->ArrayTipoDevice as $Key => $Value)
			{
				foreach ($this->ArrayTipoDevice[$Key] as $Key1 => $Value1) 
				{
					if (strcmp($Value1, $_NomeSO) === 0)
					{
						$this->TipoDevice = $Key;
						return;
					}
				}
			}

			if (strpos($this->UserAgent, "Mobile") !== false) 
			{
				$this->TipoDevice = "Smartphone";
			}
		}

		public function getTipoDevice()                          { return $this->TipoDevice; }

		private function setBrandDevice($_NomeSO)
		{ 
			foreach ($this->ArrayBrandDevice as $Key => $Value)
			{
				foreach ($this->ArrayBrandDevice[$Key] as $Key1 => $Value1) 
				{
					if (strcmp($Value1, $_NomeSO) === 0)
					{
						$this->BrandDevice = $Key;
						return;
					}
				}
			}

			$this->BrandDevice = "Unknown";
		}

		public function getBrandDevice()                         { return $this->BrandDevice; }

		private function setModelDevice($_NomeSO)
		{ 
			if ($this->getBrandDevice() != "Unknown")
			{
				$this->ModelDevice = $this->ArrayModelDevice[$_NomeSO]; 
			}
			else
			{
				$this->ModelDevice = "Unknown";
			}
		}

		public function getModelDevice()                         { return $this->ModelDevice; }

		private function setBrowserEngine()
		{
			$retVal = false;

			foreach ($this->ArrayBrowserEngine as $Key => $Value) 
			{
				if (!$retVal)
				{
					foreach ($this->ArrayUserAgent as $Key2 => $Value2)
					{
						foreach ($this->ArrayUserAgent[$Key2] as $Key1 => $Value1) 
						{
							if (strcmp($Value1, $Value) === 0)
							{
								$this->EngineClient = $Value;
								$retVal = true;
								$_Key1 = $Key1;
								$_Key2 = $Key2;
							}
						}
					}
				}
				else
				{
					break;
				}
			}

			if ($retVal)
			{
				if (array_key_exists($_Key1 + 1, $this->ArrayUserAgent[$_Key2]))
				{
					$this->setBrowserEngineVersion($this->ArrayUserAgent[$_Key2][$_Key1 + 1]);
				}
				else
				{
					$this->setBrowserEngineVersion("Unknown");
				}
			}
			else
			{
				$this->EngineClient = "Unknown";
				$this->EngineClientVersion = "Unknown";
			}
		}

		public function getBrowserEngine()                       { return $this->EngineClient; }

		private function setBrowserEngineVersion($_Version)      { $this->EngineClientVersion = $_Version; }
		public function getBrowserEngineVersion()				 { return $this->EngineClientVersion;      }

		private function setVersioneClient($_NomeClient)
		{
			$retVal = false;

			foreach ($this->ArrayUserAgent as $Key2 => $Value2)
			{
				foreach ($this->ArrayUserAgent[$Key2] as $Key1 => $Value1) 
				{
					if (strcmp($Value1, "Version") === 0)
					{
						$retVal = true;
						$_Key1 = $Key1;
						$_Key2 = $Key2;
						break;
					}
				}
			}

			if ($retVal)
			{
				if (array_key_exists($_Key1 + 1, $this->ArrayUserAgent[$_Key2]))
				{
					$this->VersioneClient = $this->ArrayUserAgent[$_Key2][$_Key1 + 1];
				}
				else
				{
					$this->VersioneClient = "Unknown";
				}
			}
			else
			{
				$this->VersioneClient = "Unknown";
			}

			if (strcmp($this->getVersioneClient(), "Unknown") === 0)
			{
				if (strpos($this->UserAgent, "Trident/7.0") !== false) 
				{
				    $this->VersioneClient = "11";
				}
				else if (strpos($this->UserAgent, "Trident/6.0") !== false || strpos($this->UserAgent, "MSIE 10.0") !== false) 
				{
				    $this->VersioneClient = "10";
				}
				else if (strpos($this->UserAgent, "Trident/5.0") !== false || strpos($this->UserAgent, "MSIE 9.0") !== false) 
				{
				    $this->VersioneClient = "9";
				}
				else if (strpos($this->UserAgent, "Trident/4.0") !== false || strpos($this->UserAgent, "MSIE 8.0") !== false) 
				{
				    $this->VersioneClient = "8";
				}
				else if (strpos($this->UserAgent, "MSIE 7.0") !== false) 
				{
				    $this->VersioneClient = "7";
				}
				else if (strpos($this->UserAgent, "MSIE 6.0") !== false) 
				{
				    $this->VersioneClient = "6";
				}
			}

			if (strcmp($this->getVersioneClient(), "Unknown") === 0)
			{
				$retVal = false;

				foreach ($this->ArrayUserAgent as $Key2 => $Value2)
				{
					foreach ($this->ArrayUserAgent[$Key2] as $Key1 => $Value1) 
					{
						if (strcmp($Value1, $_NomeClient) === 0)
						{
							$retVal = true;
							$_Key1 = $Key1;
							$_Key2 = $Key2;
							break;
						}
					}
				}

				if ($retVal)
				{
					if (array_key_exists($_Key1 + 1, $this->ArrayUserAgent[$_Key2]))
					{
						$this->VersioneClient = $this->ArrayUserAgent[$_Key2][$_Key1 + 1];
					}
					else
					{
						$this->VersioneClient = "Unknown";
					}
				}
				else
				{
					$this->VersioneClient = "Unknown";
				}
			}
		}

		public function getVersioneClient()						 { return $this->VersioneClient; }

		private function setPiattaformaSO()
		{
			foreach ($this->ArrayPiattaformaSO as $Key => $Value) 
			{
				foreach ($this->ArrayPiattaformaSO[$Key] as $Key1 => $Value1) 
				{
					if ($this->ArrayExistValue($Value1))
					{
						$this->PiattaformaSO = $Key;
						return;
					}
				}
			}

			if (strcmp($this->getNomeSO(), "PlayStation 4") === 0)
			{
				$this->PiattaformaSO = "x64";
			}
			else
			{
				$this->PiattaformaSO = "Unknown";
			}
		}

		public function getPiattaformaSO()						 { return $this->PiattaformaSO; }

		private function setNomeClient()
		{
			foreach ($this->ArrayNomeClient as $Key => $Value) 
			{
				if (strpos($this->UserAgent, $Key) !== false)
				{
					$this->NomeClient = $Value;
					$this->setVersioneClient($Key);
					$this->setFamigliaClient($Value);
					$this->setTipoClient($Value);
					return;
				}
			}

			$this->NomeClient = "Unknown";
			$this->VersioneClient = "Unknown";
			$this->FamigliaClient = "Unknown";
			$this->TipoClient = "Unknown";
		}

		public function getNomeClient()							 { return $this->NomeClient; }

		private function setFamigliaClient($_NomeClient)
		{
			foreach ($this->ArrayFamigliaClient as $Key => $Value)
			{
				foreach ($this->ArrayFamigliaClient[$Key] as $Key1 => $Value1) 
				{
					if (strcmp($Value1, $_NomeClient) === 0)
					{
						$this->FamigliaClient = $Key;
						return $Key;
					}
				}
			}

			$this->FamigliaClient = "Unknown";
		}

		public function getFamigliaClient()						 { return $this->FamigliaClient; }

		private function setTipoClient($_NomeClient)
		{
			foreach ($this->ArrayTipoClient as $Key => $Value)
			{
				foreach ($this->ArrayTipoClient[$Key] as $Key1 => $Value1) 
				{
					if (strcmp($Value1, $_NomeClient) === 0)
					{
						$this->TipoClient = $Key;
						return;
					}
				}
			}

			$this->TipoClient = "Unknown";
		}

		public function getTipoClient()						 	 { return $this->TipoClient; }

		/* Aggiungere ulteriori funzioni QUI. */
	}
  
?>
