<?php

return [
	'providers' => [
    	// Other providers
    	Jaktech\Anaphora\AnaphoraServiceProvider::class,
	],
	'aliases' => [
    	'Anaphora' => Jaktech\Anaphora\Facades\AnaphoraFacade::class,
	],
];