<?php

return [
	'providers' => [
    	// Other providers
    	Jaktech\Anaphora\AnaphoraServiceProvider::class,
	],
	'aliases' => [
    	'Anaphora' => Jaktech\Anaphora\AnaphoraFacade::class,
	],
];