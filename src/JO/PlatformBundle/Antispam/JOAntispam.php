<?php
// src/JO/PlatformBundle/Antispam/JOAntispam.php

namespace JO\PlatformBundle\Antispam;

class JOAntispam
{
	/**
	* Vérifie si le texte est un spam ou non
	*
	* @param string $text
	* @return bool
	*/
	public function isSpam($text)
	{
		 return strlen($text) < 50;
	}
}